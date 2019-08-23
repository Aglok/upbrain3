@section('innerContent')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
               Статистика учеников
            </h1>
            @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ Session::get('message') }}
                </div>
            @endif
        </div>
    </div>
    <input hidden="hidden" name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <div class="alert"></div>
                {!! Form::button('<i class="fa"></i> Обновить данные', ['class' => 'btn btn-primary navbar-btn', 'id' => 'user_upgrade_skills']) !!}

                {!! Form::open()!!}
                <table class="table-primary table table-striped" id="dataTable">
                    <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th>{!! $column !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach ($rows as $tasks)
                        <tr>
                            <td>{{$i++}}</td>
                            <td><a href="{{ url('admin/user_home/'.$subject)}}/{{ $tasks->user_id }}">{{ $tasks->name }} {{ $tasks->surname }}</a></td>
                            <td>{{ $tasks->sum_exp }}</td>
                            <td>{{ $tasks->sum_gold }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
