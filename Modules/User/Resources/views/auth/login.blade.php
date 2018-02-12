@extends('main::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                @section('mycard.component_card_content')
                    {!! Former::open()->action(route('login'))->method('post')->class('validate') !!}

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

                    @if(config('user.remember_me_checkbox', true))
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Stay Signed In
                                </label>
                            </div>
                        </div>
                    @endif

                    {!!
                    Former::actions(Former::primary_button('<span class="fa fa-sign-in"></span> Sign In')
                    ->type('submit')
                    ->class('btn btn-block btn-success btn-raised'))
                    !!}

                    {!! Former::close() !!}
                @endsection

                @section('mycard.component_card_footer')
                    <div class="pull-left">
                        <a href="{{ route('password.request') }}" class="text-blue">
                            Forgot Password
                        </a>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('register') }}" class="text-blue">
                            Create Account
                        </a>
                    </div>
                    <div class="clearfix"></div>
                @endsection

                @include('core::components.card', [
                    'id' => 'mycard',
                    'card_heading' => '<i class="fa fa-lock"></i> Account Details',
                    'card_type' => '',
                    'card_heading_type' => '',
                    'card_heading_color' => '',
                    'show_card_footer' => true,
                ])

            </div>
        </div>
    </div>
@endsection
