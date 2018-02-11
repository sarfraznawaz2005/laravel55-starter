@if (isset($buttons) && $buttons)
    @push('styles')
        <link href="/modules/core/js/plugins/datatables/buttons/css/buttons.dataTables.min.css" rel="stylesheet"/>
    @endpush

    @push('scripts')
        {!! Packer::js([
        '/modules/core/js/plugins/datatables/buttons/js/dataTables.buttons.min.js',
        '/modules/core/js/plugins/datatables/buttons/js/buttons.server-side.js',
        ],
        '/storage/cache/js/')
        !!}
    @endpush
@endif

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush