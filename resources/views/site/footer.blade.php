<footer class="footer" id="contacts">
    {{-- Карта яндекс --}}
    <div class="row">
        <div class="col-xl-3">
            <div class="footer-address">
                Москва <br>м. Новослободская
            </div>
            <br>
            <div class="footer-address">
                м. Краснопресненская
            </div>
            <br>
            <div class="footer-address">
                м. Чистые пруды
            </div>
        </div>
        <div id="map-1" class="col-xl-8"></div>
    </div>
    <div class="row">
        <div class="col-xl-3 footer-img">
            <a href="#">
                <img src="{!! asset('images/bg/footer/footer_logo.png') !!}" alt="Upbrain">
            </a>
        </div>
        {{-- Нижнее меню --}}
        <div class="col-xl-6">
            <span>Учиться, чтобы стать успешным</span><br>
            <a href="#" title="Отличный преподаватель ЕГЭ, ОГЭ, ДВИ">Отличные преподаватели и репетиторы Upbrain.</a>
        </div>

{{--         <div class="footer-contact col-xl-3">
            <button data-toggle="modal" data-target="#contact-modal" class="btn">Заказать звонок</button>
            <ul class="list-inline mt-2 mb-0">
                <li class="list-inline-item">
                    <a href="https://www.facebook.com/upbrainschool/?ref=bookmarks"><i class="fab fa-facebook-square"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://vk.com/upbrainschool"><i class="fab fa-vk"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://www.youtube.com/channel/UCmppc52Koy0LjP1AOCzxokg"><i class="fab fa-youtube"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="https://telegram.me/upbrainschool"><i class="fab fa-telegram"></i></a>
                </li>
            </ul>
            +7(916)804-76-25 <br>+7(929)517-33-03<br>email@upbrain.ru
        </div> --}}
        <div class="col-xl-12">
            <a href="#" data-toggle="modal" data-target="#policy-modal">Политика кондефициальности</a>
        </div>
    </div>
</footer>
<div id="policy-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Политика конфиденциальности</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
            <small>Последнее обновление: 2022 г.</small>
                    <h2>Право на сохранение конфиденциальности</h2>
                    <p>Данная Политика конфиденциальности содержит описание ваших прав на сохранение конфиденциальности в
                        отношении сбора, использования, обработки ваших личных данных. Политика применима к веб-сайту upbrain.ru и
                        всем связанным с ним приложениям, услугам и инструментам.</p>
                    <p>Вы принимаете условия данной Политики конфиденциальности при оформлении заказа на нашем сайте upbrain.ru
                        (далее «веб-сайт»). Администрация веб-сайта может в любое время вносить поправки в данную Политику,
                        которые будут опубликованы на веб-сайте компании. Исправленная версия вступает в силу с момента ее
                        публикации на веб-сайте.</p>
                    <h2>Сбор информации о пользователях</h2>
                    <p>При посещении веб-сайта или использовании компания собирает информацию, отправляемую вашим
                        компьютером, мобильным телефоном или другим средством доступа.</p>
                    <p>Кроме того, при оформлении заказа мы можем собирать следующую информацию:</p>
                    <ul>
                        <li>Контактные данные, например, имя и фамилия, адрес, номер телефона, адрес электронной</li>
                        <li>Подробные личные данные, например, дату рождения или номер удостоверения личности.</li>
                    </ul>

                    <p>Настоящим вы предоставляете компании «UpBrain» свое согласие на обработку, полученных нами ваших
                        персональных данных.</p>

                    <h3>Использование полученных личных данных</h3>
                    <p>Основной целью сбора личных данных является обеспечение эффективного обслуживания. Ваши личные
                        данные могут использоваться в следующих целях:</p>
                    <ul>
                        <li>обеспечение оказания услуг компании «UpBrain» и технической поддержки клиентов;</li>
                        <li>обработка заказов и отправка уведомлений об операциях связанных с заказом;</li>
                        <li>разрешение споров и устранение проблем;</li>
                        <li>настройка, оценка и совершенствование услуг компании «UpBrain» и контента, структуры и работы вебсайта;</li>
                        <li>реализация целевого маркетинга, уведомления об обновлении услуг и рекламные предложения на
                            основе ваших настроек связи;</li>
                        <li>связь с вами по любому номеру телефона, при помощи голосового вызова либо посредством
                            текстового (SMS) или электронного сообщения в соответствии с условиями Соглашения с
                            пользователем;</li>
                    </ul>


                    <p>Обращение по вопросам, касающимся конфиденциальности данных пользователей.
                        При появлении вопросов относительно данной политики свяжитесь с нами.</p>
{{--                    Тел: +79168047625<br>--}}s
                    E-mail: email@upbrain.ru<br>
            </div>
            </div>
        </div>
</div>

    {!! Html::script('js/lp/jquery-3.2.1.min.js') !!}
    {!! Html::script('js/lp/ekko-lightbox.min.js') !!}
    {!! Html::script('js/lp/tether.min.js') !!}
    {!! Html::script('js/lp/bootstrap.js') !!}
    {!! Html::script('js/lp/jasny-bootstrap.min.js') !!}
    {!! Html::script('js/aglok/common.js') !!}
    {!! Html::script('js/aglok/lp.js') !!}
    {!! Html::script('//api-maps.yandex.ru/2.1/?lang=ru_RU') !!}
    {!! Html::script('js/aglok/yandex-map-custom.js') !!}


    <script>

        $(function(){

            let array_selectors = [
                '#form-bottom',
                '#form-top',
                '#form-email',
                '#who-is-form-1',
                '#who-is-form-2',
                '#who-is-form-3',
                '#who-is-form-4',
                '#who-is-form-5',
                '#who-is-form-6',
                '#form-modal',
                '#form-modal-junior',
                '#form-bottom-junior'
            ];
            let array_img_selectors = $('.gain-icon');

            $.initialiseFrom(array_selectors); //Инициализация модального окна
            $.initialiseImgHover(array_img_selectors); //Инициализация меняющегося изображения gif

            $('[data-toggle="tooltip"]').tooltip();//Инициализация tooltip
        });

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
    @stack('script')

