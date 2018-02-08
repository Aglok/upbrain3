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