@extends('common.admin')

@section('head')
    <style>
        #headTable{
            width: 100%;
        }
        #headTable tr > td:first-child{
            width: 80px;
            vertical-align: middle;
        }
        .selectDiv > select{
            width: 50%;
            float: left;
        }
        .default-img{
            overflow: hidden;
        }
        .default-img > div{
            width: 25%;
            padding: 1px;
            float: left;
        }
        .default-img img{
            width: 100%;
        }

        #J_prismPlayer{
            min-height: 200px;
            max-height: 200px;
            max-width: 300px;
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
    </style>
    {{--<link rel="stylesheet" type="text/css" href="//g.alicdn.com/de/prismplayer/1.4.10/skins/default/index-min.css">--}}
    {{--<script src="//g.alicdn.com/de/prismplayer/1.4.10/prism-h5-min.js"></script>--}}
    <link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/1.5.7/skins/default/index.css" />
    <script type="text/javascript" src="//g.alicdn.com/de/prismplayer/1.5.7/prism-min.js"></script>

@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
                <li class="active page-action">添加文章</li>
            </ul><!-- .breadcrumb -->
            <button type="button" class="btn btn-success btn-sm pull-right page-action" style="margin: 2px 10px 0px 0px;" onclick="add();">添加文章</button>
        </div>


        <div class="page-content">
            <table id="headTable" class="table table-bordered">
                <tr>
                    <td><label class="control-label">文章标题</label></td>
                    <td><input type="text" class="form-control" id="title" placeholder="请输入文章标题"></td>
                </tr>
                <tr>
                    <td><label class="control-label">文章分类</label></td>
                    <td>
                        <div class="selectDiv">
                            <select class="form-control " id="select-1">
                                @foreach($category as $k=>$v)
                                    <option value="{{ $v['categoryID'] }}" k="{{ $k }}">{{ $v["name"] }}</option>
                                @endforeach
                            </select>
                            @isset($category[0]['children'])
                            <select class="form-control " id="select-2">
                                @foreach($category[0]['children'] as $sv)
                                    <option value="{{ $sv['categoryID'] }}">{{ $sv["name"] }}</option>
                                @endforeach
                            </select>
                            @else
                                <select class="form-control " id="select-2" style="display: none;">
                                </select>
                            @endisset
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="control-label">文章封面</label></td>
                    <td>
                        <div>
                            <img id="showImg" onclick="addImg();" src="{{ p() }}img/add-pic.png" width="64px" height="64px">
                            <button class="btn" style="margin-left: 10px;" onclick="$('#imgDialog').modal('show');">选择封面</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="control-label">上传视频</label></td>
                    <td>
                        <div id="container">
                            <img src="{{ p() }}img/add-pic.png" width="64px" id="selectfiles">
                            <span style="margin-left: 10px;">上传视频默认使用视频代替文章封面</span>
                            <button class="btn btn-danger" style="margin-left: 10px; display: none;" id="delBtn" onclick="delVideo();">删除视频</button>
                        </div>
                        <div id="videoDiv"></div>
                    </td>
                </tr>
            </table>

            <script id="editor" type="text/plain" style="width:100%;height:500px;">{!! $content !!}</script>

        </div><!-- /.page-content -->
    </div><!-- /.main-content -->



    <div role="dialog" tabindex="-1" id="imgDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">选择封面</h4></div>
                <div class="modal-body default-img">
                    <div><img src="http://oss.longzongqin.cn/long/default-img/code.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/php.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/database.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/html5.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/css.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/js.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/wechat.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/mini.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/linux.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/java.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/android.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/swift.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/python.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/long.jpg"></div>
                    <div><img src="http://oss.longzongqin.cn/long/default-img/cat.jpg"></div>
            </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>


    <div role="dialog" tabindex="-1" id="progressDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">正在上传视频，请稍后...</h4></div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" :style="'width: '+ progress +'%;'">
                            @{{ progress }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" id="deleteDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">温馨提示</h4></div>
                <div class="modal-body">
                    确认删除视频？
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary" type="button" id="deleteBtn">确定</button>
                </div>
            </div>
        </div>
    </div>


    <div style="display: none;">
        <input type="file" accept="image/*" id="uploadImage" onchange="selectFileImage(this,'showImg')" />
    </div>


    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/lang/zh-cn/zh-cn.js"></script>

    <script type="text/javascript" src="{{ p() }}js/exif.js"></script>
    <script type="text/javascript" src="{{ p() }}js/uploadImage.js"></script>
    <script type="text/javascript" src="{{ p() }}oss/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
    <script type="text/javascript" src="{{ p() }}oss/upload-video.js"></script>
    <script type="text/javascript" src="{{ p() }}js/vue.min.js"></script>
    <script>
        var ue = UE.getEditor('editor');
        var isDefaultImg = 0;
        var videoUrl = "";
        var imgUrl = "";
        var base64 = "";
        var suffix = "";
        var content = "";
        var progress = 0;
        var category = escapeHtml("{{ json_encode($category) }}");
        category = JSON.parse(category);
        console.log(category);

        var articleID = "{{ $articleID }}";

        $(function () {
            $("#menu-article-add").addClass("active");
            $("#select-1").on("change",function(){
                var k = $("#select-1").find("option:selected").attr("k");
                var html = "";
                var children = category[k]["children"];
                if(children != undefined){
                    for(var i = 0; i < children.length; i++){
                        html += '<option value="'+children[i]["categoryID"]+'">'+children[i]["name"]+'</option>';
                    }
                }
                $("#select-2").html(html);
                if(html == ""){
                    $("#select-2").hide();
                }else{
                    $("#select-2").show();
                }

            });

            $(".default-img > div > img").on("click",function(){
                $("#showImg").attr("src",$(this).attr("src"));
                $("#imgDialog").modal("hide");
                imgUrl = $(this).attr("src");
                isDefaultImg = 0
            });

            if(articleID > 0){
                var article = JSON.parse(escapeHtml("{{ json_encode($article) }}"));

                $("#title").val(article["title"]);
                $("#showImg").attr("src",article["imgUrl"]);
                imgUrl = article["imgUrl"];

                $("#select-1").find("option[value='"+article["cateArr"][0]["categoryID"]+"']").prop("selected",true);
                $("#select-1").change();
                if(article["cateArr"][1]){
                    $("#select-2").find("option[value='"+article["cateArr"][1]["categoryID"]+"']").prop("selected",true);
                    $("#select-2").show();
                }else{
                    $("#select-2").html("");
                    $("#select-2").hide();
                }
                $(".page-action").html("修改文章");

                if(article["videoUrl"] != "" && article["videoUrl"] != null){
                    videoUrl = article["videoUrl"];
                    initPlayer(article["videoUrl"]);
                    $("#delBtn").show();
                }
            }

        });

        var app = new Vue({
            el: '#progressDialog',
            data:{
                progress: progress
            },
            mounted: function(){
                console.log("你很厉害，还会看控制台！");
            },
            methods:{

            }
        });

        function delVideo(){
            $("#deleteDialog").modal("show");
            $("#deleteBtn").unbind();
            $("#deleteBtn").on("click",function(){
                $("#deleteDialog").modal("hide");
                $("#videoDiv").html("");
                videoUrl = "";
                $("#delBtn").hide();
            });
        }

        function addImg() {
            document.getElementById("uploadImage").click();
        }
        function uploadCallback(b64,s){
            base64 = b64;
            suffix = s;
            isDefaultImg = 1;
        }

        function uploadVideo() {
            app.progress = 0;
            $('#progressDialog').modal({backdrop: 'static', keyboard: false});
            $("#progressDialog").modal("show");
        }

        function updateUploadProgress(scale) {
            app.progress = scale;
        }

        function uploadOver(status,info,filename) {
            $("#progressDialog").modal("hide");
            if(status != 500){
                console.log(filename);
                videoUrl = "{{ env('OSS_URL') }}"+filename;
                initPlayer(videoUrl);
                $("#videoDiv").show();
                $("#delBtn").show();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"{{url('common/saveVideoUrl')}}",
                    data:{'url':videoUrl},
                    dataType:'json',
                    success: function(data){
                    }
                });
            }else{
               show_msg(info);
            }
        }

        function initPlayer(url) {
            // 初始化播放器
            $("#videoDiv").html('<div id="J_prismPlayer" class="prism-player"></div>');
            player = new prismplayer({
                id: "J_prismPlayer", // 容器id
                source: url,// 视频地址
                autoplay: false,    //自动播放：否
                width: "100%",       // 播放器宽度
                playsinline: true
            });
            player.play();
        }

        function add(){
            var title = $("#title").val();
            var content = UE.getEditor('editor').getContent();
            if(title == ""){
                show_msg('请输入标题！');
                return;
            }

            var categoryID = $("#select-2").val();
            if(categoryID == "" || categoryID == null){
                categoryID = $("#select-1").val();
            }

            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('admin/doAddArticle')}}",
                data:{'videoUrl':videoUrl,'title':title,'categoryID':categoryID,'imgUrl':imgUrl,'base64':base64,'suffix':suffix,'isDefaultImg':isDefaultImg,'content':content,'articleID':articleID},
                dataType:'json',
                success: function(data){
                    hideLoad();
                    show_msg(data.info);
                    if(data.status == 1){
                        location.href = "{{ url('admin/article') }}";
                    }
                }
            });

        }
    </script>
@endsection