<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta name="description" content="{{appName()}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Sarfraz Ahmed (sarfraznawaz2005@gmail.com)">

    <link rel="shortcut icon" href="/favicon.ico">

    <title>{{appName()}}</title>

    {!! Packer::css([
    '/modules/admin/css/bootstrap/css/bootstrap.min.css',
    '/modules/admin/css/custom.css',
    '/modules/core/css/animate.css',
    ],
    '/storage/cache/css/')
    !!}

    <style>
        .panel {
            margin-top: 100px;
        }

        .panel {
            box-shadow: 0 0 10px #000000;
        }
    </style>

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>

<body class="animated fadeIn">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">

            @section('backend_login_page.component_panel_content')
                @include('core::shared.errors')

                {!! Former::open()->action(url('/admin/login'))->method('post')->class('validate') !!}

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
                Former::actions(Former::primary_button('<span class="glyphicon glyphicon-log-in"></span> Sign In')
                ->type('submit')
                ->class('btn btn-block btn-success'))
                !!}

                {!! Former::close() !!}
            @endsection

            @include('core::components.panel', [
                'id' => 'backend_login_page',
                'panel_type' => $errors->any() ? 'danger' : 'primary',
                'panel_heading' => '<i class="glyphicon glyphicon-lock"></i> Account Details',
                'show_panel_footer' => false,
            ])

        </div>
    </div>
</div>

{!! Packer::js([
'/modules/core/js/jquery.js',
'/modules/admin/css/bootstrap/js/bootstrap.min.js',
],
'/storage/cache/js/')
!!}

</body>
</html>
