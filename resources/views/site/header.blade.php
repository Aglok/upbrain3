 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
       if(!$title){
            $title = 'Upbrain.ru - курсы подготовки к ЕГЭ и ОГЭ, Школа мышления';
       }
       if(!$description){
            $description = 'Обучение с любовью. Глубокое понимание личности ребёнка, отражает всю суть подготовки Upbrain. Курсы подготовки к ЕГЭ и ОГЭ (ГИА), Школа мышления - Upbrain';
       }
       if(!$keywords){
            $keywords = 'курсы егэ, курсы егэ на Чистых прудах, курсы егэ по математике, курсы егэ по физике, курсы огэ, курсы огэ в Москве';
       }
       if(!$image){
           $image = asset('images/bg/header/img_header_prize.jpg');
       }
    @endphp
    <title>{{$title}}</title>
    <meta name="description" content="{{$description}}">
    <meta name="keywords" content="{{$keywords}}">

    <meta property="og:url" content="{{URL::current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$title}}" />
    <meta property="og:description" content="{{$description}}" />
    <meta property="og:image" content="{{asset($image)}}" />

    <meta name="twitter:author" content="@Aglok">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:src" content="{{asset($image)}}">
    <meta name="twitter:title" content="{{$title}}">
    <meta name="twitter:description" content="{{$description}}">

    <meta name="yandex-verification" content="f333b545dff8cea7" />

    {!! Html::style('css/lp/bootstrap.css') !!}
    {!! Html::style('css/lp/jasny-bootstrap.min.css') !!}
    {!! Html::style('css/aglok/lp_style.css') !!}
    {!! Html::style('css/lp/fontawesome-all.css') !!}
    {!! Html::style('css/lp/ekko-lightbox.css') !!}

    {{-- Вставляются дополнительные стили--}}
    @stack('style')

 <!-- Yandex.Metrika counter -->
 <script type="text/javascript" >
     (function (d, w, c) {
         (w[c] = w[c] || []).push(function() {
             try {
                 w.yaCounter45749043 = new Ya.Metrika2({
                     id:45749043,
                     clickmap:true,
                     trackLinks:true,
                     accurateTrackBounce:true,
                     webvisor:true,
                     ecommerce:"dataLayer"
                 });
             } catch(e) { }
         });

         var n = d.getElementsByTagName("script")[0],
             s = d.createElement("script"),
             f = function () { n.parentNode.insertBefore(s, n); };
         s.type = "text/javascript";
         s.async = true;
         s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js";

         if (w.opera == "[object Opera]") {
             d.addEventListener("DOMContentLoaded", f, false);
         } else { f(); }
     })(document, window, "yandex_metrika_callbacks2");
 </script>
 <noscript><div><img src="https://mc.yandex.ru/watch/45749043" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
 <!-- /Yandex.Metrika counter -->
     <!-- Пиксель vk counter -->
     <script type="text/javascript">(window.Image ? (new Image()) : document.createElement('img')).src = 'https://vk.com/rtrg?p=VK-RTRG-155857-cC42R';</script>
     <!-- /Пиксель vk counter -->