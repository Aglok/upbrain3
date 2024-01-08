@extends('admin::_layout.inner')

@section('innerContent')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                 Импорт задач
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
        <div class="col-lg-6">
            {!! Form::open(['route' => 'importExcel', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {!! Form::label('import-select','Выберите в какую таблицу импортировать данные:') !!}
                <select name="import-select" id="import-select" data-select-type="single" class="multiselect form-control">
                    <option value="subjects">Темы</option>
                    <option value="tasks">Задачи</option>
                    <option value="users">Ученики</option>
                    <option value="processes">Процесс</option>
                </select>
            </div>
            <div class="form-group import-file">{!! Form::file('import-file') !!}</div>
            {!! Form::button('Импортировать файл', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    {!! Html::script('js/aglok/import.js') !!}
    {!! Html::style('css/aglok/import.css') !!}
@stop
