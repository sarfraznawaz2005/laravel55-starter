<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Sarfraz Ahmed (sarfraznawaz2005@gmail.com)">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/favicon.ico">

    <title>{{Meta::get('title') . ' :: Admin Panel'}}</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    {!! Packer::css([
    '/modules/admin/css/main.css',
    '/modules/core/css/loader.css',
    '/modules/admin/css/custom.css',
    ],
    '/storage/cache/css/')
    !!}

    @stack('styles')

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>
