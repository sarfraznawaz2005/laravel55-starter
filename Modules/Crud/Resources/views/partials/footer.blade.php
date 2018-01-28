<div class="clearfix">&nbsp;</div>

{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/core/css/bootstrap/popper.min.js',
'/modules/crud/css/bootstrap/css/bootstrap3.min.js',
'/modules/core/js/plugins/select2/select2.full.min.js',
'/modules/core/js/plugins/sweetalert.min.js',
'/modules/crud/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

</body>
</html>