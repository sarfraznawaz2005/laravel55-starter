@extends('main::layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            @section('mycard.component_card_content')
                {!! Former::open()->action(route('password.email'))->method('post')->class('validate') !!}

                {!!
                    Former::email('email', 'E-Mail Address')
                    ->required()
                    ->label('')
                    ->placeholder('E-Mail Address')
                    ->autocomplete('off')
                !!}

                @include ('core::shared.submit', ['title' => '<span class="fa fa-paper-plane"></span> Reset Password', 'btnClass' => 'btn btn-block btn-success btn-raised'])

                {!! Former::close() !!}
            @endsection

            @section('mycard.component_card_footer')
                    <div class="text-center">
                        <i class="fa fa-info-circle"></i> Already have an account?
                        <a href="{{ route('login') }}">Sign In</a>
                    </div>
            @endsection

            @include('core::components.card', [
                'id' => 'mycard',
                'card_heading' => '<i class="fa fa-lock"></i> Reset Password',
                'card_type' => '',
                'card_heading_type' => '',
                'card_heading_color' => '',
                'show_card_footer' => true,
            ])

        </div>
    </div>
</div>
@endsection
