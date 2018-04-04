@extends('admin::layout')

@section('content')

    {!! $dataTable->table(['class' => 'table table-condensed table-bordered table-hover']) !!}

@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush
