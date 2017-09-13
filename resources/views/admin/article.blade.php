@extends('common.admin')

@section('head')
    <style>
        td{
            vertical-align: middle !important;
        }
        .operation i{
            margin-left: 10px;
        }
        .operation i:hover{
            margin-left: 10px;
            font-size: 24px;
        }
        .selectDiv{
            overflow: hidden;
            float: right;
            margin-right: 20px;
            margin-top: 3px;
        }
        .selectDiv select{
            float: left;
            width: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
                <li class="active">文章管理</li>
            </ul><!-- .breadcrumb -->
            <div class="selectDiv">
                <select class="form-control " id="select-1">
                    <option value="0" k="-1">全部</option>
                    @foreach($category as $k=>$v)
                        <option value="{{ $v['categoryID'] }}" k="{{ $k }}">{{ $v["name"] }}</option>
                    @endforeach
                </select>
                <select class="form-control " id="select-2">
                    <option value="0">全部</option>
                </select>
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="content">
                                <thead>
                                <tr>
                                    <th width="50px">封面</th>
                                    <th>标题</th>
                                    <th width="140px">更新时间</th>
                                    <th width="110px">操作</th>
                                </tr>
                                </thead>

                                <tbody id="panel">
                                    <tr v-for="m in content" style="vertical-align: middle;">
                                        <td><img :src="m.imgUrl+'?x-oss-process=image/resize,m_fill,h_40,w_60'" width="60px"> </td>
                                        <td :id="'article-' + m.articleID">@{{ m.title }}</td>
                                        <td>@{{ m.updateTime|time }}</td>
                                        <td>
                                            <div class="operation">
                                                <i class="icon-eye-open bigger-130 green" @click="look(m.articleID)"></i>
                                                <i class="icon-pencil bigger-130 blue" @click="edit(m.articleID)"></i>
                                                <i class="icon-trash bigger-130 red" @click="del(m.articleID)"></i>
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div id="Pagination"></div>
                        </div><!-- /.table-responsive -->
                    </div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    <div role="dialog" tabindex="-1" id="deleteDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">温馨提示</h4></div>
                <div class="modal-body">
                    确认删除文章[<span id="delTitle"></span>]？
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary" type="button" id="deleteBtn">确定</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ p() }}js/vue.min.js"></script>
    <script type="text/javascript" src="{{ p() }}js/vueFilter.js"></script>

    <link href="{{ p() }}css/pagination.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{ p() }}js/jquery.pagination.js"></script>

    <script>
        var categoryID = 0;
        var category = escapeHtml("{{ json_encode($category) }}");
        category = JSON.parse(category);
        var content = escapeHtml("{{ $data }}");
        var pageNum = 0;
        content = JSON.parse(content);
        initFilter();
        var app = new Vue({
            el: '#content',
            data:{
                content: content
            },
            mounted: function(){
                console.log("你很厉害，还会看控制台！");
            },
            methods:{
                del: function(aid){
                    $("#delTitle").html($("#article-"+aid).text());
                    $("#deleteDialog").modal("show");
                    $("#deleteBtn").unbind();
                    $("#deleteBtn").on("click",function(){
                        showLoad();
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url:"{{url('admin/delArticle')}}",
                            data:{'articleID':aid},
                            dataType:'json',
                            success: function(data){
                                hideLoad();
                                show_msg(data.info);
                               if(data.status == 1){
                                   location.reload();
                               }
                            }
                        });
                    });
                },
                edit: function(aid){
                    location.href = "{{ env("APP_URL") }}/admin/addArticle?articleID="+aid;
                },
                look: function(aid){
                    window.open("{{ url("article") }}/"+aid);
                }
            }
        });

        $(function () {
            $("#menu-article").addClass("active");
            $("#select-1").on("change",function(){
                var k = $("#select-1").find("option:selected").attr("k");
                var html = '<option value="0">全部</option>';
                if(k == -1){
                    $("#select-2").html(html);
                    categoryID = 0;
                    load(1);
                    return;
                }
                var children = category[k]["children"];
                categoryID =$("#select-1").val();
                if(children != undefined){
                    for(var i = 0; i < children.length; i++){
                        html += '<option value="'+children[i]["categoryID"]+'">'+children[i]["name"]+'</option>';
                    }
                }
                $("#select-2").html(html);

                load(1);
            });
            $("#select-2").on("change",function(){
                if($("#select-1").val() == 0){
                    categoryID =$("#select-1").val();
                }else{
                    categoryID =$("#select-2").val();
                }
                load(1);
            });

            init("{{ $articleCount }}");
        });

        function pageselectCallback(page_index){
            pageNum = page_index;
            if(page_index < 0){
                return;
            }
            load(0);
        }

        function load(isNext){
            if(isNext == 1){
                pageNum = 0;
            }
            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{url('admin/loadArticle')}}",
                data:{'pageNum':pageNum,'categoryID':categoryID},
                dataType:'json',
                success: function(data){
                    hideLoad();
                    app.content = data.data;
                    if(isNext == 1){
                        init(data.info);
                    }
                }
            });
        }

        function createNewOptions(){
            //设置回调函数
            var opt = {callback: pageselectCallback};
            //每页记录的条数
            opt.items_per_page = 20;
            //显示的可见的分页数
            opt.num_display_entries = 10;
            //分页链接在末尾显示的个数
            opt.num_edge_entries = 2;
            opt.prev_text = '上一页';
            opt.next_text = '下一页';
            opt.link_to = "javascript:void(0);";
            //返回这个opt即可
            return opt;
        }

        function init(itemCounts){
            if(itemCounts < 1){
                itemCounts = 1;
            }

            //调用我们自己写的创建option的函数
            var optInit = createNewOptions();
            //Pagination就是html文件中分页栏的位置

            /*参数是itemCounts是传入总的条目数，
             *就是说，这个插件不需要你自己计算需要分多少页，
             *只要把opt对象里的值设好就行。
             *optInit是我们创建的opt
             */
            $("#Pagination").pagination(itemCounts, optInit);
        }



    </script>
@endsection