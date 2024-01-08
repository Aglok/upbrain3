<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Форма регистрации на курсы Upbrain</title>
    {!! Html::style('css/lp/bootstrap.css') !!}
    {!! Html::style('css/lp/jasny-bootstrap.min.css') !!}
    {!! Html::style('css/aglok/lp_style.css') !!}
    {!! Html::style('css/lp/fontawesome-all.css') !!}
    {!! Html::style('css/lp/ekko-lightbox.css') !!}
    <style>
        @media (min-width: 576px){
            .form-inline .form-check {
                -webkit-justify-content: right;
                -ms-flex-pack: center;
                justify-content: right;
            }
        }
        /* Скрываем реальный чекбокс */
        .checkbox {
            display: none;
        }
        /* Задаем внешний вид для нашего кастомного чекбокса. Все обязательные свойства прокомментированы, остальные же свойства меняйте по вашему усмотрению */
        .checkbox-custom {
            position: relative;      /* Обязательно задаем, чтобы мы могли абсолютным образом позиционировать псевдоэлемент внютри нашего кастомного чекбокса */
            width: 20px;             /* Обязательно задаем ширину */
            height: 20px;            /* Обязательно задаем высоту */
            border: 2px solid #ccc;
            border-radius: 3px;
        }
        /* Кастомный чекбокс и лейбл центрируем по вертикали. Если вам это не требуется, то вы можете убрать свойство vertical-align: middle из данного правила, но свойство display: inline-block обязательно должно быть */
        .checkbox-custom,
        .label {
            display: inline-block;
            vertical-align: middle;
        }
        /* Если реальный чекбокс у нас отмечен, то тогда добавляем данный признак и к нашему кастомному чекбоксу  */
        .checkbox:checked + .checkbox-custom::before {
            content: "";             /* Добавляем наш псевдоэлемент */
            display: block;			 /* Делаем его блочным элементом */
            position: absolute;      /* Позиционируем его абсолютным образом */
            /* Задаем расстояние от верхней, правой, нижней и левой границы */
            top: 2px;
            right: 2px;
            bottom: 2px;
            left: 2px;
            background: #413548;     /* Добавляем фон. Если требуется, можете поставить сюда картинку в виде "галочки", которая будет символизировать, что чекбокс отмечен */
            border-radius: 2px;
        }
        .width-100{
            width: 100% !important;
        }
        .form-inline .form-group {
            margin-left: 0;
        }
    </style>
</head>
<body>
<h1 class="text-center">Форма регистрации на курсы Upbrain</h1>
{!! Form::open(['id' => 'from_registration', 'url'=>'from_registration', 'method' => 'post', 'class'=>'form-inline mx-auto col-sm-8'])!!}
    <div class="row">
        <div class="mx-auto col-lg-6">
            <h2>Общая информация</h2>
            <div class="form-group">
                {!! Form::text('name', '',  ['class'=>'form-control input-lg', 'placeholder' => 'Имя', 'required' => 'required']) !!}
                {!! Form::text('surname', old('email'), ['class'=>'form-control input-lg', 'placeholder' => 'Фамилия']) !!}
                {!! Form::text('patronymic','',  ['class'=>'form-control input-lg', 'placeholder' => 'Отчество']) !!}
                {!! Form::email('email', old('email'), ['class'=>'form-control input-lg', 'placeholder' => 'Email', 'required' => 'required']) !!}
                {!! Form::text('phone','',  ['class'=>'form-control input-lg', 'placeholder' => 'Телефон', 'required' => 'required', 'data-mask' =>'+7-999-999-9999']) !!}
            </div>
        </div>
        <div class="mx-auto col-lg-6">
            <h2>Предметы</h2>
            <div class="form-group">
            <ul class="list-unstyled width-100">
                @foreach(\App\Models\Subject::all() as $subject)
                    <li>
                        <div class="form-check">
                            <label>
                                {!! Form::checkbox('subjects[]', $subject->name, false, ['class'=>'form-check-input checkbox'])!!}
                                <span class="checkbox-custom"></span>
                                <span class="label font-light ml-1">{{$subject->name}}</span>
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mx-auto col-lg-6">
            <h2>Тип обучения</h2>
            <div class="form-group">
            <ul class="list-unstyled width-100">
                <li>
                    <div class="form-check">
                        <label>
                            {!! Form::checkbox('type_of_training[]', 'Очные курсы', false, ['class'=>'form-check-input checkbox'])!!}
                            <span class="checkbox-custom"></span>
                            <span class="label font-light ml-1">Очные курсы</span>
                        </label>
                    </div>
                </li>
                <li>
                <div class="form-check">
                    <label>
                        {!! Form::checkbox('type_of_training[]', 'Дистанционные курсы', false, ['class'=>'form-check-input checkbox'])!!}
                        <span class="checkbox-custom"></span>
                        <span class="label font-light ml-1">Дистанционные курсы</span>
                    </label>
                </div>
                </li>
            </ul>
            </div>
        </div>
        <div class="mx-auto col-lg-6">
            <h2>Дополнительно</h2>
            <div class="form-group">
                {!! Form::text('hei', '',  ['class'=>'form-control input-lg', 'placeholder' => 'ВУЗ', 'required' => 'required']) !!}
                {!! Form::text('points', '',  ['class'=>'form-control input-lg', 'placeholder' => 'Баллы', 'required' => 'required']) !!}
                {!! Form::text('place', '',  ['class'=>'form-control input-lg', 'placeholder' => 'Метро, Район', 'required' => 'required']) !!}
                {!! Form::text('additionally','',['class'=>'form-control input-lg', 'placeholder' => 'Что нибудь ещё...']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
    {!! Form::button('Зарегистрироваться', ['class'=>'form-control btn btn-lg input-lg'])!!}
    </div>
{!! Form::close() !!}
</body>
{!! Html::script('js/lp/jquery-3.2.1.min.js') !!}
{!! Html::script('js/lp/ekko-lightbox.min.js') !!}
{!! Html::script('js/lp/tether.min.js') !!}
{!! Html::script('js/lp/bootstrap.js') !!}
{!! Html::script('js/lp/jasny-bootstrap.min.js') !!}
{!! Html::script('js/aglok/common.js') !!}
{!! Html::script('js/aglok/lp.js') !!}
</html>




<script>
    //Функция принимает селектор id формы
    // Отправляет ajax запросом данные формы
    let SendForm = function sendForm(form_selector) {

        $(form_selector +' .btn').on('click', function (e) {

            e.preventDefault();

            let form = $(form_selector),
                button = $(this),
                name = $(form_selector + ' input[name=name]').val(),
                surname = $(form_selector + ' input[name=surname]').val(),
                patronymic = $(form_selector + ' input[name=patronymic]').val(),
                phone = $(form_selector + ' input[name=phone]').val(),
                email = $(form_selector + ' input[name=email]').val(),
                subjects = [],
                type_of_training = [],
                hei = $(form_selector + ' input[name=hei]').val(),
                points = $(form_selector + ' input[name=points]').val(),
                place = $(form_selector + ' input[name=place]').val(),
                additionally = $(form_selector + ' input[name=additionally]').val();

            $(form_selector + ' input[name="subjects[]"]:checked').each(function () {
                subjects.push($(this).val());
            });

            $(form_selector + ' input[name="type_of_training[]"]:checked').each(function () {
                type_of_training.push($(this).val());
            });

            if(typeof name !== 'undefined'){
                if(!name){
                    infoChat(form, 'Напишите пожалуйста Ваше имя.');
                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);
                    return;
                }
            }

            if(typeof phone !== 'undefined'){
                if(!phone){
                    infoChat(form,'Напишите пожалуйста Ваш телефон.');
                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);
                    return;
                }
            }

            if(typeof email !== 'undefined'){
                if(!email){
                    infoChat(form,'Напишите пожалуйста Вашу почту.');
                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);
                    return;
                }
            }

            if(!subjects.length){
                infoChat(form,'Выберите хотя бы один предмет');
                $('body,html').animate({
                    scrollTop: 0
                }, 400);
                    return;
            }

            if(!type_of_training.length){
                infoChat(form,'Выберите хотя бы тип курсов');
                $('body,html').animate({
                    scrollTop: 100
                }, 400);
                    return;
            }

            button.prop("disabled",true);

            let data_form = form.serialize();

            $.ajax({
                type: 'POST',
                url: 'from_registration',
                data: data_form,

                success: function () {

                    button.prop("disabled",false);

                    if(typeof phone !== 'undefined'){
                        infoChat(form,'Ваши данные успешно оправлены');
                    }else{
                        infoChat(form,'Ваши данные успешно оправлены, на Вашу почту придёт информация!');
                    }

                    $('body,html').animate({
                        scrollTop: 0
                    }, 400);

                    if ($('.modal').hasClass('show')) {
                        $(form_selector +' .btn').val('Закрыть').attr('data-dismiss', 'modal');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('Ошибка:' + errorThrown);
                }
            });
        })
    };
    SendForm('#from_registration');
</script>

