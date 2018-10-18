<div class="clearfix">&nbsp;</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">&copy; {{date('Y')}} <a href="/">{{appName()}}</a> - All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

{!! Packer::js([
'/modules/core/js/plugins/datatables/fnFilterOnReturn.js',
'/modules/core/js/plugins/datatables/jquery.dataTables.columnFilter.js',
'/modules/core/js/plugins/jquery.pulsate.min.js',
'/modules/core/js/plugins/disabler.min.js',
'/modules/core/js/core.js',
'/modules/main/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

@include('sweet::alert')
@include('noty::view')

@if (config('core.settings.enable_socket'))
    @include('core::shared.socket')
@endif
