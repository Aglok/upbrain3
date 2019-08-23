@section('innerContent')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Набор задач.
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
                    @foreach ($rows as $tasks)
                        @if($tasks->set_id)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{!! $tasks->name !!}</td>
                                <td><a href="{{ url('admin/process/'.$subject)}}/{!! $tasks->set_id !!}">{!! $tasks->tasks_count !!}</a></td>
                                <td>{!! $tasks->sum_exp !!}</td>
                                <td>{!! $tasks->sum_gold !!}</td>
                                <td><a href="{{ route('pdfviewtasks', ['id' => $tasks->set_id, 'subject' => $subject, 'tasks' => 'pdf', 'sum_exp' => $tasks->sum_exp, 'sum_gold' => $tasks->sum_gold, 'count' => $tasks->tasks_count]) }}">Скачать PDF</a></td>
                                <td><a href="{{ route('pdfviewlist', ['id' => $tasks->set_id, 'subject' => $subject, 'list' => 'pdf', 'sum_exp' => $tasks->sum_exp, 'sum_gold' => $tasks->sum_gold, 'count' => $tasks->tasks_count]) }}">Скачать Ведомость</a></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--{!! Html::script('js/aglok/process.js') !!}--}}
    {!! Html::style('css/aglok/process.css') !!}
@stop
