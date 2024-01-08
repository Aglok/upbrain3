{{-- Боковая панель --}}
<div id="site-header-wrapper">
    <div class="menu-overlay"></div>
    <header id="site-header" class="site-header mobile-menu-layout-overlay">
        <button class="vertical-toggle">Primary Menu
            <span class="menu-line-1"></span>
            <span class="menu-line-2"></span>
            <span class="menu-line-3"></span>
        </button>
        <div class="container">
            <div class="header-main logo-position-left header-layout-vertical header-style-vertical">

                {{--Лого и заголовок боковой панели--}}
                <div class="site-title">
                    <div class="site-logo" style="width:164px;">
                        <a href="#" rel="home">
                            <span class="logo">
                                <img src="{{asset('images/bg/header/header_logo.png')}}" srcset="{{asset('images/bg/header/header_logo.png')}}" alt="Upbrain" style="width:164px;" class="default">
                                <img src="{{asset('images/bg/header/header_logo.png')}}" srcset="{{asset('images/bg/header/header_logo.png')}}" alt="Upbrain" style="width:132px;" class="small">
                            </span>
                        </a>
                    </div>
                </div>

                {{--Бокового меню--}}
                <nav id="primary-navigation" class="site-navigation primary-navigation responsive" role="navigation">
                    <button class="menu-toggle dl-trigger">Primary Menu
                        <span class="menu-line-1"></span>
                        <span class="menu-line-2"></span>
                        <span class="menu-line-3"></span>
                    </button>
                    <div class="overlay-menu-wrapper">
                        <div class="overlay-menu-table">
                            <div class="overlay-menu-row">
                                <div class="overlay-menu-cell">
                                    <ul id="primary-menu" class="nav-menu styled no-responsive">
                                        <li class=""><a href="#">Главная</a></li>
                                        <li><a href="#">Курсы</a></li>
                                        <li><a href="#">Контакты</a></li>
                                        <li><a href="#">Обратная связь</a></li>
                                        <li><a href="#">Комментарии</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

            </div>
        </div>
    </header>

    {{-- Виджеты поиск и соц. сети--}}
    <div class="vertical-menu-item-widgets">
        {{-- Поиск --}}
        <div class="vertical-minisearch">
            <form role="search" id="searchform" class="sf" action="#" method="GET">
                <input id="searchform-input" class="sf-input" placeholder="Интересное" name="s">
                <span class="sf-submit-icon"></span>
                <input id="searchform-submit" class="sf-submit" type="submit" value="">
            </form>
        </div>
        {{-- Ссылки на соц. сети --}}
        @include('blog.social')
    </div>
</div>