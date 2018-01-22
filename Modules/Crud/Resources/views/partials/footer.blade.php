<div class="clearfix">&nbsp;</div>

<!-- Scripts -->
{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/core/css/bootstrap/js/bootstrap.min.js',
'/modules/core/js/plugins/select2/select2.full.min.js',
'/modules/core/js/plugins/sweetalert/dist/sweetalert.min.js',
'/modules/crud/js/custom.js',
],
'/storage/crud/cache/js/')
!!}

@stack('scripts')

</body>
</html>