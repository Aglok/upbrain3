<!DOCTYPE html>
<html>
<head>
    @include('site.header', ['title' => $page->title,'keywords' => $page->keywords, 'description' => $page->description, 'image' => ''])
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

        {{-- Если галочка убрать блоки стоят то не показывает --}}
        @if(!$page->no_blocks)
            @section('image-header')
                <div class="container-gz"></div>
            @show
        @elseif($page->no_blocks && $page->class_image_header)
            @section('image-header')
                <div class="{{$page->class_image_header}}"></div>
            @show
        @endif

        @section('fixed-menu')
            {{-- Фиксированное меню --}}
            @if(is_array($menu))
            <div id="navbar-fixed-top" class="navbar-toggleable-md hidden-lg-down">
                <div class="container">
                    <div class="navbar-collapse" id="global-nav">
                        <img src="{!! asset('images/bg/header/header_logo_fixed.png') !!}" alt="Upbrain - курсы подготовки ЕГЭ и ОГЭ">
                        <div class="navbar-right">
                            <ul class="navbar-nav">
                                @include('site.menu', ['items' => $menu->roots(), 'list' => ''])
                                <li>
                                    <button data-toggle="modal" data-target="#contact-modal" class="btn">Бесплатный урок</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @show
        
        {{-- Панель header --}}
        <div class="container">

            @section('top-panel')
                {{-- Верхняя панель --}}
                <nav class="navbar navbar-toggleable-md navbar-inverse">
                    <div class="navbar-header">
                        @if($menu->first())
                        <button type="button" class="navbar-toggler navbar-toggler-right collapsed" data-toggle="offcanvas" data-target=".navmenu" data-canvas="body">
                            <span class="fa fa-bars"></span>
                        </button>
                        @endif
                        <a class="navbar-brand" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
                    </div>

                    {{-- Боковое мобильное меню --}}
                    @if($menu->first())
                    <nav class="navmenu navmenu-default navmenu-fixed-right offcanvas">
                        <a class="navbar-brand-fixed" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
                        <ul class="list-group">


                            @include('site.menu', ['items' => $menu->roots(), 'list' => 'list-group-item'])

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
                    @endif

                    {{-- Верхнее меню --}}
                    @if($menu->first())

                    <div class="navbar-collapse collapse" id="global-nav">
                        <div class="navbar-right">
                            <ul class="navbar-nav mr-auto">
                                    {{-- $menu->roots() - получаем только родительские элементы меню --}}
                                    @include('site.menu', ['items' => $menu->roots(), 'list' => ''])
                            </ul>
                        </div>
                    </div>
                    @endif
                    {{-- Контакт --}}
                    <div class="contact">
                        {{-- <p class="tel"><a href="tel:+79168047625">+7(916)804-76-25</a>
                        <br>
                        <a href="tel:+79295173303">+7(929)517-33-03</a></p>
                        </br>
                        --}}
                        <button data-toggle="modal" data-target="#contact-modal" class="btn">Заказать звонок</button>
                    </div>
                </nav>
            @show

            {{-- Если галочка убрать блоки стоят то не показывает --}}
            @if(!$page->no_blocks_title)

                @section('title')
                    {{-- Заголовки --}}
                    <div class="hero hero-homepage m-t-md">
                        {{--<h4 class="text-white m-r">Искусство обучения - дорого в будущее</h4>--}}
                        <div class="header-title-left text-white" {{($page->style) ? "style=".str_replace(" ", "", $page->style) : ''}}>
                            <h1 class="text-hero text-hero-1" {{($page->style_title) ? "style=".str_replace(" ", "", $page->style_title) : ''}}>{{$page->title}}</h1>
                            <h1 class="text-hero text-hero-3" {{($page->style_title_4U) ? "style=".str_replace(" ", "", $page->style_title_4U) : ''}}>{{$page->title_4U}}</h1>
                        </div>
                        {{-- Если заголовок включен, а блоки выключены --}}
                        @if($page->no_blocks)
                            {{-- Форма обратной связи --}}
                            @include('site.form_universal', ['id' => 'form-email', 'type' => $page->type, 'subject' => $page->subject])
                            {{-- // Форма обратной связи --}}
                        @endif
                    </div>
                @show
            @else
                <div class="text-lg-center" {{($page->style) ? "style=".$page->style : ''}}>
                    <h1 {{($page->style_title) ? "style=".$page->style_title : ''}}>{{$page->title}}</h1>
                    <h2 {{($page->style_title_4U) ? "style=$page->style_title_4U" : ''}}>{{$page->title_4U}}</h2>
                </div>
            @endif
        </div>

        {{-- Если галочка убрать блоки стоят то не показывает --}}
        @if(!$page->no_blocks)

            @section('form-static-top')
                {{-- Форма обратной связи --}}
                @include('site.form_static', ['id' => 'form-top', 'type' => $page->type, 'subject' => $page->subject])
                {{-- // Форма обратной связи --}}
            @show

            @section('block')
                {{-- Почему мы?--}}
                @include('site.gist')
                {{-- Кратко о сути нашего дела --}}
                @include('site.advantage')
                {{-- Карусель отзывы --}}
                {{--@include('site.comments')--}}
                {{-- Что мы предлагаем --}}
                @include('site.process')
                {{-- Полное тестирование --}}
                @include('site.complete_testing')
                {{-- Стоимость занятий--}}
                @include('site.price')
                {{-- FAQ --}}
                @include('site.faq')
                {{-- Подготовка к ЕГЭ/ОГЭ по предметам --}}
                {{--@include('site.subjects', ['type' => $page->type])--}}
            @show
        @endif

        {{-- Общий текст для страницы --}}
        <div class="container">
            @yield('text-block')
        </div>

        @section('form-static-bottom')
            {{-- Форма обратной связи --}}
            @include('site.form_static', ['id' => 'form-bottom', 'type' => $page->type, 'subject' => $page->subject])
            {{-- // Форма обратной связи --}}
        @show
    </div>


    @section('modal-window')
        {{-- Модальное окно для видео --}}
        <div class="modal fade" id="fun-learning-video">
            <div class="modal-dialog">
                <div class="modal-content">
                    <iframe width="100%" height="315px" src="https://www.youtube.com/embed/u9bO9yLLCKo" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        {{-- Модальное окно для формы --}}
        @include('site.form_modal', ['id' => 'form-modal', 'type' => $page->type, 'subject' => $page->subject])
        {{-- Модальное окно для входа в личный кабинет --}}
        @include('site.form_modal_login')
        {{-- Модальное окно для регистрации пользователя --}}
        @include('site.form_modal_registration')
    @show

@section('footer')
    @include('site.footer')
@show

</body>
</html>