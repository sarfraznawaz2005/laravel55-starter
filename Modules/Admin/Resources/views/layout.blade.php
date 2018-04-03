<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('admin::partials.head')
<body class="app sidebar-mini animated fadeIn">
@include('admin::partials.nav')
@include('admin::partials.sidebar')

<main class="app-content" id="app">

    @section('card_admin.component_card_before')
        @if (config('admin.breadcrumb'))
            {!! Breadcrumbs::render() !!}
        @endif
    @endsection

    @section('card_admin.component_card_content')
        @include('flash::message')
        @include('core::shared.errors')
        @include('core::shared.loader')

        @yield('content')
    @endsection

    @include('core::components.card', [
        'id' => 'card_admin',
        'card_heading' => '<span class="page-title"><b class="fa fa-th-large"></b> ' . Meta::get('title') . '</span>',
        'card_type' => 'white',
        'card_heading_type' => 'white',
    ])

</main>

@include('admin::partials.footer')

</body>
</html>