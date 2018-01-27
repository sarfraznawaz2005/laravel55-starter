<div class="clearfix">&nbsp;</div>
<footer class="footer">
    <div class="container">
        <p class="text-muted">&copy; {{date('Y')}} <a href="/">{{appName()}}</a> - All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/core/css/bootstrap/bootstrap.min.js',
'/modules/core/js/plugins/datatables/jquery.dataTables.min.js',
'/modules/core/js/plugins/datatables/datatables.bootstrap.js',
'/modules/core/js/plugins/datatables/fnFilterOnReturn.js',
'/modules/core/js/plugins/datatables/responsive/dataTables.responsive.min.js',
'/modules/core/js/plugins/isMobile.min.js',
'/modules/core/js/plugins/jquery.pulsate.min.js',
'/modules/core/js/plugins/sweetalert/dist/sweetalert.min.js',
'/modules/core/js/plugins/select2/select2.full.min.js',
'/modules/core/js/plugins/bootstrap-filestyle.min.js',
'/modules/core/js/plugins/summernote/summernote.min.js',
'/modules/core/js/plugins/disabler.min.js',
'/modules/core/js/plugins/validator.min.js',
'/modules/core/js/plugins/notify.min.js',
'/modules/core/js/plugins/fastpage.jquery.js',
'/modules/core/js/core.js',
'/modules/main/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

@include('sweet::alert')