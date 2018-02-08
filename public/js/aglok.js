$(function(){
    $('#user_upgrade_skills').on('click', function(){
        //console.log(location.href);
        $.ajax({
            type: 'GET',
            url: location.href+'/user_upgrade_skills',
            data: {'upgrade': 'ok'}
        }).done(function (data) {
            infoChat($('.table-responsive'), data);
        });

    });
});

/**
 * Функция показывет gif анимацию и отключает кнопку
 * Если сообщение отправлено обратно восстанавливает
 * */
function stopLoadingAnimation(bool) {

    var img = $('#loadImg');
    var content = $('textarea#message');
    var button = $('#btn-chat');

    if(bool){

        button.prop('disabled', true);
        img.show();
        // вычислим в какие координаты нужно поместить изображение загрузки,
        // чтобы оно оказалось в серидине страницы:
        var contentCoords = img.position();
        var Y = contentCoords.top;
        var X = contentCoords.left;

        console.log(X, Y);
        img.css({
            'height': '45px',
            'left': X + content.width() - img.width(),
            'top': '3px'
        });
    }else{
        button.prop('disabled', false);
        img.hide();
    }
}

/**
 * Вставляет текст в выбранный элемент в чате
 * Для списка участников чата
 */
function infoChat(selector, text) {
    selector.find('.alert').remove();
    selector.prepend('\<div class="alert alert-warning hidden"></div>');
    selector.find('.alert').removeClass('hidden').fadeOut(10000).text(text);
}
$(function () {

    //Используем преобразование в select2
    $('#import-select').select2({
        placeholder: 'Выберите из списка раздел',
        allowClear: true
    });

    function displayOn() {

        var errorMsg, // сообщение об ошибке при валидации файла
            maxFileSize = 10 * 1024 * 1024; // (байт) Максимальный размер файла (10мб)

        // Валидация выбранного файла (формат, размер)
        var validateFile = function(file)
        {
            if (!file.name.match(/^(.*).(xls|xlsx|csv)/) ) {
                return 'Файл должен быть в формате xls, xlsx или csv';
            }

            if ( file.size > maxFileSize ) {
                return 'Размер файла не должен превышать 10 Мб';
            }
        };

        $('#import-select').change(function () {

            $('.import-file').css('display', 'block');

            $('#import-form').on('submit', function (event) {

                event.preventDefault();

                var formData = new FormData($(this).get(0));
                var file = $('#import-file').prop("files")[0];

                // Валидация файлов (проверяем формат и размер)
                if (errorMsg = validateFile(file) ) {
                    alert(errorMsg);
                    return;
                }

                swal.queue([{
                    title: 'Импортировать данные?',
                    html: $('<progress>')
                        .attr({value: 0, max: 100})
                        .addClass('progressbar')
                        .text('Загрузка файла'),
                    showCancelButton: true,
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет',
                    buttonsStyling: true,
                    showLoaderOnConfirm: true,

                    preConfirm: function () {

                        return new Promise(function (resolve) {

                            var progressBar = $('.progressbar');

                            $.ajax({
                                type: 'POST',
                                url: 'importExcel',
                                contentType: false, // важно - убираем форматирование данных по умолчанию
                                processData: false, // важно - убираем преобразование строк по умолчанию
                                data: formData,

                                xhr: function(){

                                    var xhr = $.ajaxSettings.xhr();

                                    xhr.upload.addEventListener('progress', function(event) {

                                        if(event.lengthComputable){

                                            progressBar.each(function(){

                                                var percent = Math.ceil(event.loaded/event.total*100);
                                                progressBar.val(percent);

                                            });
                                        }
                                    }, false);
                                    return xhr;
                                },
                                success: function(json){

                                    if(json){
                                        swal.insertQueueStep(json);
                                        progressBar.hide();
                                        resolve();
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown)
                                {
                                    console.log('Ошибка:'+ errorThrown);
                                }
                            });

                        })
                    }
                }
                ]).catch(function (e) {
                    console.log(e);
                })
            });
        });
    }

    displayOn();
});
$(function () {
    "use strict";
    /* Установка jquery-ajax запроса с csrf-token
     Берём значение token из скрытового input
     Отправляем с заголовком
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    /**
     * Функция берёт значение скрытых чекбоксов в списке задач
     * Если задача выбрана выделяется цветом, если нет цвет убирает
     * */
    function checkBoxTable() {

        $('#create_mission').on('click', 'li', function () {
            var input = $(this).find('input[name*="id"]');
            if (input.prop("checked"))
                input.prop('checked', false).closest('li').removeClass('selected');
            else
                input.prop('checked', true).closest('li').addClass('selected');
        });
    }

    function ajaxSelectMission(el, url) {

        //Используем преобразование в select2
        $(el).select2({
            placeholder: 'Выберите из списка задач',
            allowClear: true
        });

        $(el).on('change', function () {
            $('#list_tasks ul.list_tasks').remove();
            // Выбранная опция
            var id = $(this).val();
            //Запускаем запрос ajax и строим select

            $.ajax({
                type: 'POST',
                url: url,
                data: {id: id}
            }).done(function (tasks) {
                $('#list_tasks').append(tasks);
                $('#normalize').css('display', 'inline-block');
            });

        });
    }

    /**
     * Та же функция в process.js - объединить
     * Убираем начальный выбор select и заменяем на свой текст.
     * @var object
     * */
    function removeSelected(elBtn) {
        $(elBtn).each(function () {
            $(this).attr('title', 'Ничего не выбрано').html('Выберите набор задач <b class="caret"></b>');
        });

        var elUl = $(elBtn).next();
        var radioBtn = elUl.find('li.active input');
        radioBtn.each(function () {
            $(this).attr('checked', false).closest('li').removeClass('active');
        });
    }

    /**
     * Отправляем данные на сервер по нажатию кнопки
     * */
    $('#send_mission').on('click', function () {

        var mission_data = $('#create_mission').serializeArray();

        //Берём значение из модифицированного select
        var inputValId = $('#set-of-task').val();
        if (inputValId) mission_data.push({ 'name': 'set_of_tasks_id', 'value': inputValId });

        var json = JSON.stringify(mission_data);

        $.ajax({
            type: 'POST',
            url: 'send_mission',
            data: { json: json }
        }).done(function (response) {
            swal({
                type: 'success',
                title: response,
                showConfirmButton: true
            }).then(function () {
                location.href = '/admin/list_missions';
            })
        });
    });

    /**
     * Отправляем данные на сервер по нажатию кнопки
     * */
    $('#edit_mission').on('click', function () {

        var mission_data = $('#create_mission').serializeArray();

        //Берём значение из модифицированного select
        var inputValId = $('#set-of-task').val();
        mission_data.push({ 'name': 'set_of_tasks_id', 'value': inputValId });

        var json = JSON.stringify(mission_data);

        $.ajax({
            type: 'POST',
            url: 'save',
            data: { json: json, param: 'edit', id: $('#mission-id').text() }
        }).done(function (response) {
            swal({
                type: 'success',
                title: response,
                showConfirmButton: true
            }).then(function () {
                location.href = '/admin/list_missions';
            })
        });
    });

    /**
     * Удаляем миссию по нажатию кнопки
     * */

    $('.delete_mission').on('click', function () {

        var url = $(this).attr('data-href');

        swal({
            title: 'Подтвердить',
            text: 'Вы уверены, что хотите удалить это сообщение?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Удалить!',
            cancelButtonText: 'Пока не буду!'
        }).then(function () {
            $.ajax({
                type: 'GET',
                url: url
            }).done(function (response) {
                swal( 'Удалено', response, 'success').then(function () {
                    location.reload();
                });
            });

        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal('Отменено', 'Ваши данные сохранены!','error')
            }
        })

    });

    ajaxSelectMission('#set-of-task', 'list_tasks');
    checkBoxTable();
    removeSelected('.btn-group > button.multiselect');

});
$(function () {
    "use strict";
    /* Установка jquery-ajax запроса с csrf-token
       Берём значение token из скрытового input
       Отправляем с заголовком
    */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });
    //Инициализируем select2
    $('#group').select2({
        placeholder: 'Выберите из списка задач',
        allowClear: true
    });
    //Инициализируем datateble.responsive
    $('#dataTable').DataTable( {
        responsive: true
    });

    //Глобальный объект содержит усиление характеристик, ученика performance enhancement
    var PE = {};
    PE.oldValue = [];//Массив для хранения первоначальных данных опыта и золота

    /**
     * Функция принимает массив данных характеристик от трофеев или артефактов и id ученика.
     * Наполняет объект данными характеристик
     * @var array
     * return @object
     * */
    function setPEparam(data, id){

        PE[id] = {};//Индивидуальное хранение данных опыта и золота по id

        if(data.length > 2){
            var artifacts = data[2];
            if(artifacts.length){

                for(var i=0; i < artifacts.length; i++){
                    if('increase_gold' in artifacts[i]){
                        PE[id].gold = +artifacts[i].increase_gold;
                    }
                    if('increase_experience' in artifacts[i]){
                        PE[id].experience = +artifacts[i].increase_experience;
                    }
                }

                setInputExpGold(true, id);

            }else setInputExpGold(false, id);
        }
    }

    /**
     * Функция меняет значение опыта и золота в зависимости от характеристик трофея или артефакта.
     * @var bool isArtifactLength, если усиление есть значит меняем характеристи, если нет вернуть назад
     * */
    function setInputExpGold(isArtifactLength, id){

        var PEexp = PE[id].experience || 0;
        var PEgold = PE[id].gold || 0;

        $('input:checkbox').closest('tr').each(function(j, tr) {

            var oldValue = {};//Объект для хранения старых значений
            var td = tr.children;

            for(var i=0; i<td.length; i++) {

                var input = td[i].firstElementChild;

                if (!input) continue;
                var attr = input.getAttribute('name');

                if (attr == 'experience') {

                    //Условие если изменения произошли, то возвращаем первоначальные значения
                    if  (PE.change)
                        input.value = PE.oldValue[j].experience;
                    else
                        oldValue.experience = input.value;//Самый первый раз, сохраняем значения без изменения

                    if (isArtifactLength) {
                        //Сохраняем в глобальный объект опыт
                        input.value = input.value * (1 + PEexp);
                    }
                }
                if (attr == 'gold') {

                    //Условие если изменения произошли, то возвращаем первоначальные значения
                    if (PE.change)
                        input.value = PE.oldValue[j].gold;
                    else
                        oldValue.gold = input.value;

                    if (isArtifactLength) {
                        input.value = input.value * (1 + PEgold);

                    }
                }
            }

            if(!PE.change)
                PE.oldValue.push(oldValue);

        });

        PE.change = true;
    }


    /*
    * Функция выводит текст в option
    * @var Object
    * @return string
    * */
    function textArgument(obj){
        var arg = '';
        if(obj[1] == 'surname') arg = this[obj[1]]+' '+this[obj[0]];
        else{
            for (var i = 0; i < obj.length; i++){
                if(i == obj.length-1)
                    arg += '('+this[obj[i]]+')';
                else
                    arg += this[obj[i]]+' ';
            }
        }
        return arg;
    }

    /*
     * Функция создает ajax запрос и получает значение с сервера
     * @var string
     * @var string
     * @var string
     * */

    function ajaxSelect(url, selectedParam) {

        $.ajax({
            type: 'POST',
            url: url,
            data: {id: selectedParam}
        }).done(function (data) {
            //data - объект модели users
            //Удаление лишних элементов, после создания списка для другой группы
            var model = data[0];
            var param = data[1];
            var arrModels = [{id: '', text:''}];

            //Наполняем объект PE данными из массива data, если массив имеет 3ий элемент->характеристики
            setPEparam(data, selectedParam);
            //Меняем значения опыта и золота от PE
            console.log(PE);

            //Выбрать элемент с указанным id
            var elSelect = $('label[for='+param.idNameSelect+']');

            if ($('select').is('#' + param.idNameSelect)) {
                elSelect.nextAll().remove();//<div class="btn-group>...</div> удаляет все элементы после указанного elSelect
                elSelect.remove();//<select id='users'>...</select>
            }
            var select = $('<select/>', {
                id: param.idNameSelect,
                name: param.idNameSelect,
                class: 'multiselect form-control',
                'data-select-type': 'single'
            });

            var label = $('<label/>', {
                for: param.idNameSelect,
            });

            //Наполняем список options
            $.each(model, function () {
                arrModels.push({
                    id: this.id,
                    text: textArgument.bind(this, param.prop)()
                });
            });
            console.log(arrModels);


            label.append(select);
            $('#select').append(label);
            //Используем преобразование в select2
            $('.multiselect'+'#'+param.idNameSelect).select2({
                placeholder: 'Выберите из списка задач',
                allowClear: true,
                data: arrModels
            });

            //Удаляем лишний select после выбора
            if(param.url){
                refreshSelects(param.url, param.idNameSelect);
            }

        });
    }

    /*
     * Функция инициализирует выбор из списка и запускает ajax зарос
     * @var string
     * @var string
     * */
    function refreshSelects(url, idEl){
        // Ждем изменений
        $('#'+idEl).change(function(){

            // Выбранная опция
            var id = $(this).val();
            //Запускаем запрос ajax и строим select
            ajaxSelect(url , id);

        });
    }

    /*
     * Как создать объект который можно будет наполнять не перезаписывая уже созданный,
     * при вызове второй такой функции
     * Функция собирает заниечения input и ими наполняет объект task
     * Принимает элемент родитель->input и глобальный объект task
     * Учитывается усиления с трофеев
     * @var element
     * */
    function buildObjTask(el_parent, task) {

        for(var i=0; i<el_parent.length; i++){

            var input = el_parent[i].firstElementChild;

            if(!input) continue;
            var attr = input.getAttribute('name');

            if(attr == 'subject_id') task[attr] = input.getAttribute('data-num');
            else task[attr] = input.value;
        }
    }

    refreshSelects('group','group');


    //Начинаем путь перехода на плагин dataTable
    //console.log(table.column(3).data().sum());
    var data = {};
    var array = [];//вспомогательный массив для преобразования в json и отправки на сервер

    $('#send-process').on('click', function(){

        var button = $(this);
        button.prop('disabled', true);

        $('.sub_tr').remove();

        var user = {};//объект будет содержать информацию о учениках
        //var input = $('#select li.active input[type=radio]');
        var selects = $('#select select');
        var num_lesson = $('input[name=number_lesson]');
        //var exp_progress = $('input[name=exp_progress]');

        //Если чекбоксы выбраны -> берём все данные из ячеек строки
        $('input:checkbox:checked').closest('tr').each(function(j, tr){

            var task = {};//объект будет содержать информацию о задачах

            var td = tr.children;

            buildObjTask(td, task);

            //Если есть скрытые элементы td в следствии работы скрипта responsive.dataTable,
            //то получим их из списка
            var tr_next = tr.nextSibling;
            if(tr_next && tr_next.getAttribute('class') == 'child'){
                var span_data = tr_next.querySelectorAll('td > ul > li > span.dtr-data');
                buildObjTask(span_data, task);

            }
            array[j] = task;//Записываем объект в массив
        });

        //Проверяем выбраны ли задачи!
        if(!array.length){
            console.log('Выберите задачи');
            return false;
        }

        //Если select выбраны -> берём данные
        for(var i=0; i < selects.length; i++){
            var name = selects[i].getAttribute('name');
            var value = selects[i].value;
            user[name] = value;
        }

        user[num_lesson.attr('name')] = num_lesson.val();
        //user[exp_progress.attr('name')] = exp_progress.val();

        data.task = array;
        data.user = user;

        //Добавляем строку и объекты D, C, B, A  в data и подсчитываем сумму очков и золота по grade и subject
        buildHtml();

        //Проверка на выбранные списки
        if(!validateSelect(user)) return;

        //Преобразование в json
        var json = JSON.stringify(data);
        //console.log(json);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'save',//возможно для разных предметов менять параметр save_math, save_phys или использовать относительный путь как сейчас math/save, phys_save
            data: {json: json}
        }).done(function (res) {
            console.log(res);

            array = [];
            data = {};

            button.prop('disabled', false);
        });
    });
    //Функция считает сумму значений столбцов по experience и gold и добавляет в конец таблицы строки
    function sumParamHtml(arr, text, bool, subject){
        var sumExp = 0;//сумма золота
        var sumGold = 0;//сумма опыта
        var count = arr.length;//количество решённых задач
        var addExp = 0; //Добавка к опыту в зависимости от рейтинга

        for(var i=0; i<count; i++){
            var k = arr[i].rating*0.1; //Коэффициент зависит от рейтинга, увеличивает прибавку к опыту
            addExp += +(arr[i].experience * k);
            sumExp += +(arr[i].experience * (1+k));//Добавляется 10-50% к задаче в зависимости от рейтинга(1-5) и характеристик вещей
            sumGold += +arr[i].gold;//Добавляется % к задаче в зависимости от характеристик вещей
            if(bool)
                subject.push(arr[i].subject_id);
        }

        if(!bool){
            //Для вывода уникального значения кода предмета из данных
            var re = /[^.](\d){0,5}$|(\d(?:\.\d){0,5})/i;
            var subject_id = text.match(re);
            console.log(subject_id);
            //return;

            //Создаём объекты данных для передачи на сервер
            if(/D/.test(text)){
                var grade_D = new Grade('D',sumExp, sumGold, count, subject_id[0]);
                data.D.push(grade_D);
            }else if(/C/.test(text)){
                var grade_C = new Grade('C',sumExp, sumGold, count, subject_id[0]);
                data.C.push(grade_C);
            }else if(/B/.test(text)){
                var grade_B = new Grade('B',sumExp, sumGold, count, subject_id[0]);
                data.B.push(grade_B);
            }else if(/A/.test(text)){
                var grade_A = new Grade('A',sumExp, sumGold, count, subject_id[0]);
                data.A.push(grade_A);
            }
        }
        var str = '\<tr class="sub_tr" role="row"><td colspan="3">'+ text +'\</td>'
            +'\<td>Суммарный опыт:' + sumExp + '\</td>'
            + '\<td>Прибавка к задачам:'+ addExp +'\</td>'
            + '\<td>Суммарно монет:' + sumGold +'\</td>'
            + '\<td>Решённых задач:' + count +'\</td>' +
            '\<\tr>';

        $('table.table tbody').append(str);
    }
    //Функция делает html пристройку к таблице
    //для вывода суммы значений
    //по фильтру данных(grade и subject_id)
    function buildHtml(){
        var newArray = array.slice();
        var subject = [];
        data.D = [];//массивы для хранения данных суммы опыта и монет
        data.C = [];
        data.B = [];
        data.A = [];

        sumParamHtml(newArray, 'Всего', true, subject);

        var uniqueSubject = uniqueArray(subject);

        for(var i=0; i<uniqueSubject.length; i++){

            var arr = filterArray(newArray, 'subject_id', uniqueSubject[i]);

            var D = filterArray(arr,'grade','D');
            var C = filterArray(arr,'grade','C');
            var B = filterArray(arr,'grade','B');
            var A = filterArray(arr,'grade','A');

            (D.length) ? sumParamHtml(D, 'D grade '+'раздел № '+uniqueSubject[i], false):false;
            (C.length) ? sumParamHtml(C, 'C grade '+'раздел № '+uniqueSubject[i], false):false;
            (B.length) ? sumParamHtml(B, 'B grade '+'раздел № '+uniqueSubject[i], false):false;
            (A.length) ? sumParamHtml(A, 'A grade '+'раздел № '+uniqueSubject[i], false):false;
        }

    }

    //Вспомогательная функция создаёт объект для сохранения данных о суммарных данных
    function Grade(grade, sumExp, sumGold, count, subject_id){
        this.grade = grade;
        this.sumExp = sumExp;
        this.sumGold = sumGold;
        this.sumTask = count;
        this.subject_id = subject_id;
    }

    //Вспомогательная функция выбирает уникальные значения массива
    function uniqueArray(array){
        var j = array.length;

        array.sort(function(a,b){
            return a-b;
        });

        while(j--){
            if(array[j] == array[j-1])
                array.splice(j, 1);
        }
        return array;
    }
    //Вспомогательная функция фильтрует массив по значению объекта
    function filterArray(array, name, prop){
        return array.filter(function(num){
            return num[name] == prop;
        });
    }
    //Валидация данных на выбранные обязательные списки
    function validateSelect(obj){
        var names = {'group': true, 'users': true, 'stages': true, 'number_lesson':true, 'user_progress': true};
        var str = '';
        for(var key in names){

            if(!obj[key]){
                //Если достижения не выбраны, то создаем свойство с пустой строкой
                if(key == 'user_progress'){
                    obj.user_progress = '';
                    continue;
                }

                str += key + ' ';
            }
        }
        if(str.length) {
            console.log('Пожалуйста выберите следующие поля: '+ str);
            return false;
        }
        else {
            console.log('Данные успешно отправлены!');
            return true;
        }
    }

    /**
     * Функция берёт значение скрытых чекбоксов в списке задач
     * Если задача выбрана выделяется цветом, если нет цвет убирает
     * */
    function checkBoxTable() {

        $('#dataTable tbody').on( 'click', 'tr', function () {
            var input = $(this).find('> td input[name="id"]');

            if(input.prop("checked"))
                input.prop('checked', false).closest('tr').removeClass('selected');
            else
                input.prop('checked', true).closest('tr').addClass('selected');
        });
    }

    /**
     * Функция позывает/скрыват боковое меню и расширяет таблицу
     * */
    function showHideMenu() {
        $('#show-hide-menu').on('click', function () {
            $('aside.main-sidebar').toggleClass('process_menu_off', '');
            $('#page-wrapper').toggleClass('process_margin_off', '');
        });
    }

    checkBoxTable();
    showHideMenu();
});


// $(function() {
//     $('#side-menu').metisMenu();
// });

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
})
