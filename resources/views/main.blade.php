<!DOCTYPE html>
<html>
<head>
    @include('site.header', ['title' => '','keywords' => '', 'description' => '', 'image' => ''])
</head>
<body class="swag-line">
    <div class="header-menu"></div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Ой!</strong> Что-то пошло не так.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-overflow-wrap">

        <div class="container-main"></div>
        {{-- Фиксированное меню --}}
        <div id="navbar-fixed-top" class="navbar-toggleable-md hidden-lg-down">
            <div class="container">
                <div class="navbar-collapse" id="global-nav">
                    <a class="navbar-brand-fixed" href="/">
                        <img src="{!! asset('images/bg/header/header_logo_fixed.png') !!}" alt="Upbrain - курсы подготовки ЕГЭ и ОГЭ">
                    </a>
                    <div class="navbar-right">
                        <ul class="navbar-nav">
                            <li>
                                <a href="lp_junior_classes">Для 5-8 класса</a>
                            </li>
                            <li>
                                <a href="lp_ege">Курсы ЕГЭ</a>
                            </li>

                            <li>
                                <a href="lp_oge">Курсы ОГЭ</a>
                            </li>
                            <li>
                                <a href="reviews">Отзывы</a>
                            </li>
                            <li>
                                <a href="our_history">О нас</a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="#our_course">Наши курсы</a>--}}
                            {{--</li>--}}

{{--                            <li>
                                <a href="#subjects">Предметы</a>
                            </li>--}}

                            {{--<li>--}}
                                {{--<a href="compare">Кто мы?</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="trial_exam">Полное тестирование</a>--}}
                            {{--</li>--}}
{{--
                            <li>
                                <a href="#contacts">Контакты</a>
                            </li> --}}
                            <li>
                                <button data-toggle="modal" data-target="#contact-modal" class="btn">Записаться на урок</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Панель header --}}
        <div class="container">
            {{-- Боковое мобильное меню --}}
            <nav class="navmenu navmenu-default navmenu-fixed-right offcanvas">
                <a class="navbar-brand-fixed" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="lp_junior_classes">Для 5-8 класса</a>
                    </li>
                    <li class="list-group-item">
                        <a href="lp_ege">Курсы ЕГЭ</a>
                    </li>

                    <li class="list-group-item">
                        <a href="lp_oge">Курсы ОГЭ</a>
                    </li>

                    <li class="list-group-item">
                        <a href="reviews">Отзывы</a>
                    </li>
                    <li class="list-group-item">
                        <a href="our_history">О нас</a>
                    </li>

{{--                    <li class="list-group-item">
                        <a href="#our_course">Наши курсы</a>
                    </li>--}}

{{--                    <li class="list-group-item">
                        <a href="#subjects">Предметы</a>
                    </li>--}}

{{--                    <li class="list-group-item">
                        <a href="compare">Кто мы?</a>
                    </li>
                    <li class="list-group-item">
                       <a href="trial_exam">Полное тестирование</a>
                    </li>--}}

{{--                     <li class="list-group-item">
                        <a href="#contacts">Контакты</a>
                    </li> --}}
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
            <nav class="navbar navbar-toggleable-md navbar-inverse">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggler navbar-toggler-right collapsed" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body">
                        <span class="fa fa-bars"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
                </div>
                {{-- Верхнее меню --}}
                <div class="navbar-collapse collapse" id="global-nav">
                    <div class="navbar-right">
                        <ul class="navbar-nav mr-auto">
                            <li>
                                <a href="lp_junior_classes">Для 5-8 класса</a>
                            </li>
                            <li>
                                <a href="lp_ege">Курсы ЕГЭ</a>
                            </li>

                            <li>
                                <a href="lp_oge">Курсы ОГЭ</a>
                            </li>
                            <li>
                                <a href="reviews">Отзывы</a>
                            </li>
                            <li>
                                <a href="our_history">О нас</a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="#our_course">Наши курсы</a>--}}
                            {{--</li>--}}

{{--                            <li>
                                <a href="#subjects">Предметы</a>
                            </li>--}}

                            {{--<li>--}}
                                {{--<a href="compare">Кто мы?</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="trial_exam">Полное тестирование</a>--}}
                            {{--</li>--}}
{{--
                            <li>
                                <a href="#contacts">Контакты</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                {{-- Контакт --}}
                <div class="contact">
                    <p class="tel">
                    {{-- <a href="tel:+7916804-76-25">+7(916)804-76-25</a><br>
                    <a href="tel:+79295173303">+7(929)517-33-03</a>
                    </br>
                    </br>
                    --}}
                    </p>
                    <button data-toggle="modal" data-target="#contact-modal" class="btn">Заказать звонок</button>
                </div>
            </nav>
            {{-- Заголовки --}}
            <div class="hero hero-main main">
                <div class="header-title-left">
                    <h4 class="text-hero text-hero-1 text-white">Курсы Upbrain - успех в учёбе</h4>
                    <h4 class="text-hero text-hero-3 text-white"><span>Высокие стандарты преподавания</span>
                    </h4>
                </div>
                <div class="header-title-right">
                    <h1 class="hero-header text-hero-3">метро Чистые пруды, Краснопресненская</h1>
                </div>
            </div>
            {{-- Иконки наши курсы --}}
            <div class="container-wrap-course row-padded homepage-grid p-t">
                <div class="row text-center">
                    <div class="col-md-4">
                        <a href="lp_ege" class="m-r header-box-icon">
                            <img class="our-courses-icon" data-toggle="modal" data-target="#block-1" src="{!! asset('images/bg/icon_main/course_ege.png') !!}" alt="Курсы ЕГЭ 10 и 11 классы">
                            <h3 class="font-lite our-courses-text text-white">Курсы ЕГЭ<br>10 и 11 классы</h3>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="lp_oge" class="m-r header-box-icon">
                            <img class="our-courses-icon" data-toggle="modal" data-target="#block-2" src="{!! asset('images/bg/icon_main/course_oge.png') !!}" alt="Курсы ОГЭ 8 и 9 классы">
                            <h3 class="font-lite our-courses-text text-white">Курсы ОГЭ<br>8 и 9 классы </h3>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="lp_junior_classes" class="m-r header-box-icon">
                            <img class="our-courses-icon" data-toggle="modal" data-target="#block-3" src="{!! asset('images/bg/icon_main/school_thinking.png') !!}" alt="Школа мышления с 6 класса">
                            <h3 class="font-lite our-courses-text text-white">Для детей<br>с 6 до 15 лет</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Мы команда--}}
        {{--@include('site.command')--}}
        {{-- Расти вместе с драконом--}}
        {{--@include('site.growth_with_us')--}}
        {{-- Создатели --}}
        @include('site.creators')
        {{-- Подготовка к ЕГЭ по предметам --}}
        {{--@include('site.subjects')--}}
        {{--@include('site.comments')--}}
        {{-- Форма обратной связи --}}
        @include('site.form_static', ['id' => 'form-bottom'])
        {{-- // Форма обратной связи --}}
        <div id="our_course" class="font-light container">

        </div>
    </div>

    <!-- Модальное окно для видео -->
    <div class="modal fade" id="fun-learning-video">
        <div class="modal-dialog">
            <div class="modal-content">
                {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>--}}
                <iframe width="100%" height="315px" src="https://www.youtube.com/embed/u9bO9yLLCKo" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
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
{{--                                <div class="checkbox">
                                    {!! Form::label('friend', 'Прийду с другом и получить 50% скидки') !!}
                                    {!! Form::input('checkbox', 'friend') !!}
                                </div>--}}
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
    @include('site.footer')
</body>

</html>