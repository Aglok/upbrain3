$(function(){
    var set_id = document.location.pathname.match(/\d{0,5}$/)[0];
    
    /**
    * Преобразование svg->png mathjax формулы
    * */
    $('#convert_svg_to_png').on('click', function () {
        var svg = $('.MathJax_SVG > svg');
        svg.toImage();
    });

    /**
     * Видимость ответов в таблице показать или убрать
     * */
    $('#answer').on('click',function(){
        $('#dataTable').find('td.answer').toggleClass('visible-print', 'display');
        $(this).html('Открыть ответы')
    });

    $('#create_pdf').on('click',function(){
        $('body').scrollTop(0);
        createPDF('p');
    });

    $('#create_pdf_list').on('click',function(){
        $('body').scrollTop(0);
        createPDF('l');
    });

    /**
     * Создание html->canvas->pdf
     * html2canvas
     * jsPdf
     * Разбиение таблицы на несколько по значениям высот строк во временную таблицу
     * Условия отрисовки перебрасывания строк из старой таблицы в новую
     * Отрисовка таблицы в html2canvas и добавление в addImage(), addPage()
     * */
    function createPDF(orientation){

        var pdfWidth = document.documentElement.clientWidth;
        var pdfHeight = pdfWidth*1.4;
        //Также при экспортировании ширина экрана браузера должна совпадать с шириной pdf документа
        var pdf = new jsPDF(orientation, 'pt', [pdfWidth, pdfHeight]);// pt - px; ширина 1240, высота 1754 размер a4 при 150 dpi

        var pdfInternals = pdf.internal;
        //Объект содержит размер pdf cтраницы
        var pdfPageSize = pdfInternals.pageSize;
        var pdfPageWidth = pdfPageSize.width-40;//1240px
        var pdfPageHeight = pdfPageSize.height-40;//1753px-40px// учитывем строки в thead, которые будут на каждой странице

        //Оступы создаваемого изображения таблицы
        var marginTop = 20;
        var marginLeft = 20;

        var table = $('#dataTable');
        var rows = table.find('tbody > tr');

        if(orientation == 'l'){
            pdfPageWidth = pdfPageWidth+40;
            marginLeft = 0;
            rows = table.find('tr');
        }

        //При создании новой таблицы стили mathjax сбиваются, создаём заного динамически
        rows.find('td > .MathJax_Display').css('display', 'inline');

        //высота таблицы
        var heightTable = parseInt(table.css('height'));
        //счётчики для отслеживания строк и суммарной высоты
        var count = 0;
        var height = 0;
        var width = 0;
        //Количество страниц дробное число
        var n = heightTable/pdfPageHeight;
        //сколько страниц а4 получится округление на увеличение
            var page = Number.isInteger(n) ? n : Math.floor(n)+1;
            console.log(page, heightTable, pdfPageHeight, n, typeof n);
        //Текущая страница
        var currentPage = 1;

        var createTablePartial = function(){

            var table_temp = $('<table><tbody></tbody></table>');

            rows.each(function(i, row){

                //Получаем ячейку содержащую формулу
                var tdFormula = row.cells[2];

                //Условия для запуска от какого числа строк создавать следующую страницу
                if(i >= count){

                    //Необходимо написать проверку на существование изображения в ячейке от этого будет
                    // задаваться временная прибавка к высоте pdfPageHeight + y, если изображения нет.

                    //Получаем высоту строки и складываем
                    height += parseInt(tdFormula.clientHeight);
                    width += parseInt(tdFormula.clientWidth);

                    //Условие когда строки вмещаются в страницу a4
                    if(height <= pdfPageHeight) {

                        row.setAttribute('class', 'look');
                        //Когда мы вставляем в новую таблицу строки из старой таблицы перемещаются и не копируются
                        table_temp.append(row);
                        count++;
                    }else{
                        //Обнуление счётчика
                        height = 0;
                        return false;
                    }
                }

            });
            console.log(table_temp);
            return table_temp;
        };

        var createPdfPage = function (){

            if (count >= rows.length - 1) {
                pdf.save('set_of_tasks_'+ set_id +'.pdf');
                return;
            }

            //Отрисовываем новую таблицу и получаем список строк для текущей страницы
            var tablePartial = createTablePartial().find('tbody').html();
            console.log(tablePartial);
            //Прячем все строки невошедшие в страницу
            table.find('tbody > tr:not(.look)').css('display', 'none');
            //Вставляем строки в таблицу вошедшие в страницу
            table.find('tbody').append(tablePartial);

            var widthCanvas = table[0].clientWidth;
            var heightCanvas = widthCanvas*1.41;

            html2canvas(table,
                {
                    background: "white",
                    imageTimeout:2000,
                    removeContainer:true
                    //width: widthCanvas, //Взять ширину таблицы  в px и отобразить скриншот в виде изображения, если не указана размеры то скрипт подгоняет под всю ширину и длину указанные во вставке скриншота
                    //height: heightCanvas //Взять высоту таблицы в px и отобразить скриншот в виде изображения
                })
                .then(function(canvas){

                    if(currentPage <= page){

                        //Если страница последняя, изображение берём из суммарной величины строк
                        if(currentPage == page) {
                            console.log(currentPage);
                            //Вставляем скриншот canvas в визуальную pdf страницу ввиде изображения, если размеры не подходят, то изображение сжимается или растягивается.
                            //Поэтому необходимо точно подобрать размер изображения и размер pdf страницы
                            console.log(widthCanvas, height, heightCanvas);
                            pdf.addImage(canvas, 'jpg', marginLeft, marginTop, widthCanvas, height);
                        }else{
                            //Размеры изображения по величине страницы
                            pdf.addImage(canvas, 'jpg', marginLeft, marginTop, widthCanvas, heightCanvas);
                        }

                        currentPage++;

                        if(count < rows.length-1){
                            pdf.addPage();
                        }
                    }
                    //Обратно показываем все спрятанные строки
                    table.find('tbody > tr:not(.look)').css('display', '');
                    table.find('tbody > tr.look').removeClass();
                //Следующая итерация внутри функции canvas, так как then является асинхронным запросом
                createPdfPage();
            });
        };
        createPdfPage();
    }

    /**
     * Вставляем в таблицу учеников из выбранной группы
     * */
    $('#group').change(function () {

        var group_id = $(this).val();
        var count = $('#dataTable').find('tr')[0].children.length - 2;

        $.get('ajax/group', {group: group_id}, function (data) {
            buildTable(count, data);
        });
    });

    /**
     * int count - количество столбцов
     * object obj - объект содержащий информацию для столбцов
     * return html
     * */
    function buildTable(count, obj){

        $('#dataTable').find('tfoot').remove();

        var tfoot = $('<tfoot></tfoot>');

        for(var i=0; i < obj.length; i++){
            var tr = $('<tr></tr>');
            var td = '<td>'+(i+1)+'</td>'+'<td><span>'+obj[i].surname+'<br>'+obj[i].name+'</span></td>';

            for(var j=0; j < count; j++){
                td += '<td></td>';
            }
            tr.html(td);
            tfoot.append(tr);

            $('#dataTable').append(tfoot);
        }
    }
});