{{--
@push('styles')
<link href="/js/plugins/datatables/buttons/css/buttons.dataTables.min.css" rel="stylesheet"/>
@endpush

@push('scripts')
{!! Packer::js([
'/js/plugins/datatables/buttons/js/dataTables.buttons.min.js',
'/js/plugins/datatables/buttons/js/buttons.bootstrap.min.js',
'/js/plugins/datatables/buttons/js/buttons.server-side.js',
],
'/storage/cache/js/')
!!}
@endpush
--}}

@push('scripts')
{!! $dataTable->scripts() !!}
@endpush