@php
    if(!isset($type)) $type = '';
    $exam = '';
    if($type == 'ege')
        $exam = 'к ЕГЭ';
    elseif($type == 'oge')
        $exam = 'к ОГЭ';
@endphp
@if($type != 'junior_classes')
<div class="container container-wrap-process-1 m-b-lg">
    <div class="m-b-0 text-center">
        <span class="common-title" id="subjects">Подготовка {{$exam}} по предметам</span>
    </div>
    <div class="container-wrap-process-2">
        <div class="row row-padded row-centered">
            {{--<div class="col-sm-3">--}}
                {{--<h3>Полное тестирование</h3>--}}
                {{--<div class="m-b-md">--}}
                    {{--<ul class="m-l p-0">--}}
                        {{--<li>Определяем уровень знаний</li>--}}
                        {{--<li>Разрабатываем план</li>--}}
                        {{--<li>Фиксируем данные</li>--}}
                        {{--<li>Особое внимание к слабым местам</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="col-sm-12 col-sm-offset-1">
                <ul class="list text-center item-subject">
                    <li class="list-group-item">
                        <a data-subject="math" title="Курсы подготовки по математике">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/mathematics.png') !!}" alt="Математика">Математика
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="physics" title="Курсы подготовки по физике">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/physics.png') !!}" alt="Физика">Физика
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="russian" title="Курсы подготовки по русский язык">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/russian.png') !!}" alt="Русский язык">Русский язык
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="english" title="Курсы подготовки по английскому язык">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/english.png') !!}" alt="Английский язык">Английский язык
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="social_sciences" title="Курсы подготовки по обществознанию">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/social_sciences.png') !!}" alt="Обществознание">Обществознание
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="history" title="Курсы подготовки по истории">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/history.png') !!}" alt="История">История
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="informatics" title="Курсы подготовки по информатике">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/informatics.png') !!}" alt="Информатика">Информатика
                        </a>
                    </li>

                    <li class="list-group-item">
                        <a data-subject="chemistry" title="Курсы подготовки по химии">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/chemistry.png') !!}" alt="Химия">Химия
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a data-subject="biology" title="Курсы подготовки по биологии">
                            <img class="who-is-icon" src="{!! asset('images/bg/icon_learning/biology.png') !!}" alt="Биология">Биология
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-wrap-process-3">
        {{--<a class="btn btn-process btn-primary" href="/collections/all">Вся информация</a>--}}
    </div>
</div>
@else

@endif