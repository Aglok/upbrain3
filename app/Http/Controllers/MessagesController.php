<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Input;
use Session;
use App\Services\PusherWrapper as Pusher;
use App\User;
use Request;
use Response;
use App\Helpers\Common as Common;
use Illuminate\Support\Facades\Storage;

class MessagesController extends Controller
{
    /**
     * @var Pusher
     */
    protected Pusher $pusher;

    /**
     * @var string
     * Директория для upload изображения
     */
    public string $dir = 'messages';

    public function __construct(Pusher $pusher)
    {
        $this->middleware('auth');
        $this->pusher = $pusher;
    }
    /**
     * Show all the message threads to the user.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $currentUserId = Auth::user()->id;

        // Получить все ветви текущего пользователя и участников
        $threads = Thread::forUser($currentUserId)->get();
        
        return view('chat.thread', compact('threads', 'currentUserId'));

    }
    /**
     * Shows a message thread.
     *
     * @param $id
     * @return Application|array|RedirectResponse|Redirector
     */
    public function show($id)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'Обсуждение с ID: ' . $id . ' не найдена.');
            return redirect('messages');
        }
        // don't show the current user in list
        $userId = Auth::user()->id;
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();
        $thread->markAsRead($userId);

        $htmlMessages = view('chat.messages', compact('thread'))->render();
        $htmlUsers = view('chat.participants', compact('thread', 'users'))->render();

        return ['htmlMessages' => $htmlMessages, 'htmlUsers' => $htmlUsers];
        //return view('messenger.show', compact('thread', 'users'));
    }
    /**
     * Creates a new message thread.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.create', compact('users'));
    }
    /**
     * Stores a new message thread.
     *
     * @return JsonResponse
     */
    public function store()
    {

        $input = Input::all();
        $thread = Thread::create(
            [
                'subject' => $input['subject'],
            ]
        );
        // Message
        $message = Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'body'      => $input['message'],
            ]
        );
        // Sender
        Participant::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
                'last_read' => new Carbon,
            ]
        );
        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants($input['recipients']);
        }
        $this->oooPushIt($message);

        return Response::json('Ваша тема успешно опубликована!');
    }
    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        if(Request::ajax()){
            
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'Обсуждение с ID: ' . $id . ' не найдена.');
            return redirect('messages');
        }
        $thread->activateAllParticipants();


        // Изображения
        $objImages = $this->uploadImage('images');

        // Message
        $message = Message::create(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'body'      => Input::get('message'),
                'images'    => $objImages->images,
                'dir'       => $objImages->dir
            ]
        );
        // Add replier as a participant
        $participant = Participant::firstOrCreate(
            [
                'thread_id' => $thread->id,
                'user_id'   => Auth::user()->id,
            ]
        );
        $participant->last_read = new Carbon;
        $participant->save();

        // Recipients
        if (Input::has('recipients')) {
            $thread->addParticipants(Input::get('recipients'));
        }
        //return redirect('messages/' . $id);


            $this->oooPushIt($message);

            return Response::json([
                    'Файлы успешно загружены!',
                    'html' => view('chat.html-message', compact('message', 'thread'))->render()//Добавили переменную thread
            ]);
        }
    }

    /**
     * Принимаем изображение в base64, получает тело создаём название
     * Загружает полученные изображения в storage/messages
     * @param $name
     *
     * @return string
     */
    public function uploadImage($name){

        $strImageName = '';

        //Транслитерируем в латиницу
        $full_name = Common::translit(Auth::user()->full_name);
        $dir = $this->dir.'/'.$full_name;

        if(Input::has($name)){

            $images = Request::input($name);

            foreach ($images as $n => $image):

                $imageName = $this->genNameImage($n, $image);

                $strImageName.= $imageName.'|';

                //Директория messages/name_surname

                //Для image->save($path) путь куда нужно сохранить изображение
                $path = public_path('images/'.$dir.'/'.$imageName);

                //Создаём директорию 755
                if (!Storage::disk('images')->exists($dir)) {
                    Storage::disk('images')->makeDirectory($dir);
                }

                 $this->fitImage($image, 800, 800, $path);

            endforeach;
        }

        return (Object)['images' => substr($strImageName, 0, -1), 'dir' => $dir];
    }
    /**
     * Изменяет размер изображения
     * @param $image
     * @param $width
     * @param $height
     * @param $path
     *
     * @return Image
     */
    public function fitImage($image, $width, $height, $path){

        return Image::make($image)->fit($width, $height)->save($path);
    }

    /**
     * Генерация имени файла с сохранением расширения
     * @param $n
     * @param $imageBody
     * @return string
     */
    public function genNameImage($n, $imageBody){

        $fileName = date("dmy_His").'_'.$n;

        // определяем формат файла
        preg_match('#data:image\/(png|jpg|jpeg|gif);#', $imageBody, $fileTypeMatch);
        $fileType = $fileTypeMatch[1];

        return $fileName . '.' . $fileType;
    }

    /**
     * Send the new message to Pusher in order to notify users.
     *
     * @param Message $message
     */
    protected function oooPushIt(Message $message)
    {
        $thread = $message->thread;
        $sender = $message->user;
        $data = [
            'thread_id' => $thread->id,
            'div_id' => 'thread_' . $thread->id,
            'sender_name' => $sender->name,
            'thread_url' => route('messages.show', ['id' => $thread->id]),
            'thread_subject' => $thread->subject,
            'html' => view('chat.html-message', compact('message', 'thread'))->render(),//Добавили переменную thread
            'text' => str_limit($message->body, 50),
        ];
        $recipients = $thread->participantsUserIds();
        if (count($recipients) > 0) {
            foreach ($recipients as $recipient) {
                if ($recipient == $sender->id) {
                    continue;
                }
                $this->pusher->trigger('for_user_' . $recipient, 'new_message', $data);
            }
        }
    }
    /**
     * Mark a specific thread as read, for ajax use.
     *
     * @param $id
     */
    public function read($id)
    {
        $thread = Thread::find($id);
        if (!$thread) {
            abort(404);
        }
        $thread->markAsRead(Auth::id());
    }
    /**
     * Get the number of unread threads, for ajax use.
     *
     * @return array
     */
    public function unread()
    {
        $count = Auth::user()->newThreadsCount();
        return ['msg_count' => $count];
    }
}