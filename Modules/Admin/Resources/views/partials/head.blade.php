<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, shrink-to-fit=no">
    <meta name="author" content="Sarfraz Ahmed (sarfraznawaz2005@gmail.com)">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/favicon.ico">

    <title>{{Meta::get('title') . ' :: Admin Panel'}}</title>

    {!! Packer::css([
    '/modules/admin/css/main.css',
    '/modules/core/js/plugins/datatables/datatables.bootstrap.css',
    '/modules/core/js/plugins/datatables/responsive/responsive.dataTables.min.css',
    '/modules/core/js/plugins/select2/select2.min.css',
    '/modules/core/js/plugins/summernote/summernote.css',
    '/modules/core/js/plugins/toast/jquery.toast.min.css',
    '/modules/admin/css/custom.css',
    '/modules/core/css/loader.css',
    '/modules/core/css/animate.css',
    ],
    '/storage/cache/css/')
    !!}

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    @stack('styles')

    <script>
        window.Laravel = <?=json_encode(['csrfToken' => csrf_token()]); ?>
    </script>
</head>
