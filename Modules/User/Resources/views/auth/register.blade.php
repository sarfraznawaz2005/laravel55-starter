@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @section('mycard.component_card_content')
                    {!! Former::open()->action(route('register'))->method('post')->class('validate') !!}

                    {!!
                         Former::text('name')
                         ->required()
                         ->label('')
                         ->placeholder('Name')
                     !!}

                    {!!
                        Former::email('email', 'E-Mail Address')
                        ->required()
                        ->label('')
                        ->placeholder('E-Mail Address')
                        ->autocomplete('off')
                    !!}

                    {!!
                        Former::password('password', 'Password')
                        ->required()
                        ->label('')
                        ->placeholder('Password')
                        ->autocomplete('off')
                    !!}

                    {!!
                         Former::password('password_confirmation', 'Confirm Password')
                         ->required()
                         ->label('')
                         ->placeholder('Confirm Password')
                         ->autocomplete('off')
                     !!}

                    {!!
                    Former::actions(Former::primary_button('<span class="fa fa-paper-plane"></span> Sign Up')
                    ->type('submit')
                    ->class('btn btn-block btn-success btn-raised'))
                    !!}

                    {!! Former::close() !!}
                @endsection

                @section('mycard.component_card_footer')
                    <div class="text-center">
                        <i class="fa fa-info-circle"></i> Already have an account?
                        <a href="{{ route('login') }}" class="text-blue">Sign In</a>
                    </div>
                @endsection

                @include('core::components.card', [
                    'id' => 'mycard',
                    'card_heading' => '<i class="fa fa-user"></i> Account Details',
                    'card_type' => '',
                    'card_heading_type' => '',
                    'card_heading_color' => '',
                    'show_card_footer' => true,
                ])

            </div>
        </div>
    </div>
@endsection
