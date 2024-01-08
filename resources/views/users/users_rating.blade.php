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
                        $images_char = UserI::getActiveImageCharacter($tasks->user_id);
                        $artifacts = UserI::getArtifactsPerson($tasks->user_id);
                        $user_classes = UserI::getUserClass($tasks->user_id);
                        $user_progresses = UserI::getUserProgress($tasks->user_id, $subject);
                    ?>
                    {{--Отображение образов учеников--}}
                        {{--{{dd($images_char->image)}}--}}
                        <td>
                            <img src="{!! asset($images_char->image) !!}" title="Рождение" width="40" height="68">
                        </td>

                    <td>{!! UserI::convertExpInLvl($tasks->sum_exp)!!}</td>
                    {{--Отображение трофеев учеников--}}
                    <td>
                        @foreach ($artifacts as $artifact)
                            <img src="{!! asset($artifact->images->info) !!}"
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
                        @if(gettype($user_classes) != 'string')
                            <img src="{!! asset($user_classes->image) !!}"
                             alt="{{$user_classes->name}}"
                             title="{{$user_classes->description}}"
                             data-toggle="tooltip" data-placement="top">
                        @else
                            {{$user_classes}}
                        @endif
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
