@extends('admin::layout')

@section('content')

    {!! $dataTable->table(['class' => 'table table-condensed table-bordered table-hover']) !!}

@endsection

@include('core::shared.datatables_export')