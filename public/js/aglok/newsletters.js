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

    let array = [];//вспомогательный массив для преобразования в json и отправки на сервер
    let col = ['id', 'name', 'surname', 'email', 'group', 'state'];
    let progressBar = $('.progressbar');


    $('#button-send-newsletters').on('click', function(){

        $('input:checkbox:checked').closest('tr').each(function(j, tr){

            let users = {};//объект будет содержать информацию о пользователях для рассылки
            for(let i=0; i<tr.children.length; i++){

                let node = tr.children[i].firstChild;//первый узел внутри <td></td>
                let el = tr.children[i].firstElementChild;//первый элемент внутри <td></td>

                if(el){
                    users[col[i]] = el.value;
                }

                //if(!node.value.trim()) continue;
                console.log(node);

                //Проверяем тип узла => text
                if(node){
                    if(node.nodeType == 3){
                        users[col[i]] = node.nodeValue.trim();
                    }
                }else
                    continue;
            }
            array[j] = users;//Записываем объект в массив
        });

        let jsonListRecipients = JSON.stringify(array);

        //Валидация данных формы
        let mail_from = $('#create-mail-from').val(),//От кого
            create_subject = $('#create-subject').val();//Тема письма
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
        let form = document.getElementById('newsletters-form');
        let data = new FormData(form);
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

                let xhr = $.ajaxSettings.xhr();
                xhr.upload.addEventListener('progress',function() {

                    if(event.lengthComputable){

                        progressBar.each(function(){

                            let percent = Math.ceil(event.loaded/event.total*100);
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