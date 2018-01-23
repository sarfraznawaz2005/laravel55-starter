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

    <link rel="stylesheet" href="/modules/crud/css/bootstrap/css/theme.min.css">
    <link rel="stylesheet" href="/modules/crud/css/bootstrap/css/custom.css">
    <link rel="stylesheet" href="/modules/core/js/plugins/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" href="/modules/core/js/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="/modules/core/css/loader.css">
    <link rel="stylesheet" href="/modules/crud/css/custom.css">
    <link rel="stylesheet" href="/modules/core/css/animate.css">

    @stack('styles')

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>