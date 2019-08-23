<style>
    .hcc.hc__footer, .hc__menu__settings__popup div[rel=link]{
        display: none;
    }
    .hc__menu__settings__popup{
        height: 25px !important;
    }
</style>
<div class="comment-repond mt-3">
    <div id="hypercomments_widget"></div>
    <script type="text/javascript">
        _hcwp = window._hcwp || [];
        _hcwp.push({
            xid: '{{$post->id}}',
            widget:"Stream",
            widget_id: 99093,
            title: '{{$post->title}}',
            comment_length: 1000,
            social: "google, facebook, twitter, vk, odnoklassniki, mailru, yandex"
        });
        (function() {
            if("HC_LOAD_INIT" in window)return;
            HC_LOAD_INIT = true;
            var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
            var hcc = document.createElement("script");
            hcc.type = "text/javascript";
            hcc.async = true;
            hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/99093/"+lang+"/widget.js";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hcc, s.nextSibling);
        })();
    </script>
</div>