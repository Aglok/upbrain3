<!DOCTYPE html>
<html>
<head>
    @include('site.header', ['title' => '','keywords' => '', 'description' => '', 'image' => ''])
    <!-- Vk API -->
    <script src="https://vk.com/js/api/openapi.js?146" type="text/javascript"></script>
    <!-- /Vk API -->
</head>
<body class="swag-line">
<div class="header-menu"></div>

<input hidden="hidden" name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-overflow-wrap">
        <div class="container-gz"></div>
        {{-- Фиксированное меню --}}
        <div id="navbar-fixed-top" class="navbar-toggleable-md hidden-lg-down">
            <div class="container">
                <div class="navbar-collapse" id="global-nav">
                    <img src="{!! asset('images/bg/header/header_logo_fixed.png') !!}" alt="Upbrain - курсы подготовки ЕГЭ и ОГЭ">
                    <div class="navbar-right">
                        <ul class="navbar-nav">
                            <li>
                                <a href="lp_ege">Курсы ЕГЭ</a>
                            </li>

                            <li>
                                <a href="lp_oge">Курсы ОГЭ</a>
                            </li>

                            <li>
                                <a href="#our_course">Наши курсы</a>
                            </li>

                            <li>
                                <a href="#subjects">Предметы</a>
                            </li>

                            <li>
                                <a href="master_class">Мастер класс</a>
                            </li>

                            <li>
                                <a href="#contacts">Контакты</a>
                            </li>
                            <li>
                                <button data-toggle="modal" data-target="#contact-modal" class="btn">Бесплатный урок</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Панель header --}}
        <div class="container">
            {{-- Боковое мобильное меню --}}
            <nav class="navmenu navmenu-default navmenu-fixed-right offcanvas" role="navigation">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="lp_ege">Курсы ЕГЭ</a>
                    </li>

                    <li class="list-group-item">
                        <a href="lp_oge">Курсы ОГЭ</a>
                    </li>

                    <li class="list-group-item">
                        <a href="#our_course">Наши курсы</a>
                    </li>

                    <li class="list-group-item">
                        <a href="#subjects">Предметы</a>
                    </li>

                    <li class="list-group-item">
                        <a href="master_class">Мастер класс</a>
                    </li>

                    <li class="list-group-item">
                        <a href="#contacts">Контакты</a>
                    </li>
                    <li class="list-group-item">
                        @if(Auth::check())
                            <a class="check" data-toggle="" data-target="" href="auth/logout">Выйти</a>
                        @else
                            <a class="check" data-toggle="modal" data-target="#login-modal" href="#">Войти</a>
                            <a class="check" data-toggle="modal" data-target="#registration-modal" href="#">Регистрация</a>
                        @endif
                    </li>
                </ul>
            </nav>
            {{-- Верхняя панель --}}
            <nav class="navbar navbar-toggleable-md navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggler navbar-toggler-right collapsed" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
                </div>
                {{-- Верхнее меню --}}
                <div class="navbar-collapse collapse" id="global-nav">
                    <div class="navbar-right">
                        <ul class="navbar-nav mr-auto">
                            <li>
                                <a href="lp_ege">Курсы ЕГЭ</a>
                            </li>

                            <li>
                                <a href="lp_oge">Курсы ОГЭ</a>
                            </li>

                            <li>
                                <a href="#our_course">Наши курсы</a>
                            </li>

                            <li>
                                <a href="#subjects">Предметы</a>
                            </li>

                            <li>
                                <a href="master_class">Мастер класс</a>
                            </li>

                            <li>
                                <a href="#contacts">Контакты</a>
                            </li>
                            {{--<li>--}}
                            {{--@if(Auth::check())--}}
                            {{--<a data-toggle="" data-target="" href="auth/logout">Выйти</a>--}}
                            {{--@else--}}
                            {{--<a data-toggle="modal" data-target="#login-modal" href="#">Войти</a>--}}
                            {{--<a data-toggle="modal" data-target="#registration-modal" href="#">Регистрация</a>--}}
                            {{--@endif--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </div>
                {{-- Контакт --}}
                <div class="contact">
                    <p class="tel">+7(499)391-48-15<br>+7(929)5173303</p>
                    <button data-toggle="modal" data-target="#contact-modal" class="btn">Заказать звонок</button>
                </div>
            </nav>
            {{-- Заголовки --}}
            <div class="hero hero-homepage">
                <div class="header-title-left">
                    <h1 class="text-hero text-hero-1 text-white">Выиграй год бесплатной</h1>
                    <h2 class="text-hero text-hero-2 text-white"><span>Подготовки к ЕГЭ</span></h2>
                    <div class="text-hero text-hero-2 text-white" id="btn-auth"><span>Получить код</span></div>
                    <div>
                        <p id="gen-name"></p>
                        <p id="gen-code"></p>
                    </div>
                </div>
            </div>

            {{-- Форма обратной связи --}}
            <div class="row row-backbordered m-b-lg">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-floating panel-floating-inline">
                        <div class="panel-body">
                            <div class="panel-content">
                                <h5 class="m-b-0"><strong>Оставьте заявку - сделайте первый шаг на пути к успеху</strong></h5>
                                <p class="text-subscribe"><small>Полную инструкцию вы получите на почту</small></p>
                            </div>
                            <div class="panel-actions">
                                <div class="col-md-12">
                                    {!! Form::open(['id' =>'form-top' ,'url'=>'contact', 'method' => 'post', 'class'=>'form-inline'])!!}
                                    <div class="form-group">
                                        {!! Form::text('name', '',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Ваше имя', 'required' => 'required']) !!}
                                        {!! Form::text('phone','',  ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Телефон', 'required' => 'required']) !!}
                                        {!! Form::email('email', old('email'), ['class'=>'form-control input-lg col-md-3', 'placeholder' => 'Email', 'required' => 'required']) !!}
                                        {!! Form::submit('Записаться', ['class'=>'form-control input-lg btn btn-lg col-md-2'])!!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- // Форма обратной связи --}}
        </div>
        {{-- Кратко о сути нашего дела --}}
        @include('site.advantage')
        {{-- Подготовка к ЕГЭ по предметам --}}
        @include('site.subjects')
        {{-- Карусель отзывы --}}
        @include('site.comments')
        {{-- Что мы предлагаем --}}
        @include('site.process')
        {{-- Стоимость занятий--}}
        @include('site.price')
        {{-- FAQ --}}
        @include('site.faq')
    </div>
        <!-- Модальное окно для формы -->
        <div class="modal fade" id="contact-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Оставить заявку</h3>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['id' => 'form-modal', 'url'=>'contact', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                        <div class="m-x m-y row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::text('name', '',  ['class'=>'form-control', 'placeholder' => 'Ваше имя']) !!}
                                    {!! Form::text('phone','',  ['class'=>'form-control', 'placeholder' => 'Телефон']) !!}
                                    {!! Form::email('email', old('email'), ['class'=>'form-control', 'placeholder' => 'Email']) !!}
                                    <div class="checkbox">
                                        {!! Form::label('friend', 'Прийду с другом и получить 50% скидки') !!}
                                        {!! Form::input('checkbox', 'friend') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                {!! Form::submit('Записаться', ['class'=>'btn btn-block btn-primary'])!!}
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Модальное окно для входа в личный кабинет -->
        <div class="modal fade" id="login-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Авторизация</h3>
                    </div>
                    <div class="modal-body">
                        <div class="m-x m-y row">
                            <div class="col-md-6" style="border-right: 1px solid #ddd;">
                                {!! Form::open(['url'=>'/auth/login', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                                <div class="form-group">
                                    {!! Form::email('email', old('email'), ['class'=>'form-control']) !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                    <div class="checkbox">
                                        {!! Form::label('remember', 'запомнить') !!}
                                        {!! Form::input('checkbox', 'remember') !!}
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label><a href="/auth/reset">Я забыл пароль</a></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="social-buttons">
                                    <a href="login/vkontakte" class="login-button login-button-vk">
                                        <i class="fa fa-vk"></i>
                                    </a>
                                    <a href="login/odnoklassniki" class="login-button login-button-ok">
                                        <i class="fa fa-odnoklassniki"></i>
                                    </a>
                                    <a href="login/facebook" class="login-button login-button-fb">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="login/google" class="login-button login-button-gPlus">
                                        <i class="fa fa-google"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                {!! Form::submit('Вход', ['class'=>'btn btn-block btn-primary'])!!}
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
        <!-- Модальное окно для регистрации пользователя -->
        <div class="modal fade" id="registration-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Регистрация</h3>
                    </div>
                    <div class="modal-body">
                        <div class="m-x m-y row">
                            <div class="col-md-6" style="border-right: 1px solid #ddd;">
                                {!! Form::open(['url'=>'/auth/registration', 'method' => 'post', 'class'=>'form-horizontal'])!!}
                                <div class="form-group">
                                    {!! Form::text('name','', ['class'=>'form-control', 'placeholder' => 'Имя']) !!}
                                    {!! Form::email('email', old('email'), ['class'=>'form-control']) !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                    {!! Form::text('phone','', ['class'=>'form-control', 'placeholder' => 'Ваш телефон']) !!}
                                    <br>
                                    <div class="checkbox">
                                        {!! Form::label('info', 'Получать актуальную информацию') !!}
                                        {!! Form::input('checkbox', 'info') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="social-buttons">
                                    <a href="login/vkontakte" class="login-button login-button-vk">
                                        <i class="fa fa-vk"></i>
                                    </a>
                                    <a href="login/odnoklassniki" class="login-button login-button-ok">
                                        <i class="fa fa-odnoklassniki"></i>
                                    </a>
                                    <a href="login/facebook" class="login-button login-button-fb">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a href="login/google" class="login-button login-button-gPlus">
                                        <i class="fa fa-google"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
                                {!! Form::submit('Зарегистрироваться', ['class'=>'btn btn-block btn-primary'])!!}
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    @include('site.footer')
</body>

{!! Html::script('js/aglok/vk.form.js') !!}
</html>