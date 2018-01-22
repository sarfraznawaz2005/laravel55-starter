@extends('frontend::layout')

@section('content')
    <div class="tab-content">
        <div id="manage" class="tab-pane fade in active">
            {!! $dataTable->table(['class' => 'table table-condensed table-striped table-bordered table-hover dt-responsive nowrap'], true) !!}
        </div>
    </div>
@endsection

@include('core::shared.datatables_export')