@extends('common.app')

@section('meta')
    <meta name="keywords" content="{{ $article->title }}">
    <meta name="description" itemprop="description" content="{!! mb_substr(strip_tags($article->content),0,100) !!}">
@endsection

@section('title'){{ $article->title }}-@endsection


@section('head')
    <style>
        .article-div{
            background: white;
            border-radius: 10px;
            padding: 10px;
        }
        .head{
            position: relative;
            overflow: hidden;
        }

        .head > div:first-child{
            float: left;
            width: 100px;
            text-align: center;
            color: gray;
        }
        .head > div:last-child{
            position: absolute;
            left: 120px;
            right: 10px;
            top: 0px;
            overflow: scroll;
            margin: -10px;
        }
        .head img{
            width: 100%;
        }
        .head > div > h4{
            float: left;
            color: black;
        }

        .article{
            border-top: 1px solid gainsboro;
            margin-top: 10px;
            padding: 15px 0px 5px 0px;
        }
        .article img{
            max-width: 100%;
        }

        #J_prismPlayer{

        }
        .prism-controlbar-bg{
            opacity: 0.5;
        }
        .prism-player .prism-time-display{
            color: white !important;
        }
        .prism-player .prism-progress{
            height: 2px !important;
            margin-top: 11px !important;
        }
        .prism-player .prism-progress .prism-progress-cursor{
            margin-top: -3px !important;
        }
        .prism-player .prism-big-play-btn{
            left: 50% !important;
            margin-left: -45px !important;
            top: 50% !important;
            margin-top: -45px !important;
        }

        #videoDiv{
            margin-top: 5px;
        }

        .article-footer{
            border-top: 1px solid gainsboro;
            padding-top: 10px;
        }
        .time{
            color: grey;
        }
        .syntaxhighlighter{
            white-space: normal;
            word-break: break-all;
        }
    </style>
    <style id="jsStyle">

    </style>
    <script src="{{ publicPath() }}ueditor/ueditor.parse.min.js"></script>
    <link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/1.5.7/skins/default/index.css" />
    <script type="text/javascript" src="//g.alicdn.com/de/prismplayer/1.5.7/prism-min.js"></script>
    <script>
        var player = "";
        $(function(){
            var categoryID = "{{ $article->categoryID }}";
            $("#category-"+categoryID).addClass("active");
            var isTop = $("#category-"+categoryID).attr("isTop");
            if(isTop == "no"){
                $("#category-"+categoryID).parent().parent().addClass("active");
            }

            var videoUrl = "{{ $article->videoUrl }}";
            if(videoUrl != "" && videoUrl != null){
                initPlayer(videoUrl);
            }

            var articleID = "{{ $article->articleID }}";
            $.ajax({
                type: "POST",
                url: "{{ url('addLog') }}",
                data: {"type":2,"typeID":articleID},
                dataType:'json',
                success: function(data){
                }
            });
            var browser={
                versions:function(){
                    var u = navigator.userAgent,
                        app = navigator.appVersion;
                    return {
                        trident: u.indexOf('Trident') > -1, //IE内核
                        presto: u.indexOf('Presto') > -1, //opera内核
                        webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
                        mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
                        ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                        android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
                        iPhone: u.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器
                        iPad: u.indexOf('iPad') > -1, //是否iPad
                        webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
                        weixin: u.indexOf('MicroMessenger') > -1, //是否微信 （2015-01-22新增）
                        qq: u.match(/\sQQ/i) == " qq" //是否QQ
                    };
                }(),
                language:(navigator.browserLanguage || navigator.language).toLowerCase()
            }

            if(browser.versions.gecko){
                $("#jsStyle").html(".syntaxhighlighter td.code .container{top: -15px !important;}");
            }
            uParse('.article', {
                rootPath: '{{ publicPath() }}ueditor/'
            });

        });

        function initPlayer(url) {
            var urlArr = url.split(".");
            var img = "http://video.longzongqin."+urlArr[2]+".jpg";
            // 初始化播放器
            $("#videoDiv").html('<div id="J_prismPlayer" class="prism-player"></div>');
            player = new prismplayer({
                id: "J_prismPlayer", // 容器id
                source: url,// 视频地址
                cover: img,// 视频地址
                autoplay: false,    //自动播放：否
                width: "100%",       // 播放器宽度
                playsinline: true   //播放时不自动全屏
            });
        }

    </script>
@endsection

@section('body')
    <div class="article-div">
        <div class="head">
            <div>
                <img src="{{ $article->imgUrl }}?x-oss-process=image/resize,m_fill,h_200,w_300" onerror="defaultImg(this);">
            </div>
            <div class="row">
                <h4 class="visible-xs-block">{{ $article->title }}</h4>
                <h4 class="visible-sm-block visible-md-block visible-lg-block" style="margin-top: 30px;">{{ $article->title }}</h4>
            </div>
        </div>
        <div id="videoDiv"></div>
        @if(!empty($article->content))
        <div class="article">
            {!! $article->content !!}
        </div>
        @endif
        <div class="article-footer">
            <span class="time">{{ date("Y-m-d H:i",$article->createTime) }}</span>
            @if($article->createTime != $article->updateTime)
            <span class="time pull-right">{{ date("Y-m-d H:i",$article->updateTime) }}更新</span>
            @endif
        </div>
    </div>
@endsection


@section('footer')
    @include('common.reward')
    {{--分享--}}
    <div class="bdsharebuttonbox" style="margin-top: 20px;">
        <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
        <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
        <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
        <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
        <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
        <a href="#" class="bds_more" data-cmd="more"></a>
    </div>
    <script>
        window._bd_share_config={
            "common":{
                "bdPopTitle":"{{ $article->title }}-{{ session('config.webName') }}",
                "bdSnsKey":{},
                "bdText":"{{ $article->title }}-{{ session('config.webName') }}",
                "bdMini":"2",
                "bdMiniList":false,
                "bdPic":"{{ $article->imgUrl }}?x-oss-process=image/resize,m_fill,h_200,w_300", /* 此处填写要分享图片地址 */
                "bdStyle":"0",
                "bdSize":"32"
            },
            "share":{}
        };
        with(document)0[
            (getElementsByTagName('head')[0]||body).
            appendChild(createElement('script')).
                src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)
            ];
    </script>
    <br>
    @include('common.ad')
    <div id="SOHUCS" sid="{{ $article->sourceID }}"></div>
    @include('common.comment')
@endsection

