<head>
    {!! Html::style('packages/sleepingowl/default/css/admin-app.css') !!}
    {!! Html::style('css/aglok/pdf.css') !!}
    <meta content="{{csrf_token()}}" name="csrf-token" />
</head>
<body>

    <div class="for_pdf_list">
        <button class="btn btn-primary" id="convert_svg_to_png">Преобразовать в png</button>
        <button class="btn btn-success" id="create_pdf_list">Скачать PDF</button>

        <label for="group">
            <select class="multiselect form-control" data-select-type="single" name="group" id="group">
                <option value="">Выберите группу</option>
                @foreach ($groups as $group)
                    <option value="{!! $group->group_math !!}">Группа №{!! $group->group_math !!}</option>
                @endforeach
            </select>
        </label>

            <table class="table table-striped table-hover" id="dataTable">
                <tbody>
                <?php $i = 1;?>
                @foreach ($buildList as $key => $td)
                    <tr>
                        @if($key == 'number_task')
                            {!! $td !!}<td>{!! $count !!}</td>
                        @elseif($key == 'experience')
                                {!! $td !!}<td>{!! $sum_exp !!}</td>
                        @elseif($key == 'gold')
                                {!! $td !!}<td>{!! $sum_gold !!}</td>
                        @else
                            {!! $td !!}<td></td>
                        @endif
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
