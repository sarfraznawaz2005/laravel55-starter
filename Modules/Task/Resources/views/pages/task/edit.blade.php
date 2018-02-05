@extends('main::layouts.master')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="pull-left">
                <a href="{{route('task.index')}}" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i> Back to Tasks
                </a>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="card-body">
            @include('task::pages.task._form')
        </div>
    </div>

@endsection
