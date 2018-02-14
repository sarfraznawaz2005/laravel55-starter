<header class="app-header">
    <a class="app-header__logo" href="{{route('admin_panel')}}">{{appName()}}</a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar"></a>

    <!-- Navbar Left -->
    {{-- many links create problem on smaller screen so haivng just Quick Links here --}}
    <a class="app-nav__item dropdown-toggle" id="dropdownNav"
       data-toggle="dropdown"
       aria-haspopup="true"
       href="#"
       aria-expanded="false">
        Access
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownNav">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>

    <!-- Navbar Right Menu-->
    <ul class="app-nav">

        <li class="app-search">
            <input class="app-search__input" type="search" placeholder="Search">
            <button class="app-search__button"><i class="fa fa-search"></i></button>
        </li>

        <!--Notification Menu-->
        <li class="dropdown">
            <a class="app-nav__item dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fa fa-bell-o fa-lg"></i>
            </a>

            <ul class="app-notification dropdown-menu dropdown-menu-right">
                <li class="app-notification__title">You have 4 new notifications</li>

                <div class="app-notification__content">

                    <li>
                        <a class="app-notification__item" href="javascript:;">
                            <span class="app-notification__icon">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                    <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                </span>
                            </span>
                            <div>
                                <p class="app-notification__message">Lisa sent you a mail</p>
                                <p class="app-notification__meta">2 min ago</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a class="app-notification__item" href="javascript:;">
                            <span class="app-notification__icon">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                    <i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>
                                </span>
                            </span>
                            <div>
                                <p class="app-notification__message">Mail server not working</p>
                                <p class="app-notification__meta">5 min ago</p>
                            </div>
                        </a>
                    </li>

                    <li>
                        <a class="app-notification__item" href="javascript:;">
                            <span class="app-notification__icon">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-success"></i>
                                    <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                                </span>
                            </span>
                            <div>
                                <p class="app-notification__message">Transaction complete</p>
                                <p class="app-notification__meta">2 days ago</p>
                            </div>
                        </a>
                    </li>

                    <div class="app-notification__content">
                        <li>
                            <a class="app-notification__item" href="javascript:;">
                                <span class="app-notification__icon">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </span>
                                <div>
                                    <p class="app-notification__message">Lisa sent you a mail</p>
                                    <p class="app-notification__meta">2 min ago</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a class="app-notification__item" href="javascript:;">
                                <span class="app-notification__icon">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                        <i class="fa fa-hdd-o fa-stack-1x fa-inverse"></i>
                                    </span>
                                </span>
                                <div>
                                    <p class="app-notification__message">Mail server not working</p>
                                    <p class="app-notification__meta">5 min ago</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a class="app-notification__item" href="javascript:;">
                                <span class="app-notification__icon">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                                        <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                                    </span>
                                </span>
                                <div>
                                    <p class="app-notification__message">Transaction complete</p>
                                    <p class="app-notification__meta">2 days ago</p>
                                </div>
                            </a>
                        </li>

                    </div>
                </div>

                <li class="app-notification__footer"><a href="#">See all notifications</a></li>
            </ul>
        </li>

        <!-- User Menu-->
        <li class="dropdown">
            <a class="app-nav__item dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-lg"></i>
            </a>

            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li class="app-notification__title">{{user()->full_name}}</li>

                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-cog fa-lg"></i> Settings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-user fa-lg"></i> Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{route('admin_logout')}}">
                        <i class="fa fa-sign-out fa-lg"></i> Logout
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a class="app-nav__item"
               href="/"
               data-placement="top"
               data-tooltip
               data-original-title="Visite Site"
               target="_blank">
                <i class="fa fa-globe fa-lg"></i>
            </a>
        </li>

    </ul>
</header>