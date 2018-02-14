@extends('admin::layout')

@section('content')

    <div class="row">

        <div class="col-md-3">
            <a href="{{route('admin_user_listing')}}" class="widget-link">
                <div class="widget-small primary"><i class="icon fa fa-users fa-3x"></i>
                    <div class="info">
                        <h4>Users</h4>
                        <p><b>5</b></p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="#" class="widget-link">
                <div class="widget-small success"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
                    <div class="info">
                        <h4>Likes</h4>
                        <p><b>25</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="widget-link">
                <div class="widget-small warning"><i class="icon fa fa-files-o fa-3x"></i>
                    <div class="info">
                        <h4>Uploades</h4>
                        <p><b>10</b></p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="#" class="widget-link">
                <div class="widget-small danger"><i class="icon fa fa-star fa-3x"></i>
                    <div class="info">
                        <h4>Stars</h4>
                        <p><b>500</b></p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Animated Checkbox and Radio Buttons</h3>
                <!--Radio Button Markup-->
                <div class="animated-radio-button">
                    <label>
                        <input type="radio"><span class="label-text">Radio Button</span>
                    </label>
                </div>
                <!--Checkbox Markup-->
                <div class="animated-checkbox">
                    <label>
                        <input type="checkbox"><span class="label-text">Checkbox</span>
                    </label>
                </div>
                <h4>Disabled state</h4>
                <div class="animated-radio-button">
                    <label>
                        <input type="radio" disabled=""><span class="label-text">Radio Button</span>
                    </label>
                </div>
                <div class="animated-checkbox">
                    <label>
                        <input type="checkbox" disabled=""><span class="label-text">Checkbox</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Animated Toggle Button</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Toggle Button</b></p>
                        <div class="toggle">
                            <label>
                                <input type="checkbox"><span class="button-indecator"></span>
                            </label>
                        </div>
                        <div class="toggle lg">
                            <label>
                                <input type="checkbox"><span class="button-indecator"></span>
                            </label>
                        </div>
                        <h5>Disabled state</h5>
                        <div class="toggle">
                            <label>
                                <input type="checkbox" disabled=""><span class="button-indecator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p><b>Fliping Toggle Button</b></p>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox"><span class="flip-indecator" data-toggle-on="ON"
                                                             data-toggle-off="OFF"></span>
                            </label>
                        </div>
                        <h5>Disabled state</h5>
                        <div class="toggle-flip">
                            <label>
                                <input type="checkbox" disabled=""><span class="flip-indecator" data-toggle-on="ON"
                                                                         data-toggle-off="OFF"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
