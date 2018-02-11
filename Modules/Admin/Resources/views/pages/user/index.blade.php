@extends('admin::layout')

@section('content')

    {!! $dataTable->table(['class' => 'table table-condensed table-bordered table-hover nowrap']) !!}

@endsection

@include('core::shared.datatables_export')