<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar animated bounceInLeft">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item {{active('admin_panel')}}" href="{{route('admin_panel')}}">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item {{active('admin_user_listing')}}" href="{{route('admin_user_listing')}}">
                <i class="app-menu__icon fa fa-pencil"></i>
                <span class="app-menu__label">Users</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="#">
                <i class="app-menu__icon fa fa-pencil"></i>
                <span class="app-menu__label">Another Link</span>
            </a>
        </li>

        <li class="treeview {{active('admin_panel', 'is-expanded')}}">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-laptop"></i>
                <span class="app-menu__label">Sub Level</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="#">Link 1</a></li>
                <li><a class="treeview-item" href="#">Link 2</a></li>
                <li><a class="treeview-item {{active('admin_panel')}}" href="#">Link 3</a></li>
            </ul>
        </li>

    </ul>
</aside>