@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Редактировать задание №<span id="mission-id">{{$mission->id}}</span>
            </h1>
            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                {!! Form::open(['id' => 'create_mission', 'class' => 'create_mission form-inline'])!!}

                {{--Имя и описание миссии--}}
                {!! Form::text('name', $mission->name ,['placeholder' => 'Название задания', 'class' => 'form-control']) !!}
                {!! Form::text('description', $mission->description , ['placeholder' => 'Описание', 'class' => 'form-control']) !!}

                {{--Набор задач--}}
                <div class="form-group">
                    <select id="set-of-task" name="set_of_tasks_id" class="multiselect dropdown-toggle btn btn-default form-control">
                        @foreach($set_of_tasks as $set_of_task)
                            @if($set_of_task->id == $mission->set_of_tasks_id)
                                <option selected value="{!! $set_of_task->id !!}">{!! $set_of_task->name !!}</option>
                            @else
                                <option value="{!! $set_of_task->id !!}">{!! $set_of_task->name !!}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <a id="normalize" class="btn btn-primary" href="#">Упорядочить</a>

                {{--Артифакты--}}
                <div id="list_artifacts">
                    <ul class="list-inline">
                        @foreach($list_artifacts as $artifact)
                            @foreach($artifacts_checked as $artifact_checked)

                                @if($artifact->id == $artifact_checked->id)
                                    <li class="selected">
                                        {!! Form::checkbox('artifact_id', $artifact->id, true) !!}
                                        <img src="{{asset($artifact->image)}}" alt="{{$artifact->name}}">
                                    </li>
                                    @continue(2)
                                @endif
                            @endforeach
                            <li>
                                {!! Form::checkbox('artifact_id', $artifact->id) !!}
                                <img src="{{asset($artifact->image)}}" alt="{{$artifact->name}}">
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{--Список задач--}}
                <div id="list_tasks">
                    <ul class="list_tasks list-unstyled">
                        @php $i = 1; @endphp
                        @foreach($list_tasks as $list_task)
                            @foreach($tasks_checked as $task_checked)

                                @if($list_task->id == $task_checked->id)
                                    <li class="list-group-item selected">
                                        {{$i++.'.'}}{!! Form::checkbox('task_id', $list_task->id, true) !!}
                                    </li>
                                    @continue(2)
                                @endif
                            @endforeach
                            <li class="list-group-item">
                                {{$i++.'.'}}{!! Form::checkbox('task_id', $list_task->id) !!}
                            </li>
                        @endforeach
                    </ul>
                </div>
                {!! Form::button('<i class="fa fa-plus"></i> Сохранить', ['id' => 'edit_mission' ,'class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--{!! Html::style('css/aglok/mission.css') !!}--}}
    {{--{!! Html::script('js/aglok/mathjax/MathJax.js?config=default')!!}--}}
    {{--{!! Html::script('js/aglok/tasks.js') !!}--}}
    {{--{!! Html::script('js/aglok/mission.js') !!}--}}
@stop