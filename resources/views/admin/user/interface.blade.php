 <div class="row">
        <img src="{!! asset('images/items/clan/Paladins.gif') !!}" width="24" height="15" title="Paladins">
     <b>
         {{$sum_res['surname']}} {{$sum_res['name']}}
     </b>
     <span>[<b>{{$user_level}}</b>] {{$user_class->name}}</span>
    </div>
    <div class="row">
            <div class="col-xs-3 t_row">
                {{--<div>--}}
                    {{--<img src="{!! asset('images/items/artifacts/default/head.gif') !!}" width="60" height="60" title="Пустой слот голова">--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<img src="{!! asset('images/items/artifacts/default/bracers.gif') !!}" width="60" height="40" title="Пустой слот наручи">--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<img src="{!! asset('images/items/artifacts/default/weapon.gif') !!}" width="60" height="60" title="Пустой слот оружие">--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<img src="{!! asset('images/items/artifacts/default/armor.gif') !!}" width="60" height="80" title="Пустой слот броня">--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<img src="{!! asset('images/items/artifacts/default/belt.gif') !!}" width="60" height="40" title="Пустой слот пояс">--}}
                {{--</div>--}}
            </div>
            <div class="col-xs-3 t_row">
                <div>
                    <div>
                        <span id="HP" style="position: absolute; left: 5px; top: 6px; z-index: 1; font-size: 9px; font-weight: bold; color: #FFFFFF">{{ $user_class->hp.'/'.$user_class->hp }}</span>
                        <img src="{!! asset('images/items/misc/bk_life_green.gif') !!}" title="Уровень жизни" name="HP1" width="120" height="9" id="HP1">
                        <img src="{!! asset('images/items/misc/bk_life_loose.gif') !!}" title="Уровень жизни" name="HP2" width="0" height="9" id="HP2">
                        <span style="width:1px; height:10px"></span>
                    </div>
                    <div>
                        <div>
                            <a href="" target="_blank">
                                @if($bodies)
                                    <img src="{!! asset($bodies->image) !!}" title="Рождение" width="220">
                                @endif
                            </a>
                            {{--Появление эффектов --}}
                            <div style="position:absolute; left:0px; top:0px; width:120px; max-height:220px; background: transparent; z-index:4;">
                                <span id="effs"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3 t_row r_border b_border">
                {{--<div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/earring.gif') !!}" width="60" height="20" title="Пустой слот серьги">--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/amulet.gif') !!}" width="60" height="20" title="Пустой слот амулет">--}}
                    {{--</div>--}}
                    {{--<div class="row t_row">--}}
                        {{--<div class="col-xs-3 t_row"><img src="{!! asset('images/items/artifacts/default/ring_1.gif') !!}" width="20" height="20" title="Пустой слот кольцо"></div>--}}
                        {{--<div class="col-xs-3 t_row"><img src="{!! asset('images/items/artifacts/default/ring_2.gif') !!}" width="20" height="20" title="Пустой слот кольцо"></div>--}}
                        {{--<div class="col-xs-3 t_row"><img src="{!! asset('images/items/artifacts/default/ring_3.gif') !!}" width="20" height="20" title="Пустой слот кольцо"></div>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/gloves.gif') !!}" width="60" height="40" title="Пустой слот перчатки">--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/shield.gif') !!}" width="60" height="60" title="Пустой слот щит">--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/legs.gif') !!}" width="60" height="80" title="Пустой слот поножи">--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<img src="{!! asset('images/items/artifacts/default/boots.gif') !!}" width="60" height="40" title="Пустой слот обувь">--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="col-xs-3 t_row t_margin">
                <ul class="list-unstyled">
                    <! Отображение характеристик !>
                    @foreach($grades as $grade)
                            <li>{{ $grade->grade_char }}: <a href="{{URL::route('user_solved_tasks', ['subject' => $subject, 'grade' => $grade->grade_char, 'user_id' => $user_id])}}" title="Опыт: {{ $grade->sum_exp }} | Монет: {{ $grade->sum_gold }}" data-toggle="tooltip" data-placement="top">{{ $grade->sum_tasks }}</a><i></i></li>
                    @endforeach
                    <! Отображение этапов работы ученика!>
                    @foreach($stages as $stage)
                            <li>{{ $stage->alias }}: <a href="{{URL::route('user_solved_tasks', ['subject' => $subject, 'stage_id' => $stage->stage_id, 'user_id' => $user_id])}}" title="Опыт: {{ $stage->sum_exp }} | Монет: {{ $stage->sum_gold }}" data-toggle="tooltip" data-placement="top">{{ $stage->count }}</a> <i class="glyphicon glyphicon-info-sign" title="{{ $stage->description }}" data-toggle="tooltip" data-placement="top"></i></li>
                    @endforeach
                    <hr>
                    <li>Опыт: {{$sum_res['sum_exp']}}</li>
                    <li>Монет: {{$sum_res['sum_gold']}}</li>
                    <li>Уровень: {{$user_level}}</li>
                    <hr>
                    <li><b>Класс</b>: {{$user_class->name}}</li>
                    <li>Атака: {{$user_class->attack}}</li>
                    <li>Защита: {{$user_class->shield}}</li>
                    <li>Магия: {{$user_class->mp}}</li>
                    <li>Энергия: {{$user_class->energy}}</li>
                    <li>Увл. опыта: {{$user_class->increase_experience}}</li>
                    <li>Увл. золота: {{$user_class->increase_gold}}</li>
                </ul>
            </div>
    </div>
    <hr>
    {{--<div class="row">--}}
        {{--<div class="col-xs-3 t_row">--}}
            {{--<br>--}}
            {{--<ul class="list-inline">--}}
                {{--<li><img src="{!! asset('images/items/progress/sportteam.gif') !!}" alt="Искушённый Спортом" title="Искушённый Спортом" data-toggle="tooltip" data-placement="top"></li>--}}
                {{--<li><img src="{!! asset('images/items/progress/lvl_1/zn1_1.gif') !!}" alt="Рыцарь первого круга" title="Рыцарь первого круга" data-toggle="tooltip" data-placement="top"></li>--}}
                {{--<li><img src="{!! asset('images/items/progress/lvl_1/zn2_1.gif') !!}" alt="Рыцарь первого круга" title="Рыцарь первого круга" data-toggle="tooltip" data-placement="top"></li>--}}
                {{--<li><img src="{!! asset('images/items/progress/lvl_1/zn3_1.gif') !!}" alt="Рыцарь первого круга" title="Рыцарь первого круга" data-toggle="tooltip" data-placement="top"></li>--}}
                {{--<li><img src="{!! asset('images/items/progress/lvl_1/zn4_1.gif') !!}" alt="Рыцарь первого круга" title="Рыцарь первого круга" data-toggle="tooltip" data-placement="top"></li>--}}
                {{--<li><img src="{!! asset('images/items/progress/lvl_2/zn1_2.gif') !!}" alt="Рыцарь второго круга" title="Рыцарь второго круга" data-toggle="tooltip" data-placement="top"></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</div>--}}

    @if(count($artifacts) > 0)
        <div class="row">
            <div class="col-xs-3 t_row">
                <strong>Трофеи</strong>
                <ul class="list-inline">
                    @foreach($artifacts as $artifact)
                    <li>
                        <img src="{!! asset($artifact->images->info) !!}" alt="{{$artifact->name}}"
                             title="{{ $artifact->info }}"
                             data-toggle="tooltip" data-html="true" data-placement="top" width="100">
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-xs-3 t_row">
                <img src="{!! asset($user_class->image) !!}"
                     alt="{{$user_class->name}}"
                     title="{{$user_class->description}}"
                     data-toggle="tooltip" data-placement="top">
        </div>
    </div>
 @if(count($user_progresses) > 0)
     <div class="row">
         <div class="col-xs-3 t_row">
             <strong>Достижения</strong>
             <ul class="list-inline">
                 @foreach($user_progresses as $user_progress)
                     <li>
                         <img src="{!! asset($user_progress->image) !!}" alt="{{$user_progress->name}}"
                              title="{{$user_progress->description}}"
                              data-toggle="tooltip" data-placement="top" width="100">
                     </li>
                 @endforeach
             </ul>
         </div>
     </div>
 @endif
    {{--<div class="row">--}}
        {{--<div class="col-xs-3 t_row">--}}
            {{--<strong>Инфо</strong>--}}
        {{--</div>--}}
    {{--</div>--}}
{!! Html::style('css/aglok/profile.css') !!}