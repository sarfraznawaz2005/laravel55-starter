@extends('main::layouts.master')

@section('content')
    <div class="jumbotron text-center">
        <h1 class="display-4">{{appName()}}</h1>

        <p class="lead">
            Welcome to Laravel Starter!
        </p>

        <p>
            @if (Auth::guest())
                <a class="btn btn-lg btn-success btn-raised" href="{{ url('/user/register') }}" role="button">
                    <i class="fa fa-paper-plane"></i> Get Started Now
                </a>
            @endif
        </p>
    </div>
@stop
