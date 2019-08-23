@extends('app')
@section('content')
    <div class="content-wrapper">
        <div class="content body">
            <div class="table-responsive margin-top">
                <table class="table-primary responsive table table-striped upbrain" id="dataTable">
                    <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th>{!! $column !!}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;?>
                    @foreach ($rows as $task)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$task->number_task}}</td>
                            <td>{{--{{$task->task}}--}}</td>
                            <td>{{$task->experience}}</td>
                            <td>{{$task->gold}}</td>
                            <td>{{$task->grade}}</td>
                            <td>{{$task->rating}}</td>
                            <td>{{$task->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    {{--{!! Html::style('css/aglok/tasks.css') !!}--}}
    {{--{!! Html::script('js/aglok/mathjax/MathJax.js?config=default')!!}--}}
    {{--{!! Html::script('js/aglok/tasks.js') !!}--}}
@stop