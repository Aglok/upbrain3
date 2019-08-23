{{--Messenger меню для чата--}}
{{--<ul class="nav navbar-nav">--}}
    {{--<li><a href="{{ url('/') }}">Home</a></li>--}}
    {{--<li><a href="{{ route('messages') }}">Messages @include('chat.unread-count')</a></li>--}}
    {{--<li><a href="{{ route('messages.create') }}">+New Message</a></li>--}}
{{--</ul>--}}

<header class="main-header">
    <a href="#" class="logo">
        <span class="logo-lg"><span class="pull-left">Upbrain</span></span>
        <span class="logo-mini"></span>
    </a>
    <nav role="navigation" class="navbar navbar-static-top">
        <a href="#" data-toggle="push-menu" role="button" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span></a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav navbar-right">
                @include('admin.widgets.notifications', ['user' => Auth::user()])
                @include('admin.widgets.avatar', ['user' => Auth::user()])
            </ul>
        </div>
    </nav>
</header>