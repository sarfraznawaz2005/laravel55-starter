<div class="col-md-2 sidebar">
    <div class="row">
        <!-- uncomment code for absolute positioning tweek see top comment in css -->
        <div class="absolute-wrapper"></div>
        <!-- Menu -->
        <div class="side-menu">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Main Menu -->
                <div class="side-menu-container">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a>
                        </li>
                        <li><a href="#"><span class="glyphicon glyphicon-plane"></span> Active Link</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-cloud"></span> Link</a></li>

                        <!-- Dropdown-->
                        <li class="panel panel-default" id="dropdown">
                            <a data-toggle="collapse" href="#dropdown-lvl1">
                                <span class="glyphicon glyphicon-user"></span> Sub Level <span class="caret"></span>
                            </a>

                            <!-- Dropdown level 1 -->
                            <div id="dropdown-lvl1" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul class="nav navbar-nav">
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li><a href="#"><span class="glyphicon glyphicon-signal"></span> Link</a></li>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>

        </div>
    </div>
</div>