<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta name="author" content="Sarfraz Ahmed">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! Meta::tag('robots') !!}

    {!! Meta::tag('title') !!}
    {!! Meta::tag('description') !!}
    {!! Meta::tag('site_name', appName()) !!}
    {!! Meta::tag('url', Request::url()); !!}
    {!! Meta::tag('locale', 'en_EN') !!}

    <link rel="shortcut icon" href="/favicon.ico">

    {!! Packer::css([
    '/modules/crud/css/bootstrap/css/theme.min.css',
    '/modules/crud/css/bootstrap/css/custom.css',
    '/modules/core/js/plugins/sweetalert/dist/sweetalert.css',
    '/modules/core/js/plugins/select2/select2.min.css',
    '/modules/core/css/loader.css',
    '/modules/crud/css/custom.css',
    '/modules/core/css/animate.css',
    ],
    '/storage/cache/css/')
    !!}

    @stack('styles')

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>