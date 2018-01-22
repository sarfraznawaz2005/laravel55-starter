<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

    <meta name="description" content="{{appName()}}">
    <meta name="author" content="Sarfraz Ahmed">
    <link rel="shortcut icon" href="/favicon.ico">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{title()}} :: {{appName()}}</title>

    {!! Packer::css([
    '/modules/crud/css/bootstrap/css/bootstrap.min.css',
    '/modules/crud/css/bootstrap/css/custom.css',
    '/modules/core/css/font-awesome-4/css/font-awesome.min.css',
    '/modules/core/css/checkbox3.min.css',
    '/modules/core/js/plugins/sweetalert/dist/sweetalert.css',
    '/modules/core/js/plugins/select2/select2.min.css',
    '/modules/core/css/loader.css',
    '/modules/crud/css/custom.css',
    ],
    '/storage/crud/cache/css/')
    !!}

    <link rel="stylesheet" href="/modules/core/css/animate.css">

    @stack('styles')

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>