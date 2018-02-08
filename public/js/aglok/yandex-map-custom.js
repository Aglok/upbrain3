ymaps.ready(function () {
    var myMap = new ymaps.Map('map-1', {
            center: [55.764455, 37.605939],
            zoom: 12
        }, {
            searchControlProvider: 'yandex#search',
        }),
    // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),

        myPlacemarkWithContent1 = new ymaps.Placemark([55.761578, 37.637928], {
            hintContent: 'Архангельский переулок, 9',
            balloonContentHeader: 'м. Чистые пруды, Архангельский переулок 9',
            balloonContent: 'Upbrain - подготовка к ЕГЭ, ОГЭ, ДВИ',
            iconContent: '1'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#imageWithContent',
            // Своё изображение иконки метки.
            iconImageHref: 'images/bg/icon_upbrain.gif',
            // Размеры метки.
            iconImageSize: [60, 80],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -38],
            // Смещение слоя с содержимым относительно слоя с картинкой.
            iconContentOffset: [25, 10],
            // Макет содержимого.
            iconContentLayout: MyIconContentLayout
        });

        myPlacemarkWithContent2 = new ymaps.Placemark([55.762617, 37.572908], {
            hintContent: 'Москва, Волков переулок, 7-9с1',
            balloonContentHeader: 'м. Краснопресненская, Москва, Волков переулок, 7-9с1',
            balloonContent: 'Upbrain - подготовка к ЕГЭ, ОГЭ, ДВИ',
            iconContent: '2'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#imageWithContent',
            // Своё изображение иконки метки.
            iconImageHref: 'images/bg/icon_upbrain.gif',
            // Размеры метки.
            iconImageSize: [60, 80],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -38],
            // Смещение слоя с содержимым относительно слоя с картинкой.
            iconContentOffset: [25, 10],
            // Макет содержимого.
            iconContentLayout: MyIconContentLayout
        });

        myPlacemarkWithContent3 = new ymaps.Placemark([55.786976, 37.592976], {
            hintContent: 'Новослободская улица, 55с1',
            balloonContentHeader: 'м. Новослободская, Новослободская улица, 55с1',
            balloonContent: 'Upbrain - подготовка к ЕГЭ, ОГЭ, ДВИ',
            iconContent: '3'
        }, {
            // Опции.
            // Необходимо указать данный тип макета.
            iconLayout: 'default#imageWithContent',
            // Своё изображение иконки метки.
            iconImageHref: 'images/bg/icon_upbrain.gif',
            // Размеры метки.
            iconImageSize: [60, 80],
            // Смещение левого верхнего угла иконки относительно
            // её "ножки" (точки привязки).
            iconImageOffset: [-5, -38],
            // Смещение слоя с содержимым относительно слоя с картинкой.
            iconContentOffset: [25, 10],
            // Макет содержимого.
            iconContentLayout: MyIconContentLayout
        });

    myMap.behaviors.disable('scrollZoom');
    myMap.geoObjects
        .add(myPlacemarkWithContent1)
        .add(myPlacemarkWithContent2)
        .add(myPlacemarkWithContent3);
});