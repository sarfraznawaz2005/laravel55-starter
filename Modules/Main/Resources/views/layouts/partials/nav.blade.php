<header class="bg-primary text-white">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <strong><i class="fa fa-code"></i> {{appName()}}</strong>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{active(['/', 'home'])}}">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    @if(Module::isEnabled('Task'))
                        <li class="nav-item"><a class="nav-link" href="{{route('task.index')}}">Tasks</a></li>
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::check() && user()->isSuperAdmin())
                        @if(Module::isEnabled('Admin'))
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="{{route('admin_login')}}">
                                    <i class="fa fa-cog"></i> Admin Panel
                                </a>
                            </li>
                        @endif
                    @endif

                    @if (Auth::guest())
                        @if(Module::isEnabled('User'))
                            @if(config('user.allow_user_registration', true))
                                <li class="nav-item nav-item {{active('login')}}">
                                    <a class="nav-link" href="{{ url('/user/login') }}">
                                        <i class="fa fa-lock"></i> Sign In
                                    </a>
                                </li>

                                <li class="nav-item {{active('register')}}">
                                    <a class="nav-link" href="{{ url('/user/register') }}">
                                        <i class="fa fa-user"></i> Create Account
                                    </a>
                                </li>
                            @endif
                        @endif
                    @else
                        @if(Module::isEnabled('User'))
                            @if(config('user.allow_user_registration', true))
                                <li class="dropdown">
                                    <a class="nav-link" href="#" class="dropdown-toggle"
                                       data-toggle="dropdown"
                                       role="button"
                                       aria-expanded="false">
                                        {{ user()->full_name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('/user/logout') }}"
                                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                Sign Out
                                            </a>

                                            <form id="logout-form" action="{{ url('/user/logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>

            </div>
        </div>
    </nav>

    <div class="text-center page-title animated bounceInDown">
        <h1 class="display-4">{{Meta::get('title')}}</h1>
    </div>

</header>