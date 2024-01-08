<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterMail;
use App\Models\Contact;
use App\Models\Newsletter;
use App\Models\UserNewsletter;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Request;
use Response;
use AdminSection;
use Mail;
use Illuminate\Support\Facades\Input;
use Throwable;

class NewsletterController extends Controller
{
    /**
     * Выводит в вид данные о пользователях
     *
     * @return Factory|View
     * @throws Throwable
     */
    public function index()
    {
        $columns = [
            'id' => '' ,
            'firstname' => 'Имя' ,
            'lastname' => 'Фамилия' ,
            'email' => 'Почта' ,
            'group' => 'Группа' ,
            'type_of_training' => 'Тип обучения' ,
           // 'is_sent' => 'Состояние',
        ];

//        $rows = DB::table('users as u')
//            //->leftJoin('newsletters_users', 'u.id', '=', 'newsletters_users.user_id')
//            ->select(['u.id','u.name','u.surname','u.email','u.group'])
//            ->orderBy('id', 'ASC')
//            ->get();

        $rows = Contact::select('id' , 'firstname', 'lastname' , 'email', 'subjects', 'type_of_training')->get();
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
                //$name = explode(' ', $name);
                
                $email = $recipient->email;
                //$group = $recipient->group;

                Mail::to($email)->later($timeSend, new NewsletterMail($name, $body, $email, $mail_from, $subject, $path_files, $dir));

                UserNewsletter::create([
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
