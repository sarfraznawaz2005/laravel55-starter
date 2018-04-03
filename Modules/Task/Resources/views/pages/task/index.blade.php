@extends('main::layouts.master')

@section('content')

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#list">Manage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#create">Create</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="list">
                    {!! $dataTable->table(['class' => 'table table-condensed table-bordered table-hover']) !!}
                </div>
                <div class="tab-pane" id="create">
                    @include('task::pages.task._form')
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush