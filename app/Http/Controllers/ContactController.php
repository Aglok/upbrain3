<?php

namespace App\Http\Controllers;

use App\Mail\FormRegistrationMail;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\UserVk;
use App\Mail\MeetMail;
use App\Mail\TrialExamMail;
use App\Mail\CoursesMail;

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
                UserVk::create(
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
            $type = $request->get('type');
            $subject = $request->get('subject');
            $link = $request->get('link');

            $special_offer = '';
            $subjects = [];
            $type_of_training = [];
            $schools = [];
            $individual = '';

            if($request->has('special_offer')){
                $special_offer = $request->get('special_offer');
            }
            if($request->has('subjects')){
                $subjects = $request->get('subjects');
            }
            if($request->has('type_of_training')){
                $type_of_training = $request->get('type_of_training');
            }
            if($request->has('schools')){
                $schools = $request->get('schools');
            }
            if($request->has('individual')){
                $individual = $request->get('individual');
            }


            $subjects = implode(',', $subjects);
            $type_of_training = implode(',', $type_of_training);
            $schools = implode(',', $schools);

            if(!$email) $email = 'email@upbrain.ru';

            if($special_offer)
                $special_offer = 'Хочет получить специальное предложение от 2х предметов';
            if($individual)
                $individual = 'Хочет индивидуальное занятие';

            $body =  ($type ? $type .'; ' :'') .
                ($subject ? $subject .'; ' :'') .
                ($link ? ' Класс ' . $link .'; ' :'') .
                ' Имя: ' . $name . ';' .
                ' Почта: ' . $email . ';' .
                ' Телефон: ' . $phone  . ';' .
                ' Дополнительно: ' . $special_offer . ';' .
                ($subjects ? ' Предметы: ' . $subjects.'; ':'') .
                ($type_of_training ? ' Тип обучения: ' . $type_of_training.'; ':'') .
                ($schools ? ' Школы: ' . $schools.'; ':'') .
                ' Занятие: ' . $individual;

            // $mail_to = 'email@upbrain.ru';
            $mail_to = 'upbrainschool@gmail.com';


            \Mail::raw($body, function ($message) use ($mail_to, $email, $name, $body) {
                $message->from($email, $name);
                $message->to($mail_to)->subject('Письмо для upbrain.ru');
            });

            if(!isset($type)) $type  = '';

            if($type == 'Webinar')
                \Mail::to($email)->send(new MeetMail($email));
            elseif($type == 'ege' || $type == 'oge')
                \Mail::to($email)->send(new CoursesMail($name, $email, $type, $subject));
            elseif($type == 'trial_exam' || $type == 'intensive_exam')
                \Mail::to($email)->send(new TrialExamMail($email));
            else
                \Mail::to($email)->send(new CoursesMail($name, $email, $type, $subject));

           Contact::create(
                [
                    'firstname' => $name,
                    'phone'   => $phone,
                    'email'      => $email,
                    // 'special_offer'    => $special_offer,
                    'type' => $type,
                    'subjects' => $subjects,
                    'link' => $link,
                    'type_of_training' => $type_of_training,
                    'schools' => $schools,
                    'individual' => $individual
                ]
            );
            return response()->json($request->all());
        }
    }

    public function getForm(){
        return view('form_registration');
    }

    public function saveForm(Request $request){

        if($request->ajax()) {
            $name = $request->get('name');
            $surname = $request->get('surname');
            $patronymic = $request->get('patronymic');
            $phone = $request->get('phone');
            $email = $request->get('email');
            $subjects = $request->get('subjects');
            $type_of_training = $request->get('type_of_training');
            $hei = $request->get('hei');
            $points = $request->get('points');
            $place = $request->get('place');
            $additionally = $request->get('additionally');

            $subjects = implode(',', $subjects);
            $type_of_training = implode(',', $type_of_training);

            if(!$email) $email = 'email@upbrain.ru';

            $body =
                ' Имя: ' . $name .'; ' .
                ' Фамилия: ' . $surname .'; ' .
                ($surname ? ' Фамилия: ' . $surname.'; ':'') .
                ($patronymic ? ' Отчество: ' . $patronymic.'; ':'') .
                ' Почта: ' . $email.'; ' .
                ' Телефон: ' . $phone.'; ' .
                ($subjects ? ' Предметы: ' . $subjects.'; ':'') .
                ($type_of_training ? ' Тип обучения: ' . $type_of_training.'; ':'') .
                ($hei ? ' ВУЗ: ' . $hei .'; ':'') .
                ($points ? ' Баллы: ' . $points.'; ':'') .
                ($place ? ' Место: ' . $place.'; ':'') .
                ($additionally ? ' Дополнительно: ' . $additionally.'; ':'');

            //$mail_to = 'email@upbrain.ru';
            $mail_to = 'upbrainschool@gmail.com';

            \Mail::raw($body, function ($message) use ($mail_to, $email, $name, $body) {
                $message->from($email, $name);
                $message->to($mail_to)->subject('Письмо для upbrain.ru');
            });

            \Mail::to($email)->send(new FormRegistrationMail($name, $email));

            Contact::create(
                [
                    'firstname' => $name,
                    'lastname' => $surname,
                    'patronymic' => $patronymic,
                    'phone'   => $phone,
                    'email'      => $email,
                    'subjects'      => $subjects,
                    'type_of_training'      => $type_of_training,
                    'hei'      => $hei,
                    'points'      => $points,
                    'place'      => $place,
                    'additionally'      => $additionally,
                ]
            );
            return response()->json($request->all());
        }
    }
}
