@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Набор задач №<a href="#" data-toggle="tooltip" data-placement="top" title="">{!! $set_id !!}</a>
                {{--<button id="show-hide-menu" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-list"></i></button>--}}
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
            {!! Form::open()!!}
            <div id ='select'>
            <label for="number_lesson">Номер урока
                {!! Form::input('number', 'number_lesson', '') !!}
            </label>
                <label for="group">Выберите номер группы
                    <select class="multiselect form-control" data-select-type="single" name="group" id="group">
                        @if($subject == 'math')
                            @foreach ($groups as $group)
                                <option value="{!! $group->group_math !!}">Группа №{!! $group->group_math !!}</option>
                            @endforeach
                        @elseif($subject == 'physics')
                            @foreach ($groups as $group)
                                <option value="{!! $group->group_physics !!}">Группа №{!! $group->group_physics !!}</option>
                            @endforeach
                        @endif
                    </select>
                </label>
            </div>
            <div class="table-responsive">

                <table class="table table-striped upbrain display table-hover" cellspacing="0" width="100%" id="dataTable">
                    <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th>{!! $column !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; $arr = [];?>
                    @foreach ($rows as $task)
                        <tr>
                            <td>{{ $i++ }} {!! Form::input('checkbox', 'id', $task->task , ['class' => 'process']) !!}</td>
                            <td>{!! $task->task !!}</td>
                            <td>{!! $task->number_task !!}</td>
                            <td>{!! Form::text('original_number', $task->original_number, ['autocomplete' => 'off'] ) !!}</td>
                            <td>{!! Form::text('experience', $task->experience, ['autocomplete' => 'off'] ) !!}</td>
                            <td>{!! Form::text('gold', $task->gold, ['autocomplete' => 'off'] ) !!}</td>
                            <td>{!! Form::text('grade', $task->grade, ['autocomplete' => 'off'] ) !!}</td>
                            <td>{!! Form::textarea('section_id', (isset($task->section->name)) ? $task->section->name : '', ['autocomplete' => 'off', 'data-num' => $task->section_id, 'class' => 'text', 'cols' => '20' ,'rows' => '2'] ) !!}</td>
                            <td>{!! Form::text('rating', null, ['autocomplete' => 'off', 'placeholder' => '1-5'] ) !!}</td>
                            <td>{!! Form::textarea('comment', null, ['autocomplete' => 'off','cols' => '20' ,'rows' => '2'] ) !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::button('<i class="fa fa-plus"></i> Отправить', ['class' => 'btn btn-primary navbar-btn', 'id' => 'send-process']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {!! Html::style('css/aglok/process.css') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default')!!}
    {{--{!! Html::script('js/aglok/process.js') !!}--}}
    {{--{!! Html::script('js/aglok/tasks.js') !!}--}}
@stop
