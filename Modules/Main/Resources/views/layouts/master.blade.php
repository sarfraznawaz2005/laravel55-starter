<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('main::layouts.partials.head')

<body class="animated fadeIn">
@include('main::layouts.partials.nav')

<main role="main" class="container main">
    <div class="row">
        <div class="col-md-12">
            @section('main_frontend_panel.component_panel_body_before')
                @if (config('main.breadcrumb'))
                    {!! Breadcrumbs::render() !!}
                @endif
            @endsection

            @section('main_frontend_panel.component_panel_content')
                @include('flash::message')
                @include('core::shared.errors')
                @include('core::shared.loader')

                @yield('content')
            @endsection

            @include('core::components.panel', [
                'id' => 'main_frontend_panel',
                'panel_heading' => '<h1><i class="fa fa-th-large"></i> '.Meta::get('title').'</h1>',
                'show_panel_footer' => false
            ])
        </div>
    </div>
</main>

@include('main::layouts.partials.footer')

</body>
</html>
