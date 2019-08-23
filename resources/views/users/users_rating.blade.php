@extends('app')
@section('content')
<div class="content-wrapper">
    <div class="content body">
        <div class="table-responsive margin-top">
            {!! Form::open()!!}
            <table class="table table-striped table-hover" id="dataTable">
            <thead>
            <tr>
                @foreach ($columns as $column)
                    <th>{!! $column !!}</th>
                @endforeach
                    <th>Образ</th>
                    <th>Уровень</th>
                    <th>Артефакты</th>
                    <th>Достижения</th>
                    <th>Класс</th>
            </tr>
            </thead>
            <tbody>

            <?php $i = 1; ?>
            @foreach ($rows as $tasks)
                <tr>
                    <td>{{$i++}}</td>
                    @if((int)Auth::id() == $tasks->user_id)
                        <td><a href="{{ url('home')}}">{{ $tasks->name }} {{ $tasks->surname }}</a></td>
                    @else
                        <td><a href="{{ url('home/user_home/'.$subject)}}/{{ $tasks->user_id }}">{{ $tasks->name }} {{ $tasks->surname }}</a></td>
                    @endif
                    <td>{{ $tasks->sum_exp }}</td>
                    <td>{{ $tasks->sum_gold }}</td>

                    <?php
                        $images_chars = UserI::getImageCharacter($tasks->user_id);
                        $artifacts = UserI::getArtifactPerson($tasks->user_id);
                        $user_classes = UserI::getUserClass($tasks->user_id);
                        $user_progresses = UserI::getUserProgress($tasks->user_id);
                    ?>
                    {{--Отображение образов учеников--}}
                    @if(!$images_chars[0])
                            <td>
                                <img src="{!! asset('images/items/person/default/'.$images_chars[1].'.gif') !!}"
                                     title="Силуэт" width="40" height="68">
                            </td>
                    @else
                        @foreach ($images_chars[0] as $image_char)
                            <td>
                                @if($images_chars[1] == 'man')
                                    <img src="{!! asset($image_char->small_image_m) !!}"
                                        title="Рождение" width="40" height="68">
                                @else
                                    <img src="{!! asset($image_char->small_image_w) !!}"
                                         title="Рождение" width="40" height="68">
                                @endif
                            </td>
                        @endforeach
                    @endif
                    <td>{!! UserI::convertExpInLvl($tasks->sum_exp)!!}</td>
                    {{--Отображение трофеев учеников--}}
                    <td>
                        @foreach ($artifacts as $artifact)
                            <img src="{!! asset($artifact->image) !!}"
                                 alt="{{$artifact->name}}" title="{{$artifact->info}}"
                                 data-toggle="tooltip" data-html="true" data-placement="bottom" width="40" height="40">
                        @endforeach
                    </td>
                    {{--Отображение достижений учеников--}}
                    <td>
                        @foreach ($user_progresses as $user_progress)
                            <img src="{!! asset($user_progress->image) !!}"
                                 alt="{{$user_progress->name}}" title="{{$user_progress->description}}"
                                 data-toggle="tooltip" data-placement="bottom" width="40" height="40">
                        @endforeach
                    </td>
                    <td>
                        @foreach($user_classes as $user_class)
                            @if($tasks->sex == 'M')
                                <img src="{!! asset($user_class->icon_man) !!}"
                                     alt="{{$user_class->name}}"
                                     title="{{$user_class->description}}"
                                     data-toggle="tooltip" data-placement="top">
                            @else
                                <img src="{!! asset($user_class->icon_woman) !!}"
                                     alt="{{$user_class->name}}"
                                     title="{{$user_class->description}}"
                                     data-toggle="tooltip" data-placement="top">
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
            </table>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
