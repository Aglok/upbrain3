<html>
<head>
    {{Html::style('css/aglok/lp_style.css')}}
    {{Html::style('css/lp/bootstrap.css')}}
    <style>
        body{
            background: #e9eff7;
        }
        .block-text{
            position: absolute;
            top: 154px;
            left: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="font-regular" style="height: 102px">
            <div class="block-text">
                <h2><b>404</b>. Вы находитесь за гранью реальности <b>Upbrain</b>, помечтайте чутоку и опять возвращайтесь в обитель.</h2>
                <a href="/" title="Upbrain - образование">Вернуться на главную</a><br>
                <a href="blog" title="Upbrain - образование">Посмотреть статьи</a><br>
                <a href="compare" title="Upbrain - образование">Куда вы попали?</a>
            </div>
        </div>
        <img class="img-fluid" src="{{asset('images/bg/dragon/sad_dragon.gif')}}" width="512" alt="Дракон Upbrain - символ мудрости">
    </div>
</div>
</body>
</html>
