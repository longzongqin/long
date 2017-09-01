<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ session('config.keywords') }}">
    <meta name="description" itemprop="description" content="{{ session('config.description') }}">
    <meta name="author" content="{{ session('config.author') }}">
    <link rel="icon" href="{{ publicPath() }}img/favicon.ico">

    <title>{{ session('config.webName') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ publicPath() }}bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ publicPath() }}bootstrap/js/jquery.min.js"></script>
    <script src="{{ publicPath() }}bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ publicPath() }}js/base.js"></script>

    <style>
        .dropdown-menu > li > a{
            color: white;
        }
        body{
            padding-top: 70px;
            background: black;
        }
    </style>
    @yield('head')
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img alt="Brand" src="{{ publicPath() }}img/logo.png" style="width: 30px; margin-top: -5px;">
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ session('config.webName') }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container content">

    <h2 style="color: white;">{{ $msg }}</h2>

</div><!-- /.container -->

@yield('footer')
</body>
</html>
