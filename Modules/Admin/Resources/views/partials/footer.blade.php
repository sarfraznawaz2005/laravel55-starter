<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

{!! Packer::js([
'/modules/core/js/plugins/datatables/fnFilterOnReturn.js',
'/modules/core/js/plugins/datatables/jquery.dataTables.columnFilter.js',
'/modules/core/js/plugins/jquery.pulsate.min.js',
'/modules/core/js/plugins/disabler.min.js',
'/modules/core/js/core.js',
'/modules/admin/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

@include('sweet::alert')

@if (config('core.settings.enable_socket'))
    @include('core::shared.socket')
@endif

