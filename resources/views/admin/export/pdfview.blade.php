<head>
    {!! Html::style('packages/sleepingowl/default/css/admin-app.css') !!}
    {!! Html::style('css/aglok/pdf.css') !!}
    <meta content="{{csrf_token()}}" name="csrf-token" />
</head>
<body>

    <div class="for_pdf">
        <button class="btn btn-primary" id="convert_svg_to_png">Преобразовать в png</button>
        <button class="btn btn-success" id="create_pdf">Скачать PDF</button>
        <a class="btn btn-success" href="javascript:test()">Test</a>

        <table class="table table-striped table-hover" id="dataTable">
            <thead>
            <tr>
                <td>№</td>
                <td>Номер</td>
                <td>Задача</td>
                <td>Опыт</td>
                <td>Золото</td>
                <td>Ответ</td>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach ($tasks as $task)
                <tr>
                    <td>{!! $i++ !!}</td>
                    <td>{!! $task->number_task !!}</td>
                    <td>{!! $task->task !!}</td>
                    <td>{!! $task->experience !!}</td>
                    <td>{!! $task->gold !!}</td>
                    <td>{!! $task->answer !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=default')!!}
{!! Html::script('packages/sleepingowl/default/js/admin-app.js')!!}
{!! Html::script('js/aglok/pdf/jspdf.min.js')!!}
{!! Html::script('js/aglok/pdf/jspdf.plugin.autotable.js')!!}
{!! Html::script('js/aglok/pdf/jquery-mathjax-to-png.js')!!}
{!! Html::script("http://cdn.rawgit.com/niklasvh/html2canvas/0.5.0-alpha2/dist/html2canvas.min.js") !!}
{!! Html::script('js/aglok/pdf/pdf.js')!!}

<script>
        function test(){

                var doc = new jsPDF('p', 'pt');
                doc.text("From HTML", 40, 50);
                var res = doc.autoTableHtmlToJson($("#dataTable").get(0));
                doc.autoTable(res.columns, res.data, {startY: 600});
                doc.save('table.pdf');

        }
</script>
