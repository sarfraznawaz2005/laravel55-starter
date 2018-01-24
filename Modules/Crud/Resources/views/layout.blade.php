@include('crud::partials/head')

<body class="animated fadeIn">

<div class="container" style="margin-top: 20px; padding: 0;">
    <div class="row">
        <div class="col-md-12">

            @section('main_crud_panel.component_panel_content')
                @include('core::shared.loader')
                @include('flash::message')
                @include('core::shared.errors')

                @yield('content')
            @endsection

            @include('core::components.panel', [
                'id' => 'main_crud_panel',
                'panel_type' => 'primary',
                'panel_heading' => '<h1><i class="fa fa-th-large"></i> '.title().'</h1>',
                'show_panel_footer' => false,
            ])
        </div>
    </div>
</div>

@include('crud::partials/footer')
