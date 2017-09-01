<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('meta')
    <meta name="keywords" content="{{ session('config.keywords') }}">
    <meta name="description" itemprop="description" content="{{ session('config.description') }}">
    @show
    <meta name="author" content="{{ session('config.author') }}">
    <link rel="icon" href="{{ publicPath() }}img/favicon.ico">

    <title>@yield('title'){{ session('config.webName') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ publicPath() }}bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ publicPath() }}css/base.css" rel="stylesheet">
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
        #navbar li{
            clear: none !important;
        }
        html:-moz-full-screen {
            background: black;
        }

        html:-webkit-full-screen {
            background: black;
        }

        html:fullscreen {
            background: black;
        }
    </style>
    @yield('head')
    <script>
        var docElm = document.documentElement;
        var isFull = 0;
        $(function(){
            $(".dropdown").mouseover(function(){
                $(this).addClass("open");
            });
            $(".dropdown").mouseout(function(){
                $(this).removeClass("open");
            });
            console.log("年少太轻狂，误入IT行");
            console.log("白发森森立，两眼直茫茫");
            console.log("语言数十种，无一称擅长");
            console.log("三十而立时，无房单身郎");
            console.log("曾梦想仗剑走天涯");
            console.log("谁料想苦逼敲代码");
        });

        document.addEventListener("fullscreenchange", function () {
            isFull = (document.fullscreen)? 1 : 0;
            }, false);

        document.addEventListener("mozfullscreenchange", function () {
            isFull = (document.mozFullScreen)? 1 : 0;
            }, false);

        document.addEventListener("webkitfullscreenchange", function () {
            isFull = (document.webkitIsFullScreen)? 1 : 0;
            }, false);
        document.addEventListener("msfullscreenchange", function () {
            isFull = (document.msFullscreenElement)? 1 : 0;
            }, false);

        function fullScreen(){
            if (docElm.requestFullscreen) {//W3C
                docElm.requestFullscreen();
            }else if (docElm.mozRequestFullScreen) {//FireFox
                docElm.mozRequestFullScreen();
            }else if (docElm.webkitRequestFullScreen) {//Chrome等
                docElm.webkitRequestFullScreen();
            }else if (elem.msRequestFullscreen) {//IE11
                elem.msRequestFullscreen();
            }
        }

        function exitFullScreen(){
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            }else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }

        function full(){
            if(isFull == 0){
                fullScreen();
            }else{
                exitFullScreen();
            }
        }

    </script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <img alt="Brand" src="{{ publicPath() }}img/logo.png" style="width: 30px; margin-top: -5px;">
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" onclick="full();">{{ session('config.webName') }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li id="category-0" class="dropdown"><a href="{{ url('/') }}">首页</a></li>
                @foreach(session('menu') as $m)
                    @isset($m["children"])
                        <li class="dropdown" id="category-{{ $m["categoryID"] }}">
                        @if($m["type"] == 0)
                            <a href="{{ url('list',["id"=>$m["categoryID"]]) }}" >{{ $m["name"] }}</a>
                        @endif
                        @if($m["type"] == 1)
                            <a href="{{ url('listArticle',["id"=>$m["categoryID"]]) }}" >{{ $m["name"] }}</a>
                        @endif
                        @if($m["type"] == 2)
                            <a href="{{ $m["url"] }}" >{{ $m["name"] }}</a>
                        @endif
                            <ul class="dropdown-menu navbar-inverse">
                                @foreach($m["children"] as $child)
                                    @if($child["type"] == 0)
                                        <li id="category-{{ $child["categoryID"] }}" isTop="no"><a href="{{ url('list',["id"=>$child["categoryID"]]) }}">{{ $child["name"] }}</a></li>
                                    @endif
                                    @if($child["type"] == 1)
                                        <li id="category-{{ $child["categoryID"] }}" isTop="no"><a href="{{ url('listArticle',["id"=>$child["categoryID"]]) }}">{{ $child["name"] }}</a></li>
                                    @endif
                                    @if($child["type"] == 2)
                                        <li id="category-{{ $child["categoryID"] }}" isTop="no"><a href="{{ $child["url"] }}" target="_blank">{{ $child["name"] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                            @if($m["type"] == 0)
                                <li id="category-{{ $m["categoryID"] }}" class="dropdown"><a href="{{ url('list',["id"=>$m["categoryID"]]) }}">{{ $m["name"] }}</a></li>
                            @endif
                            @if($m["type"] == 1)
                                <li id="category-{{ $m["categoryID"] }}" class="dropdown"><a href="{{ url('listArticle',["id"=>$m["categoryID"]]) }}">{{ $m["name"] }}</a></li>
                            @endif
                            @if($m["type"] == 2)
                                <li id="category-{{ $m["categoryID"] }}" class="dropdown"><a href="{{ $m["url"] }}" target="_blank">{{ $m["name"] }}</a></li>
                            @endif

                    @endisset
                @endforeach
                <li class="dropdown" id="category-search">
                    <a href="{{ url('search') }}" style="padding: 12px;margin-left: 10px;">
                        <img src="{{ publicPath() }}img/search.png" class="" style="width: 25px;height: 25px;">
                    </a>
                </li>
            </ul>

            <img src="{{ publicPath() }}img/full.png" onclick="full();" class="visible-md-block visible-lg-block" style="width: 25px;height: 25px;float: right;margin-top: 12px;" data-toggle="tooltip" data-placement="bottom" title="全屏浏览">
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container content">

    @yield('body')

</div><!-- /.container -->

@yield('footer')

<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?06303dc6253e42ec0cc1f529836f4842";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>
</html>
