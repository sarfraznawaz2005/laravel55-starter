<div class="clearfix">&nbsp;</div>

{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/crud/css/bootstrap/css/bootstrap3.min.js',
'/modules/crud/js/custom.js',
],
'/storage/cache/js/')
!!}

@stack('scripts')

</body>
</html>