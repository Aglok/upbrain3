<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User_Vk;

class ContactController extends Controller
{
    public function prizeUsers(Request $request){

        if($request->ajax()) {

            $vk_id = $request->get('user_id');
            $domain = $request->get('domain');
            $href = $request->get('href');
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $nickname = $request->get('nickname');
            $gen_code = rand(1255227, 7999563);


            $vk_user = \DB::table('users_vk')->where('vk_id', $vk_id)->first();

            if($vk_user){
                return response()->json('Вы уже получили свой номер: <span class="text-white">'.$vk_user->gen_code.'</span>');
            }else{
                User_Vk::create(
                    [
                        'vk_id' => $vk_id,
                        'domain' => $domain,
                        'href' => $href,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'nickname' => $nickname,
                        'gen_code' => $gen_code
                    ]
                );

                //$url = 'https://api.vk.com/method/messages.send?user_id='.$vk_id.'&message=Ваш код Upbrain: '.$gen_code.'выиграй бесплатные курсы&v=5.37&access_token=c804bf03c804bf03c804bf03eac82a14decc804c804bf0391ad5bb9e0ae469e1e93c9ff';
                $params = array(
                    'user_id' => $vk_id,    // Кому отправляем
                    'message' => 'Ваш купон: '.$gen_code,   // Что отправляем
                    'access_token' => 'c804bf03c804bf03c804bf03eac82a14decc804c804bf0391ad5bb9e0ae469e1e93c9ff',  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
                    'v' => '5.37',
                );
                $url = 'https://api.vk.com/method/messages.send?'.http_build_query($params);
                return response()->json('Билет номер: <span class="text-dark">'.$gen_code.'</span>');
            }
        }
    }
    
    public function saveContact(Request $request){

        if($request->ajax()) {
            $name = $request->get('name');
            $phone = $request->get('phone');
            $email = $request->get('email');
            $friend = $request->get('friend');

            if(!$email) $email = 'email@upbrain.ru';
            if($friend)
                $friend = 'С другом';
            else
                $friend = 'Без друга';

            $body = 'Имя: ' . $name . ' Почта: ' . $email . ' Телефон: ' . $phone  . ' Привести друга: ' . $friend;

            $mail_to = 'email@upbrain.ru';

            \Mail::raw($body, function ($message) use ($mail_to, $email, $name, $body) {
                $message->from($email, $name);
                $message->to($mail_to)->subject('Письмо для upbrain.ru');
            });

           Contact::create(
                [
                    'name' => $name,
                    'phone'   => $phone,
                    'email'      => $email,
                    'friend'    => $friend
                ]
            );
            return response()->json($request->all());
        }
    }
}
