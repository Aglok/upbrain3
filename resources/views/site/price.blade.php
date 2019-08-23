@php
    if(!isset($subject)) $subject = '';
    $text = '';
    if($subject == 'math')
        $text = 'по математике';
    elseif($subject == 'physics')
        $text = 'по физике';
    elseif($subject == 'russian')
        $text = 'по русскому языку';
    elseif($subject == 'english')
        $text = 'по английскому языку';
    elseif($subject == 'history')
        $text = 'по истории';
    elseif($subject == 'social_sciences')
        $text = 'по обществознанию';
    elseif($subject == 'biology')
        $text = 'по биологии';
    elseif($subject == 'chemistry')
        $text = 'по химии';
    else
        $text = 'по 1 предмету';
@endphp
<div class="container-wrap-price m-t-lg">
    <div class="container">
        <div class="m-b-0 text-center">
            <span class="common-title" id="price">Стоимость</span>
        </div>
        <div class="row row-padded homepage-grid p-t text-center">
{{--            <div class="col-sm-6">
                <div class="panel-price font-lite upbrain-card upbrain-animation-slide-left-medium">
                    <div>Пробный урок в подарок</div>
                    <div>
                        <img class="price-icon" src="{!! asset('images/bg/icon_price/repost.png') !!}" alt="Пробный урок/Проверка уровня">Сделайте репост
                        <p>-1000 р за следующий месяц</p>
                    </div>
                    @include('site.social')
                    <p class="p-3 small col-sm-12">Чтобы получить пробный урок в подарок и -1000р от стоимости на следующий месяц, сделайте репост на свою страницу в контакте, фейсбуке или одноклассниках и закрепите запись на 7 дней</p>
                </div>
            </div>--}}

{{--            <div class="col-sm-6">
                <div class="panel-price panel-price-secondary font-lite upbrain-card upbrain-animation-slide-bottom-medium">
                    <div class="m-b font-bold">Стоимость инвестиций за один месяц:</div>
                    <div class="row">
                        <div class="col-lg-8">При выборе 2 предметов дополнительно скидка 5%</div>
                        <div class="col-lg-4">
                            <b class="font-bold">15200 р</b>
                            <p class="small m-0 text-danger">Вместо 16000 р</p>
                            <p class="small m-0 text-success">Экономия 800 р</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">При выборе 3 предметов дополнительно скидка 10%</div>
                        <div class="col-lg-4">
                            <b class="font-bold">21600 р</b>
                            <p class="small m-0 text-danger">Вместо 24000 р</p>
                            <p class="small m-0 text-success">Экономия 2400 р</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">При 4 и более преметов специальные условия от 15%</div>
                        <div class="col-lg-4">
                            <b class="font-bold">от 27200 р</b>
                            <p class="small m-0 text-danger">Вместо 32000 р</p>
                            <p class="small m-0 text-success">Экономия 4800 р</p>
                        </div>
                    </div>
                </div>
            </div>--}}
            {{--<h2 class="m-3 font-bold col-sm-12">Мы указываем реальную стоимость за 1 занятие 2 академические часы.</h2>--}}
{{--            <div class="col-md-4 mb-2">
                <div class="row m-0 panel-price panel-price-first font-lite upbrain-card upbrain-animation-slide-right-medium">
                    <div class="col-sm-12 mt-2">
                        <p class="m-0 font-bold">Курс {{$text}}</p>
                        <p class="small m-0">Кол-во занятий: 4 в мес.</p>
                        <p class="small m-0">Время 1 занятия: 120 мин</p>
                        <p class="small m-0">Внимание каждому ученику в группе</p>
                        <p class="small m-0"><i class="fal fa-smile" aria-hidden="true"></i></p>
                        <div class="font-bold">8000р</div>
                        <button data-toggle="modal" data-target="#contact-modal" class="btn mb-2">Записаться</button>
                    </div>
                </div>
            </div>--}}
            <div class="col-md-4">
                <div class="row m-0 panel-price panel-price-first font-lite upbrain-card upbrain-animation-slide-right-medium">
                    <div class="col-sm-12 mt-2">
                        <p class="m-0 font-bold">Курс {{$text}}</p>
                        <p class="small m-0">Кол-во занятий: 1</p>
                        <p class="small m-0">Время 1 занятия: 90 мин</p>
                        <p class="small m-0">Внимание каждому ученику в группе</p>
                        <p class="small m-0"><i class="fal fa-smile" aria-hidden="true"></i></p>
                        <div class="font-bold">1500р</div>
                        <button data-toggle="modal" data-target="#contact-modal" class="btn mb-2">Записаться</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="row m-0 panel-price panel-price-secondary font-lite upbrain-card upbrain-animation-slide-bottom-medium">
                    <p class="my-0 mx-2"></p>
                    <div class="col-sm-12 mt-2">
                        <p class="m-0 font-bold">Оптимум курс {{$text}}</p>
                        <p class="small m-0">Кол-во занятий: 1</p>
                        <p class="small m-0">Время 1 занятия: 90 мин</p>
                        <p class="small m-0"><a style="cursor: pointer;" class="text-success" data-animation="false" data-toggle="tooltip" data-html="true" title="<ul class='text-left small'><li>Внимание каждому ученику в группе</li><li>Дополнительный разбор непонятных тем 2 раза/мес.</li><li>Обучение в форме игры, выполнение квестов</li></ul>">Активный рост</a></p>
                        <p class="small m-0"><i class="fal fa-grin-wink" aria-hidden="true"></i></p>
                        <div class="font-bold">2500р</div>
                        <button data-toggle="modal" data-target="#contact-modal" class="btn mb-2">Записаться</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="row m-0 panel-price panel-price-first font-lite upbrain-card upbrain-animation-slide-right-medium">
                    <div class="col-sm-12 mt-2">
                        <p class="m-0 font-bold">Премиум курс {{$text}}</p>
                        <p class="small m-0">Кол-во занятий: 1</p>
                        <p class="small m-0">Время 1 занятия: 90 мин</p>
                        <p class="small m-0"><a style="cursor: pointer;" class="text-primary" data-animation="false" data-toggle="tooltip" data-html="true" title="<ul class='text-left small'><li>Внимание каждому ученику в группе</li><li>Наставничество</li><li>Обучение в форме игры, выполнение квестов</li><li>Дополнительный разбор непонятных тем</li><li>Психологическая подготовка</li><li>Устраняем страхи и отупление</li></ul>">Взрывной рост</a></p>
                        <p class="small m-0"><i class="fal fa-smile" aria-hidden="true"></i></p>
                        <div class="font-bold">3000р</div>
                        <button data-toggle="modal" data-target="#contact-modal" class="btn mb-2">Записаться</button>
                    </div>
                </div>
            </div>
{{--            <div class="col-md-4">
                <div class="row m-0 panel-price panel-price-third font-lite upbrain-card upbrain-animation-slide-bottom-medium">
                    <div class="col-sm-6">
                        <p>Более 6 месяцев</p>
                        <p class="small m-0">24 занятия</p>
                        <p class="small m-0">48 ак.ч</p>
                    </div>
                    <div class="col-sm-6">
                        <p>Скидка 10%</p>
                        <div>
                            <b class="font-bold">от 43200 р</b>
                            <p class="small m-0 text-danger">Вместо 48000 р</p>
                            <p class="small m-0 text-success">Экономия 4800 р</p>
                        </div>
                    </div>
                </div>
            </div>--}}
            <h4 class="col-sm-12">При оплате более, чем за 6 месяцев или выборе от двух предметов мы сделаем специальное предложение.</h4>
            <button data-toggle="modal" data-target="#contact-modal" class="btn m-auto">Получить специальное предложение</button>
        </div>
    </div>
</div>