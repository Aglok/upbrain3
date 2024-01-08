<!DOCTYPE html>
<html>
<head>
    @include('site.header', ['title' => $post->title,'keywords' => $post->keywords, 'description' => $post->description, 'image' => $post->image])
</head>
<body class="swag-line">
    @include('blog.social')
<div class="header-menu"></div>

<div class="container-overflow-wrap">

    {{-- Панель header --}}
    <div class="container">
        {{-- Боковое мобильное меню --}}
        <nav class="navmenu navmenu-default navmenu-fixed-right offcanvas">
            <a class="navbar-brand-fixed" href="/"><img src="{!! asset('images/bg/header/header_logo.png') !!}" alt="Upbrain"></a>
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
                            <a href="lp_ege">Главная</a>
                        </li>
                        <li>
                            <a href="master_class">Мастер класс</a>
                        </li>

                        <li>
                            <a href="https://www.facebook.com/groups/upbrain.ru/"><i class="fab fa-facebook-square"></i></a>
                        </li>
                        <li>
                            <a href="https://vk.com/upbrainschool"><i class="fab fa-vk"></i></a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="#"><i class="fab fa-odnoklassniki-square" href="#"></i></a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"><i class="fab fa-google" href="#"></i></a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="https://www.youtube.com/channel/UCmppc52Koy0LjP1AOCzxokg"><i class="fab fa-youtube"></i></a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="#"><i class="fab fa-twitter" href="#"></i></a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="https://telegram.me/upbrain"><i class="fab fa-telegram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- Контакт --}}
            <div class="contact">
{{--            <a href="#">О преподвателях</a><br>
                <a href="#">О проекте</a>--}}
            </div>
        </nav>

        <div class="panel-center col-xl-9">
            @yield('content')
        </div>
        <div class="sidebar col-xl-3">
            @section('sidebar')
            @show
        </div>
    </div>
</div>

</body>
{!! Html::script('js/lp/jquery-3.2.1.min.js') !!}
{!! Html::script('js/lp/tether.min.js') !!}
{!! Html::script('js/lp/bootstrap.js') !!}
{!! Html::script('js/lp/jasny-bootstrap.min.js') !!}
{{--{!! Html::script('js/vue/app.js') !!}--}}
{!! Html::script('js/aglok/hypercomments.js') !!}
<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>
</html>
