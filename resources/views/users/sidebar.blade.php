<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="treeview">
                <a href="#"><i class="fa fa-dashboard fa-fw"></i><span>Главная</span></a>
            </li>
            <li>
                <a href="{{URL::to('home/users_rating/math')}}"><i class="fa fa-bar-chart-o fa-fw"></i><span>Рейтинг М</span></a>
            </li>
            <li>
                <a href="{{URL::to('home/users_rating/physics')}}"><i class="fa fa-bar-chart-o fa-fw"></i><span>Рейтинг Ф</span></a>
            </li>
            <li class="treeview">
                <a href="{{URL::route('game_duel')}}"><span>Поиграем!</span></a>
            {{--@if((int)Auth::id() == $user_id)--}}
            </li>

            @if( Auth::check())
            <li class="treeview">
                <a href="#"><i class="fa fa-fw"></i> <span>Задачи</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#"><i class="fa"></i><span>Д/з</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa"></i><span>Решённые</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa"></i><span>Не решённые</span></a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>
    </section>
</aside>