/**
 * Создать общий объект class Chat
 * prop:
 *      protected thread_id;
 *      public divBody;
 *      public divHeader;
 *
 * methods:
 *      createTab(innerEl)
 *      initPlagins();
 *      toggleActiveTab();
 *      infoMsgChat();
 *      clearChat();
 *      showThreads();
 *      showThreadMessages();
 *      showUsers();
 *      send();
 *      previewImages();
 *      checkBoxUsers();
 */
$(function () {
    /* Установка jquery-ajax запроса с csrf-token
     Берём значение token из скрытового input
     Отправляем с заголовком
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Глобальные переменные для отправки чата
    var thread_id = 0,
    //Конетейнер с переменным содержимым
    divBody = $('#content-body'),
    divHeader = $('#content-header'),

    //Создадим ul для списка tab-ов
    ulTab = $('\<ul></ul>').addClass('nav media').attr('id','chat-tab'),
    liTabMain = '\<li class="first" style="display:none"><a href="#chat-panel_0">К списку</a></li>';
    ulTab.append(liTabMain);
    divHeader.append(ulTab);


    //Модальное окно bootstrap
    var divListBody =$('div.users > .panel-body');
    var divModal = $('div.modal-body');

    //Активируем tab bootstrap
    $('#chat-tab').on('click','a',function(e){

        e.preventDefault();
        $(this).tab('show');

        var url = $(this).attr('href');
        thread_id = url.match(/\d{1,}/)[0];
        
        //Убираем класс и снимает все выбранные галочи в checkbox
        divListBody.find('.list-group').removeClass('in active').find('input[type="checkbox"]').removeAttr('checked');
        divListBody.find('div[data-href="'+url+'"]').toggleClass('in active');

    });

    /**
     * Вставляет текст в выбранный элемент в чате
     * Для списка участников чата
     */
    // function infoChat(selector, text) {
    //     selector.find('.alert').remove();
    //     selector.prepend('\<div class="alert alert-warning hidden"></div>');
    //     selector.find('.alert').removeClass('hidden').fadeOut(10000).text(text);
    // }

    /**
     * Чистит html код в чате при клике на пункт меню
     */
    function clearChat() {
        
        $('ul.chat').empty();
        divListBody.empty();

        var divTabContent = divBody.find('> div.tab-content');
        //Проверяем на существование блока, и удаляем если есть.
        //Для случая обновления списка thread
        if(divTabContent.length >= 1){
            divTabContent.remove();
        }else
            divTabContent.empty();

        //Очистить все li в внутри ul, кроме первого элемента li(необходим для вкладки общий список тем)
        $(divHeader).find('ul#chat-tab li:not(.first)').removeClass('nav-tabs').empty();
    }
    
    /**
     * Выводим информацию о созданных темах в чате
     */
    $('#list-tasks').on('click', ajaxListThread);

    function ajaxListThread(){

        ulTab.find('li.first').css('display','block');

        clearChat();

        $.ajax({
            url: "messages",
            success: function(data) {

                //Получаем html список thread, для пользователя
                divBody.append(data);

                buildHtmlMsg();
                toggleClassForTab();
            }
        });
    }
    /**
     * Получим все сообщения все пользователей для темы и вставим html списки для tab, modal
     */
    function buildHtmlMsg() {

        $('ul.chat').on('click','a',function(){

            //Получим данные ссылки
            var url = $(this).attr('data-href'); //Можно спарсить аттрибут и вытащить от туда thread->id и в шаблоне show поменять в href
            thread_id = url.match(/\d{1,}/)[0];
            var text = $(this).text();

            //Проверяем по длине объекта, на повторное создание одинакового элемента
            //Если длина не 0, то делаем активную(class active) уже имеющуюся вкладку
            //var aTab = $('ul li a[href="#chat-panel_'+id+'"]');
            var aTab = ulTab.find('li a[href="#chat-panel_'+thread_id+'"]');

            //При повторном нажатии на ссылку темы отменяем появлении вкладки
            if(aTab.length){
                return;
            }

            ajaxListMessages(url, text);
        });
    }

    /**
     * Формирование html сообщений в thread, и вставка в dom
     * Добавлен параметр isUpdate, обновлять контент true
     * */
    function ajaxListMessages(url, text) {

        $.ajax({
            url: url,
            success: function(data)
            {
                var liTab = '\<li><a href="#chat-panel_'+thread_id+'"\>'+text+'\</a></li>';
                ulTab.addClass('nav-tabs').append(liTab);

                divBody.find('> div.tab-content').append(data.htmlMessages);

                //Построение списка участников в модальном окне

                divListBody.append(data.htmlUsers);
                checkBoxUsers();
                toggleClassForTab();

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('Ошибка: '+errorThrown);
            }
        });
    }

    /**
     * Создаёт thread, заголовок и текст
     * */
    $('#create').on('click', ajaxCreateThread);

    function ajaxCreateThread() {

        divModal.empty();
        
        $.ajax({
            url: 'messages/create',
            success: function(data)
            {
                divModal.append(data);
                checkBoxUsers();
                sendThread();
                ajaxListThread();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('Ошибка: '+errorThrown);
            }
        });
    }
    
    function sendThread() {

        $('#send-thread').on('click', function (e) {
            
            e.preventDefault();

            var form = $('#create-form'),
                subject = $('#create-subject').val(),
                message = $('#create-message').val(),
                users = form.find('input:checkbox:checked');

            if(subject.length < 2 && message.length < 10){
                infoChat(form,'Недостаточно символов для полноценного предложения. В "Теме" не менее 2 символов, в "Сообщении" не менее 10');
                return;
            }

            if(!users.length){
                infoChat(form,'Выберите участников для этой темы. Те кто будет видеть ваши сообщения!');
                return;
            }

            var data_form = form.serialize();

            $.ajax({
                type: 'POST',
                url: 'messages/store',
                data: data_form,

                success: function (data) {
                    console.log(data);

                    ajaxListThread();
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('Ошибка:' + errorThrown);
                }
            });
        })
    }
    /**
     * Подгрузка превью изображений и формирирования полей для отправки
     * Добавлен progress bar загрузки изображений
     * */
    function previewImages(){

        var previewWidth = 100, // ширина превью
            previewHeight = 100, // высота превью
            maxFileSize = 2 * 1024 * 1024, // (байт) Максимальный размер файла (2мб)
            selectedFiles = {},// объект, в котором будут храниться выбранные файлы
            queue = [],
            image = new Image(),
            imgLoadHandler,
            isProcessing = false,
            errorMsg, // сообщение об ошибке при валидации файла
            previewPhotoContainer = document.querySelector('#preview-photo'); // контейнер, в котором будут отображаться превь


        $('#images').on('change', function () {
            
            var files = $(this)[0].files;

            for(var i=0; i < files.length; i++){

                var file = files[i];

                // В качестве "ключей" в объекте selectedFiles используем названия файлов
                // чтобы пользователь не мог добавлять один и тот же файл
                // Если файл с текущим названием уже существует в массиве, переходим к следующему файлу
                if (selectedFiles[file.name] != undefined) continue;

                // Валидация файлов (проверяем формат и размер)
                if ( errorMsg = validateFile(file) ) {
                    alert(errorMsg);
                    return;
                }

                // Добавляем файл в объект selectedFiles
                selectedFiles[file.name] = file;
                queue.push(file);
            }

            $(this).val('');//Чистим input, чтобы потом создать отдельный input, для каждого фото
            processQueue(); // запускаем процесс создания миниатюр
        });

        // Валидация выбранного файла (формат, размер)
        var validateFile = function(file)
        {
            if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                return 'Фотография должна быть в формате jpg, png или gif';
            }

            if ( file.size > maxFileSize ) {
                return 'Размер фотографии не должен превышать 2 Мб';
            }
        };

        var listen = function(element, event, fn) {
            return element.addEventListener(event, fn, false);
        };

        // Создание миниатюры
        var processQueue = function()
        {
            // Миниатюры будут создаваться поочередно
            // чтобы в один момент времени не происходило создание нескольких миниатюр
            // проверяем запущен ли процесс
            if (isProcessing) { return; }

            // Если файлы в очереди закончились, завершаем процесс
            if (queue.length == 0) {
                isProcessing = false;
                return;
            }

            isProcessing = true;

            var file = queue.pop(); // Берем один файл из очереди

            var li = document.createElement('li');
            var span = document.createElement('span');
            var spanDel = document.createElement('span');
            var progress = document.createElement('progress');
            //var canvas = document.createElement('canvas');
            //var ctx = canvas.getContext('2d');
            var img = document.createElement('img');

            span.setAttribute('class', 'img');
            spanDel.setAttribute('class', 'delete ');
            img.setAttribute('class', 'img-thumbnail');
            progress.setAttribute('class', 'progressbar');
            progress.setAttribute('value', '0');
            progress.setAttribute('max', '100');
            spanDel.innerHTML = '<i class="fa fa-times"></i>';

            li.appendChild(span);
            li.appendChild(spanDel);
            li.appendChild(progress);
            li.setAttribute('data-id', file.name);

            img.removeEventListener('load', imgLoadHandler, false);

            // создаем миниатюру
            imgLoadHandler = function() {

                img.width = previewWidth;
                img.height = previewHeight;
                //ctx.drawImage(image, 0, 0, previewWidth, previewHeight);
                //img.appendChild(image);
                URL.revokeObjectURL(image.src);
                span.appendChild(img);
                //span.appendChild(canvas);
                isProcessing = false;
                setTimeout(processQueue, 200); // запускаем процесс создания миниатюры для следующего изображения
            };

            // Выводим миниатюру в контейнере previewPhotoContainer
            previewPhotoContainer.appendChild(li);
            listen(img, 'load', imgLoadHandler);
            img.src = URL.createObjectURL(file);

            // Сохраняем содержимое оригинального файла в base64 в отдельном поле формы
            // чтобы при отправке формы файл был передан на сервер
            var fr = new FileReader();
            fr.readAsDataURL(file);
            fr.onload = (function (file) {
                return function (e) {
                    $('#preview-photo').append(
                        '<input type="hidden" name="images[]" value="' + e.target.result + '" data-id="' + file.name+ '">'
                    );
                }
            }) (file);
        };


        // Удаление фотографии
        $(document).on('click', '#preview-photo li span.delete', function() {
            var fileId = $(this).parents('li').attr('data-id');

            if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // Удаляем файл из объекта selectedFiles
            $(this).parents('li').remove(); // Удаляем превью
            $('input[name^=images][data-id="' + fileId + '"]').remove(); // Удаляем поле с содержимым файла

        });

    }
    /**
     * Оправляем данные формы чата на серверы
     * */
    function send() {

        $('#btn-chat').on('click', function(e){

            e.preventDefault();
            e.stopPropagation();

            var message = $('#message').val();//Сообщение от пользователя message

            //Получим все данные с формы
            var form = document.getElementById('chat-form');

            var data = new FormData(form);

            //input checkbox recipients
            $('input:checked.recipients').val(function (i, value) {
                data.append('recipients[]', value);
            });

            if(!message){
                console.log('Нет сообщения!');
                infoChat($('#chat-footer'),'У вас нет сообщения!');
                return false;
            }

            if(!parseInt(thread_id)) {
                console.log('Выберите тему для сообщения!');
                infoChat($('#chat-footer'),'Выберите тему для сообщения!');
                return false;
            }

            stopLoadingAnimation(true);


            var progressBar = $('.progressbar');

            $.ajax({
                type: "POST",
                url: 'messages/'+thread_id,
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
                    $('#preview-photo > ').remove();
                    $('#message').val('');

                    //Добавляем сообщение в начале списка
                    divBody.find('> div.tab-content > ul#chat-panel_'+thread_id).prepend(data.html);

                    stopLoadingAnimation(false);
                    console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('Ошибка:'+errorThrown);
                }
            });
        });
    }

    /**
     * Функция скрывает содержимое контента при клике на владку tab панели
     * */
    function toggleClassForTab() {

        //Необходимо найти ul в html
        var ulChatMsg = $('ul.chat.msg');
        var divListUsers = divListBody.find('.list-group');

        //Проверяем наличие класса active у списка tab, и списка контейнера
        ulTab.find('li.active').toggleClass(function(){
            ulChatMsg.removeClass('in active');

            //Убираем класс и снимает все выбранные галочи в checkbox
            divListUsers.removeClass('in active').find('input[type="checkbox"]').removeAttr('checked');
            return 'active';
        });

        //Созданный элемент li активируем, как последнего в списке
        ulChatMsg.last().addClass('in active');
        divListUsers.last().addClass('in active');
        ulTab.find('li').last().addClass('active');
    }

    /**
     * Функция берёт значение скрытых чекбоксов в списке участников переписки 
     * Если участник выбран выделяется цветом, если нет цвет убирает
     * */
    function checkBoxUsers() {

        $('.recipients').change(function () {

            if($(this).is(':checked')){
                $(this).closest('label').addClass('checked-users');
            }else{
                $(this).closest('label').removeClass('checked-users');
            }
        });
    }

    /**
     * Функция показывет gif анимацию и отключает кнопку
     * Если сообщение отправлено обратно восстанавливает
     * */
    // function stopLoadingAnimation(bool) {
    //
    //     var img = $('#loadImg');
    //     var content = $('textarea#message');
    //     var button = $('#btn-chat');
    //
    //     if(bool){
    //
    //         button.prop('disabled', true);
    //         img.show();
    //         // вычислим в какие координаты нужно поместить изображение загрузки,
    //         // чтобы оно оказалось в серидине страницы:
    //         var contentCoords = img.position();
    //         var Y = contentCoords.top;
    //         var X = contentCoords.left;
    //
    //         console.log(X, Y);
    //         img.css({
    //             'height': '45px',
    //             'left': X + content.width() - img.width(),
    //             'top': '3px'
    //         });
    //     }else{
    //         button.prop('disabled', false);
    //         img.hide();
    //     }
    // }

    //Запуск
    ajaxListThread();
    send();
    previewImages();
});
