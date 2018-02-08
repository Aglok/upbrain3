$(function () {

    /* Установка jquery-ajax запроса с csrf-token
     Берём значение token из скрытового input
     Отправляем с заголовком
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        }
    });

    $('#newsletters-tab').on('click', 'a', function (e) {

        e.preventDefault();
        $(this).tab('show');
    });

    /**
     * Вставляет текст в выбранный элемент в чате
     * Для списка участников чата
     */
    function info(selector, text) {
        selector.find('.alert').remove();
        selector.prepend('\<div class="alert alert-warning hidden"></div>');
        selector.find('.alert').removeClass('hidden').fadeOut(10000).text(text);
    }

    var array = [];//вспомогательный массив для преобразования в json и отправки на сервер
    var col = ['id', 'name', 'email', 'group', 'state'];
    var progressBar = $('.progressbar');


    $('button.btn-primary').on('click', function(){

        $('input:checkbox:checked').closest('tr').each(function(j, tr){

            var users = {};//объект будет содержать информацию о пользователях для рассылки

            for(var i=0; i<tr.children.length; i++){

                var node = tr.children[i].firstChild;//первый узел внутри <td></td>
                var el = tr.children[i].firstElementChild;//первый элемент внутри <td></td>

                if(el){
                    users[col[i]] = el.value;
                }

                if(!node.data.trim()) continue;

                //Проверяем тип узла => text
                if(node.nodeType == 3){
                    users[col[i]] = node.data.trim();
                }
            }
            array[j] = users;//Записываем объект в массив
        });

        var jsonListRecipients = JSON.stringify(array);

        //Валидация данных формы
        var mail_from = $('#create-mail-from').val(),//От кого
            create_subject = $('#create-subject').val(),//Тема письма
            create_body = CKEDITOR.instances['create-body'].getData(); //Тело письма

        //Проверяем выбраны ли ученики!
        if(!array.length){
            info($('#newsletters-tab'), 'Выберите учеников');
            console.log('Выберите учеников');
            return false;
        }

        if(!mail_from){
            info($('#newsletters-tab'), 'Заполните поле "От"');
            console.log('Заполните поле "От"');
            return false;
        }

        if(!create_subject){
            info($('#newsletters-tab'), 'Заполните поле "Тема"');
            console.log('Заполните поле "Тема"');
            return false;
        }

        if(!create_body){
            info($('#newsletters-tab'), 'Напишите сообщение');
            console.log('Напишите сообщение');
            return false;
        }


        //Получим все данные с формы
        var form = document.getElementById('newsletters-form');
        var data = new FormData(form);
        data.append('jsonListRecipients', jsonListRecipients);
        data.append('body', create_body);

        sendAjax(data);
    });


    function sendAjax(data) {
        
        $.ajax({
            type: "POST",
            url: 'mail/send',
            data: data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            xhr: function(){

                var xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress',function() {

                    if(event.lengthComputable){

                        progressBar.each(function(){

                            var percent = Math.ceil(event.loaded/event.total*100);
                            progressBar.val(percent);

                        });
                    }
                }, false);
                return xhr;
            },
            success: function(data)
            {
                progressBar.hide();
                array= [];//очищаем массива данных
                console.log(data);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('Ошибка:'+errorThrown);
            }
        });
    }
});