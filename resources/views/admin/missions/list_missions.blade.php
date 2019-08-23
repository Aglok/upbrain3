@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Список заданий
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
                {!! Form::open()!!}
                <a class="btn btn-default btn-sm" id="create" href="{!! route('create_mission') !!}">
                    Создать
                </a>
                <table class="table table-striped table-hover" id="dataTable">
                    <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th>{!! $column !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach ($missions as $mission)
                        <tr>
                            <td>{{ $mission->id }}</td>
                            <td>{!! $mission->name !!}</td>
                            <td>{!! $mission->description !!}</td>
                            <td>
                                <ol class="list">
                                    @foreach ($missions_param[$mission->id]['tasks'] as $tasks)
                                        {{--<li>{{ $tasks->task }}</li>--}}
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <ul class="list-unstyled">
                                    @foreach ($missions_param[$mission->id]['artifacts'] as $artifact)
                                        <li>
                                            <img src="{!! asset($artifact->image) !!}" alt="">
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{!! $mission->condition !!}</td>
                            <td>{!! $mission->user_level !!}</td>
                            <td class="text-right">
                                <a class="btn btn-primary btn-xs" href="{{ route('edit_mission', [$mission->id]) }}"
                                   data-toggle="tooltip" title="" data-original-title="Редактировать">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-xs btn-danger btn-delete delete_mission"
                                   data-href="{{ route('delete_mission', [$mission->id]) }}" data-toggle="tooltip"
                                   title="" data-original-title="Удалить">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--{!! Html::script('js/aglok/mathjax/MathJax.js?config=default')!!}--}}
    {{--{!! Html::script('js/aglok/tasks.js') !!}--}}
    {{--{!! Html::script('js/aglok/mission.js') !!}--}}
@stop