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