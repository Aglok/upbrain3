$(function () {
    "use strict";
    $('.offcanvas').on('click', function () {
        $(this).offcanvas('hide');
    });

    $(window).scroll(function(){
        if($(this).scrollTop() > 140){

            $('#navbar-fixed-top').css('display', 'block');
        }
        else if ($(this).scrollTop() < 140){
            $('#navbar-fixed-top').css('display', 'none');
        }
    });

    let data = {cls:"", subject:"", service:""}

    let OpenModal = function (modal_selector){

        $(modal_selector).on('show.bs.modal', function (event) {

            let button = $(event.relatedTarget) // Кнопка, запускающая модальное окно
            let cls = button.data('class') // Извлечь информацию из атрибутов data- *
            let subject = button.data('subject')
            let service = button.data('service')

            if(typeof cls !== 'undefined')
                data.cls = cls
            if(typeof subject !== 'undefined')
                data.subject = subject
            if(typeof service !== 'undefined')
                data.service = service
        })

    }


    //Функция принимает селектор id формы
    // Отправляет ajax запросом данные формы
    let SendForm = function sendForm(form_selector) {

        OpenModal("#contact-modal-junior")

        $(form_selector +' .btn').on('click', function (e) {

            e.preventDefault();

            let form = $(form_selector),
                button = $(this),
                name = $(form_selector + ' input[name=name]').val(),
                phone = $(form_selector + ' input[name=phone]').val(),
                email = $(form_selector + ' input[name=email]').val()

            //Блок код для обработки валидации формы junior: добавлены предметы и тип обучения
            if(form_selector === '#form-bottom-junior'){
                let subjects = [];
                let type_of_training = [];

                $(form_selector + ' input[name="subjects[]"]:checked').each(function () {
                    subjects.push($(this).val());
                });

                $(form_selector + ' input[name="type_of_training[]"]:checked').each(function () {
                    type_of_training.push($(this).val());
                });

                if(!subjects.length){
                    infoChat(form,'Выберите хотя бы один предмет');
                    return;
                }

                if(!type_of_training.length){
                    infoChat(form,'Выберите хотя бы один тип обучения');
                    return;
                }
            }

            if(typeof name !== 'undefined'){
                if(!name){
                    infoChat(form, 'Напишите пожалуйста Ваше имя.');
                    return;
                }
            }

            if(typeof phone !== 'undefined'){
                if(!phone){
                    infoChat(form,'Напишите пожалуйста Ваш телефон.');
                    return;
                }
            }

            if(typeof email !== 'undefined'){
                if(!email){
                    infoChat(form,'Напишите пожалуйста Вашу почту.');
                    return;
                }
            }

            let data_form = form.serialize();
            button.prop("disabled",true);

            $.ajax({
                type: 'POST',
                url: 'contact',
                data: data_form,

                success: function () {

                    button.prop("disabled",false);
                    if(typeof phone !== 'undefined'){
                        infoChat(form,'Ваши данные успешно оправлены, ожидайте мы вам перезвоним!');
                    }else{
                        infoChat(form,'Ваши данные успешно оправлены, на Вашу почту придёт информация!');
                    }

                    if ($('.modal').hasClass('show')) {
                        $(form_selector +' .btn').val('Закрыть').attr('data-dismiss', 'modal');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    console.log('Ошибка:' + errorThrown);
                }
            });
        })
    };

    //Изменение изображения при наведении курсора
    let ImgHover = function imgHover(img_selector) {

        let reg = /(\/\w{0,}).(\w{3,4})$/g;
        let img_src_old = $(img_selector).attr('src');

        $(img_selector).on('mouseover', function (e) {
            e.preventDefault();
            let img_src = $(this).attr('src').replace('png' , 'gif').replace(reg, '$1_hover.$2');
            $(this).attr('src', img_src);
        });

        $(img_selector).on('mouseout', function (e) {
            e.preventDefault();
            $(this).attr('src', img_src_old);
        });

    };


    //Выплывающая подсказка для изображения
    let ImageDescription = function imageDescription(img_selector){

        $(img_selector).on('click', function(e){

            let subject = $(this).find('a').attr('data-subject');
            let url_ege = 'course_ege_'+subject;
            let url_oge = 'course_oge_'+subject;

            if($(this).hasClass('animate'))
                $(this).find('div.cover').show().fadeOut(3000);
            else{

                $(this).addClass('animate');
                let div = $('<div/>', {'class':'cover'})
                    .css({
                        'width': $(this).width(),
                        'height': $(this).height(),
                        'position': 'absolute',
                        'bottom': 0,
                        'left': '11px',
                        'background': '#fff',
                        'opacity': 1
                    })
                    .html('<p class="p-1 m-t-lg"><a href="'+url_ege+'">Курсы ЕГЭ</a><br><a href="'+url_oge+'">Курсы ОГЭ/ГИА</a></p>')
                    .slideDown(100)
                    .fadeOut(12000);
                $(this).append(div);
            }
        });
    };

    //Добавляем в глобальный объект Jquery
    $.sendForm = function (form_selector) {
        return SendForm(form_selector);
    };

    $.initialiseFrom = function (array) {
        array.forEach(function(item) {
            $.sendForm(item);
        });
    };

    $.imgHover = function (img_selector) {
        return ImgHover(img_selector);
    };

    $.initialiseImgHover = function (array) {
        array.each(function(item, el) {
            $.imgHover('#'+el.id);
        });
    };

    $.imageDescription = function (img_selector) {
        return ImageDescription(img_selector);
    };

    $.imageDescription('ul.item-subject > li');
});
