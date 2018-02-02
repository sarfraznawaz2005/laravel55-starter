<footer class="pull-left footer">
    <hr class="divider">
    &copy; {{date('Y')}} <a href="/">{{appName()}}</a> - All rights reserved.
</footer>

<!-- Scripts -->
{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/admin/css/bootstrap/js/bootstrap.min.js',
'/modules/core/js/plugins/datatables/jquery.dataTables.min.js',
'/modules/core/js/plugins/datatables/datatables.bootstrap.js',
'/modules/core/js/plugins/datatables/fnFilterOnReturn.js',
'/modules/core/js/plugins/datatables/responsive/dataTables.responsive.min.js',
'/modules/core/js/plugins/isMobile.min.js',
'/modules/core/js/plugins/jquery.pulsate.min.js',
'/modules/core/js/plugins/sweetalert.min.js',
'/modules/core/js/plugins/select2/select2.full.min.js',
'/modules/core/js/plugins/bootstrap-filestyle.min.js',
'/modules/core/js/plugins/summernote/summernote.min.js',
'/modules/core/js/plugins/disabler.min.js',
'/modules/core/js/plugins/validator.min.js',
'/modules/core/js/core.js',
'/modules/admin/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

@include('sweet::alert')