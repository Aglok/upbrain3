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

    //Функция принимает селектор id формы
    // Отправляет ajax запросом данные формы
    let SendForm = function sendForm(form_selector) {

        $(form_selector +' .btn').one('click', function (e) {

            e.preventDefault();

            let form = $(form_selector),
                name = $(form_selector + ' input[name=name]').val(),
                phone = $(form_selector + ' input[name=phone]').val(),
                email = $(form_selector + ' input[name=email]').val();

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

            $.ajax({
                type: 'POST',
                url: 'contact',
                data: data_form,

                success: function () {
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
