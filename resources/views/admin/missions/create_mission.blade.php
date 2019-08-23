@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Создать задание</h1>
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
                {!! Form::text('name', '' ,['placeholder' => 'Название задания', 'class' => 'form-control']) !!}
                {!! Form::text('description','' , ['placeholder' => 'Описание', 'class' => 'form-control']) !!}

                <div class="form-group">
                    <select id="set-of-task" name="set_of_tasks_id" class="multiselect dropdown-toggle btn btn-default form-control">
                        <option></option>
                        @foreach($set_of_tasks as $set_of_task)
                            <option value="{!! $set_of_task->id !!}">{!! $set_of_task->name !!}</option>
                        @endforeach
                    </select>
                </div>

                <a id="normalize" class="btn btn-primary" href="#">Упорядочить</a>
                <div id="list_artifacts">
                    <ul class="list-inline">
                        @foreach($list_artifacts as $artifact)
                            <li>
                                {!! Form::checkbox('artifact_id', $artifact->id) !!}
                                <img src="{{asset($artifact->image)}}" alt="{{$artifact->name}}">
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div id="list_tasks"></div>
                {!! Form::button('<i class="fa fa-plus"></i> Отправить', ['id' => 'send_mission' ,'class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {!! Html::style('css/aglok/mission.css') !!}
    {{--{!! Html::script('js/aglok/mathjax/MathJax.js?config=default')!!}--}}
    {{--{!! Html::script('js/aglok/tasks.js') !!}--}}
    {{--{!! Html::script('js/aglok/mission.js') !!}--}}
@stop