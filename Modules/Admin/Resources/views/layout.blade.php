<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('admin::partials.head')
<body class="animated fadeIn">
@include('admin::partials.nav')

<div class="container-fluid main-container">
    @include('admin::partials.sidebar')

    <div class="col-md-10 content">

        @section('backend_main_panel.component_panel_body_before')
            @if (config('admin.breadcrumb'))
                {!! Breadcrumbs::render() !!}
            @endif
        @endsection

        @section('backend_main_panel.component_panel_content')
            @include('flash::message')
            @include('core::shared.errors')
            @include('core::shared.loader')

            @yield('content')
        @endsection

        @include('core::components.panel', [
            'id' => 'backend_main_panel',
            'panel_heading' => '<b class="fa fa-th-large"></b> ' . Meta::get('title'),
            'show_panel_footer' => false
        ])
    </div>

    @include('admin::partials.footer')
</div>

</body>
</html>
