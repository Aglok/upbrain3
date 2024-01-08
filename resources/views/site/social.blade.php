<script>
    {{-- vk создание скрипта до подгрузки стриницы --}}
    var js = document.createElement("script");
    //console.log(d.getElementsByTagName('head')[0]);
    js.src = "https://vk.com/js/api/share.js?95";
    js.charset = "windows-1251";
    document.getElementsByTagName('head')[0].appendChild(js);


    window.onload = function () {
        {{-- vk кнопка Поделиться --}}
        (function(d) {
            var vk = document.getElementById('vk_shareWidget');
            vk.innerHTML = VK.Share.button(false,{type: "round_nocount", text: "Поделиться"});
        }(document));
        {{-- /vk кнопка Поделиться --}}

        {{-- fb кнопка Поделиться --}}

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.11&appId=1136015756413391';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        {{-- /fb кнопка Поделиться --}}

        {{-- ok кнопка Поделиться --}}
            !function (d, id, did, st, title, description, image) {
                var js = d.createElement("script");
                js.src = "https://connect.ok.ru/connect.js";
                js.onload = js.onreadystatechange = function () {
                if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                    if (!this.executed) {
                        this.executed = true;
                        setTimeout(function () {
                            OK.CONNECT.insertShareWidget(id,did,st, title, description, image);
                        }, 0);
                    }
                }};
                d.documentElement.appendChild(js);
        }(document,"ok_shareWidget",document.URL,'{"sz":20,"st":"oval","nc":1,"ck":2}',"","","");
        {{-- /ok кнопка Поделиться --}}
    };
</script>
<div class="social-buttons">
    <div class="share-button vk-share-button">
        <div id="vk_shareWidget"></div>
    </div>
    <div id="fb-root"></div>
    <div class="fb-share-button"
         data-href="{{URL::current()}}"
         data-layout="button"
         data-size="small"
         data-mobile-iframe="true">
        <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}&src=sdkpreparse">Поделиться</a></div>
    <div class="share-button ok-share-button">
        <div id="ok_shareWidget"></div>
    </div>
</div>