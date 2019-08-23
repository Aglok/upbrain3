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
        $text = '';
@endphp
<div class="row row-backbordered m-b-lg">
    <div class="col-sm-8 mx-auto">
        <h2 class="text-center">Преподаватели {{$text}}</h2>
        <div class="row">
            <div class="mx-auto col-sm-6 text-center">
                <img class="rounded-circle" src="{{asset('images/teachers/main_AV.png')}}" alt="Перлов Артём Валерьевич - Эксперт ЕГЭ по математике и физике">
                <p>Артём Валерьевич.
                    <br>Эксперт ЕГЭ.
                    <br>Физический факультет МГУ.
                    <br>ИОФ РАН Прохорова.
                    <br>Составитель задач по математике и физике
                    <br>Опыт преподавания 11 лет
                </p>
            </div>
            <div class="mx-auto col-sm-6 text-center">
                <img class="rounded-circle" src="{{asset('images/teachers/main_EV.png')}}" alt="Перлов Егор Валерьевич - Эксперт ЕГЭ по математике и физике">
                <p>Егор Валерьевич.
                    <br>Эксперт ЕГЭ.
                    <br>Физический факультет МГУ.
                    <br>ФИАН им. Лебедева.
                    <br>Составитель задач по математике и физике
                    <br>Опыт преподавания 12 лет
                </p>
            </div>
        </div>
    </div>
</div>