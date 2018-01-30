<!DOCTYPE html>
<html>
<head>
    <title>404</title>

    <style>
        html, body {
            height: 100%;
            color: #636b6f;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 1000%;
            margin-bottom: -40px;
        }

        a {
            color: #636b6f;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #2d6ca2;
        }

        .text {
            font-size: 36px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">404</div>
        <p class="text">Sorry, but this page doesn't exists!</p>
        <p><a href="/">&larr; Back To Home Page</a></p>
        <br><br>
        <small>&copy; {{date('Y')}} {{appName()}}</small>
    </div>
</div>
</body>
</html>
