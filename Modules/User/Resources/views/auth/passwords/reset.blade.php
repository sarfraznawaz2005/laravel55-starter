@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @section('mycard.component_card_content')
                    {!! Former::open()->action(route('password.request'))->method('post')->class('validate') !!}
                    {!! Former::hidden('token')->value($token) !!}

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
                    Former::actions(Former::primary_button('<span class="fa fa-paper-plane"></span> Reset Password')
                    ->type('submit')
                    ->class('btn btn-block btn-success btn-raised'))
                    !!}

                    {!! Former::close() !!}
                @endsection

                @include('core::components.card', [
                    'id' => 'mycard',
                    'card_heading' => '<i class="fa fa-lock"></i> Reset Password',
                    'card_type' => '',
                    'card_heading_type' => '',
                    'card_heading_color' => '',
                    'show_card_footer' => false,
                ])

            </div>
        </div>
    </div>
@endsection
