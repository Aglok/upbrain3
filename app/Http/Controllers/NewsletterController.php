<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\Newsletter_User;
use DB;
use App\User;
use Request;
use Response;
use AdminSection;
use Mail;
use Illuminate\Support\Facades\Input;

class NewsletterController extends Controller
{
    /**
     * Выводит в вид данные о пользователях
     *
     * @return \View
     */
    public function index()
    {
        $columns = [
            'id' => '' ,
            'full_name' => 'Имя' ,
            'email' => 'Почта' ,
            'group' => 'Группа' ,
           // 'is_sent' => 'Состояние',
        ];

        $rows = DB::table('users as u')
            //->leftJoin('newsletters_users', 'u.id', '=', 'newsletters_users.user_id')
            ->select(['u.id','u.name','u.surname','u.email','u.group'])
            ->orderBy('id', 'ASC')
            ->get();

        $count = User::count();

        $view = view('admin.newsletters.newsletters', [
            'count' => $count,
            'columns' => $columns,
            'rows' => $rows
        ]);

        return AdminSection::view($view->renderSections()["innerContent"], '');
    }

    public function getMessage(){

        if(Request::ajax()){

            $mail_type = Input::get('mail-type');
            $mail_from = Input::get('mail-from');
            $subject = Input::get('subject');
            $body = Input::get('body');
            $timeSend = 500;//Время задержки между отпраками в сек
            $path_files = '';
            $dir = '';

            if(Input::hasFile('files')) {

                $files = Input::file('files');

                if(count($files)){

                    $dir = public_path('files/' . date("d.m.y"));

                    foreach ($files as $n => $file):

                        $fileName = $this->genNameFile($n, $file);

                        //Если последний элемент массива, убираем '|'
                        $file == end($files) ? $path_files.= $fileName : $path_files.= $fileName.'|';

                        //Директория files/date
                        $file->move($dir, $fileName);
                     endforeach;
                }
            }
            
            $jsonListRecipients = json_decode(Input::get('jsonListRecipients'));

            $newsletter = Newsletter::create(
                [
                    'sender_name' => \Auth::user()->name,
                    'subject' => $subject,
                    'body' => $body,
                    'path_files' => $path_files,
                    'dir' => $dir,
                    'mail_type' => $mail_type,
                    'mail_from' => $mail_from,
                    'emails_total' => count($jsonListRecipients),
                    //'emails_sent' => $emails_sent
                ]

            );

            foreach ($jsonListRecipients as $recipient):

                $user_id = $recipient->id;
                $name = $recipient->name;

                //Вытаскиваем Имя из строки Имя Фамилия
                $name = explode(' ', $name);
                
                $email = $recipient->email;
                $group = $recipient->group;

                Mail::later($timeSend, 'admin.email.tasks',
                    [
                    'name' => $name[1],
                    'body' => $body,
                    ],
                    function($message) use ($mail_from, $subject, $email, $path_files, $dir) {
                        
                        $message->from($mail_from, 'Артём Валерьевич');
                        $message->to($email)->subject($subject);

                        if($path_files && $dir){
                            $path_files_array = explode('|', $path_files);

                            for ($i=0; $i < count($path_files_array); $i++){
                                $message->attach($dir.'/'.$path_files_array[$i]);
                            }
                        }
                    }
                );

                Newsletter_User::create([
                    'user_id' => $user_id,
                    'newsletter_id' => $newsletter->id,
                    'is_sent' => 1,
                ]);
            endforeach;

        }

        return Response::json(compact('mail_type', 'mail_from', 'subject', 'body', 'path_files', 'jsonListRecipients'));
    }
    
    public function genNameFile($n, $file){

        $fileName = date("dmy_His").'_'.$n;
        
        return $fileName . '.' . $file->getClientOriginalExtension();
    }
}
