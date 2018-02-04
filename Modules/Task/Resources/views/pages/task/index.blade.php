@extends('main::layouts.master')

@section('content')

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#list">Manage</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#create">Create</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="list">
            {!! $dataTable->table(['class' => 'table table-condensed table-bordered table-hover nowrap table-sm']) !!}
        </div>
        <div class="tab-pane" id="create">
            @include('task::pages.task._form')
        </div>
    </div>

@endsection

@include('core::shared.datatables_export')