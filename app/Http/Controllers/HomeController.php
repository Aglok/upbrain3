<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

class HomeController extends UserHomeController
{

    public function __construct()
    {
        $this->isAdmin = false;
        $this->template_profile = 'users.home';
        $this->middleware('auth');
    }

    /**
     * Создаём кабинет ученика
     * @param Guard::$auth
     * @return \View
     *
     */
    public function index(Guard $auth)
    {
        //Получим id залогиненного пользователя
        $user_id = $auth->user()->getAuthIdentifier();

        //Закидываем данные в шаблон view/users/home.blade.php
        return $this->userProfile('math', $user_id);
    }

}