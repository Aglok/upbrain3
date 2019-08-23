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

        <div class="container-master-class"></div>
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
                                <a href="#contacts">Контакты</a>
                            </li>
                            <li>
                                <button data-toggle="modal" data-target="#contact-modal" class="btn">Я пойду</button>
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
                    <p class="tel"><a href="tel:+74993914815">+7(499)391-48-15</a><br><a href="tel:+79295173303">+7(929)517-33-03</a></p>
                    <button data-toggle="modal" data-target="#contact-modal" class="btn">Заказать звонок</button>
                </div>
            </nav>
            <div class="bg-block">
            {{-- Заголовки --}}
            <div class="hero hero-main">
                    <div class="header-title-left text-white">
                        <h4 class="text-hero text-hero-1">Уникальный мастер класс</h4>
                        <h4 class="text-hero text-hero-2"><span>техника запоминания длинных чисел</span></h4>
                    </div>
                    <div class="header-title-right text-white">
                        <h1 class="hero-header text-hero-3">метро Чистые пруды</h1>
                    </div>
                </div>
            {{-- Иконки наши курсы --}}
            <div class="block-icon-master-class m-t-lg">
                    <div class="row row-padded homepage-grid p-t text-center">
                        <div class="col-sm-4">
                            <div class="header_master_class">
                                <div class="header_icon-master-class">
                                    <img data-toggle="modal" data-target="#block-1" src="{!! asset('images/bg/icon_master_class/child.png') !!}" alt="Курсы ЕГЭ 10 и 11 классы">
                                </div>
                                <h3 class="font-lite">Вы <br>Мама и Папа</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="header_master_class">
                                <div class="header_icon-master-class">
                                    <img data-toggle="modal" data-target="#block-2" src="{!! asset('images/bg/icon_master_class/teen.png') !!}" alt="Курсы ОГЭ 8 и 9 классы">
                                </div>
                                <h3 class="font-lite">Для учеников<br>от 7-17 лет</h3>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="header_master_class">
                                <div class="header_icon-master-class">
                                    <img data-toggle="modal" data-target="#block-3" src="{!! asset('images/bg/icon_master_class/math.png') !!}" alt="Школа мышления с 6 класса">
                                </div>
                                <h3 class="font-lite">Знания<br>для жизни</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Блок текст --}}
            <div id="our_course" class="font-lite">

                <h3>Для кого полезно?</h3>
                <p>Полезно будет для детей от 7 лет до 17 и их родителям.
                    Мы любим начинать год с  приятных событий, которые делают людей счастливыми.
                    Поэтому, делаем для Вас подарок – 100% скидку, то есть стоимостью 0 рублей.
                    Количество мест ограниченно, успейте забронировать место.
                </p>
                <h3>Любой ребёнок - талант!</h3>
                <p>Каждый ребёнок обладает, как минимум дюжиной талантов.
                    Вопрос заключается в том, чтобы раскрыть их, сохранить и научиться пользоваться ими.
                    К сожалению, этому не учили ни нас, ни наших бабушек с дедушками, и этому мы не учим своих детей.
                    Серия наших мастер классов создана для изменения существующей проблемы -  клипового мировоззрения. Мы даём реальные навыки, которые пригодятся в жизни, помогут раскрыть свои способности и таланты.
                </p>
                <h3>Что будет на мастер классе?</h3>
                <p>
                	В нашем веке цифровых технологий важность цифр и чисел очень велика. Например, номер сотового телефона имеет 10 знаков. Не каждый может запомнить даже свой номер телефона, не говоря уже других. Наверное каждый испытывал чувство разочарования, когда забывал или терял важный телефонный номер. А ещё в нашей жизни существуют пластиковые карточки, номера машин, номера паспортов и других документов, которые желательно держать в голове. Но трудно всё это запомнить. Мы научим Вас быстро и легко запоминать большие числа, даже очень большие. Родителям мы расскажем, как мотивировать ребёнка, не оказывая на него давления. А также, как не избаловав его, выстраивать прекрасные отношения.
                </p>
                <h3>Время проведения и место</h3>
                <p>Мастер класс начинается 23 сентября в 11.00. Время проведения 45 минут. 15 минут оставляем на вопросы. Метро Чистые пруды, Архангельский пер.9</p>
            </div>
        </div>
        {{-- Форма обратной связи --}}
        @include('site.form_static', ['id' => 'form-bottom'])
        {{-- // Форма обратной связи --}}
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