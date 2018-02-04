@extends('main::layouts.master')

@section('content')
    <a href="{{route('task.index')}}" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Back to Tasks</a>
    <hr>

    @include('task::pages.task._form')

@endsection
