<head>
    {!! Html::style('packages/sleepingowl/default/css/admin-app.css') !!}
    {!! Html::style('css/aglok/pdf.css') !!}
    <meta content="{{csrf_token()}}" name="csrf-token" />
</head>
<body>

    <div class="for_pdf">
        <button class="btn btn-primary" id="convert_svg_to_png">Преобразовать в png</button>
        <button class="btn btn-success" id="create_pdf">Скачать PDF</button>
        <a class="btn btn-success" id="answer">Закрыть ответы</a>

        <table class="table table-striped table-hover" id="dataTable">
            <thead>
            <tr>
                <td>Всего задач:</td>
                <td>{!! $count !!}</td>
                <td>Всего опыта:</td>
                <td>{!! $sum_exp !!}</td>
                <td>Всего монет:</td>
                <td>{!! $sum_gold !!}</td>
                <td class="answer display"></td>
            </tr>
            <tr>
                <td>№</td>
                <td>Номер</td>
                <td>Задача</td>
                <td>Опыт</td>
                <td>Золото</td>
                <td>Трудность</td>
                <td class="answer display">Ответ</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach ($tasks as $task)
                <tr>
                    <td>{!! $i++ !!}</td>
                    <td>{!! $task->number_task !!}</td>
                    <td>{!! $task->task !!}<br>
                        {{-- Проверяем для других предметов содержит ли свойство image --}}
                        @if(property_exists($task, 'image'))
                            @if($task->image)
                                <img src="{!! asset('images/tasks/'.$task->image) !!}" width="300px">
                            @endif
                        @endif
                    </td>



                    <td>{!! $task->experience !!}</td>
                    <td>{!! $task->gold !!}</td>
                    <td>{!! $task->grade !!}</td>
                    <td class="answer display">{!! $task->answer !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default')!!}
{!! Html::script('packages/sleepingowl/default/js/admin-app.js')!!}
{!! Html::script('js/aglok/pdf/jspdf.min.js')!!}
{!! Html::script('js/aglok/pdf/jquery-mathjax-to-png.js')!!}
{!! Html::script("http://cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js") !!}
{!! Html::script('js/aglok/pdf/pdf.js')!!}
