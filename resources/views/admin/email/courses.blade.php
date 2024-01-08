@php
    $exam = 'Upbrain';
    if($type == 'ege')
        $exam = 'ЕГЭ';
    elseif($type == 'oge')
        $exam = 'ОГЭ';

    if($subject == 'math')
        $sub = ' по математике';
    elseif($subject == 'physics')
        $sub = ' по физике';
    else
        $sub = ' ';
@endphp
<div>
    Доброго здравия, {{$name}}. Вы оставили заявку на курсы {{$exam}}{{$sub}}. Ваша заявка принята. С Вами скоро свяжутся, подождите пожалуйста.
    Вся информация придёт на эту почту <b>{{$email}}</b>
</div>
<br>
<br>
<img src="http://upbrain.ru/images/bg/header/header_logo.png">
<br>
<div>С Уважением, команда Upbrain.ru</div>
<br>
<small><a href="http://upbrain.ru">Upbrain - исскуство обучения</a></small>