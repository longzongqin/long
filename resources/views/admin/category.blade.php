@extends('common.admin')

@section('head')
    <style>
        #addType > button{
            width: 33.33% !important;
            margin: 0px !important;
        }
        #isShow > button{
            width: 33.33% !important;
            margin: 0px !important;
        }
        #action{
            float: right;
            margin-right: 20px;
        }
        #action > a{
            font-size: 14px;
        }
        .panel-title > a:hover{
            color: red !important;
        }
        .panel-body .list-group{
            margin: 0px !important;
        }
        .panel-body .list-group li{
            border-left: none;
            border-right: none;
        }
        .panel-body .list-group li:first-child{
            border-top: none;
        }
        .panel-body .list-group li:last-child{
            border-bottom: none;
            border-radius: 0px 0px 3px 3px !important;
        }
        .panel-body{
            padding: 0px;
        }
        .modal-body .list-group{
            margin: 0px !important;
        }
    </style>
    <script>
        var addType = 0;
        var addIsShow = 0;
        var moveCategoryID = 0;
        $(function () {
            $("#menu-category").addClass("active");
            $("#addType > button").on("click",function () {
                $("#addType > button").removeClass("active");
                $(this).addClass("active");
                addType = $(this).attr("value");
            });
            $("#isShow > button").on("click",function () {
                $("#isShow > button").removeClass("active");
                $(this).addClass("active");
                addIsShow = $(this).attr("value");
            });
        });
        function addTop(cid) {
            $("#modalTitle").html("添加栏目");
            if(cid == 0){
                $("#addTitle").html("");
            }else{
                $("#addTitle").html("-"+$("#name-"+cid).text());
            }

            $("#addName").val("");
            $("#addSort").val("");
            $("#addUrl").val("");
            $("#addStyle").val("");

            addType = 0;
            addIsShow = 0;
            $("#addType > button").removeClass("active");
            $("#addType > button[value='"+addType+"']").addClass("active");
            $("#isShow > button").removeClass("active");
            $("#isShow > button[value='"+addIsShow+"']").addClass("active");

            $("#addTopDialog").modal("show");
            $("#addBtn").unbind();
            $("#addBtn").on("click",function () {
                var name = $("#addName").val();
                var sort = $("#addSort").val();
                var url = $("#addUrl").val();
                var style = $("#addStyle").val();
                if(name == ""){
                    show_msg("请输入栏目名称！");
                    return;
                }
                if(sort == ""){
                    sort = "{{ time() }}";
                }
                $("#addTopDialog").modal("hide");
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/addCategory') }}",
                    data: {'name':name,'sort':sort,'url':url,'style':style,'type':addType,'status':addIsShow,'parent':cid},
                    dataType:'json',
                    success: function(data){
                        hideLoad();
                        if(data.status == 1){
                            location.reload();
                        }else{
                            show_msg(data.info);
                        }

                    }
                });
            });
        }
        function modifyCategory(cid,obj) {
            $("#modalTitle").html("修改栏目");
            $("#addTitle").html("-"+$("#name-"+cid).text());
            $("#addName").val($("#name-"+cid).text());
            $("#addSort").val($(obj).attr("sort"));
            $("#addUrl").val($(obj).attr("url"));
            $("#addStyle").val($(obj).attr("style"));

            addType = $(obj).attr("type");
            addIsShow = $(obj).attr("status");
            $("#addType > button").removeClass("active");
            $("#addType > button[value='"+addType+"']").addClass("active");
            $("#isShow > button").removeClass("active");
            $("#isShow > button[value='"+addIsShow+"']").addClass("active");

            $("#addTopDialog").modal("show");
            $("#addBtn").unbind();
            $("#addBtn").on("click",function () {
                var name = $("#addName").val();
                var sort = $("#addSort").val();
                var url = $("#addUrl").val();
                var style = $("#addStyle").val();
                if(name == ""){
                    show_msg("请输入栏目名称！");
                    return;
                }
                if(sort == ""){
                    sort = "{{ time() }}";
                }
                $("#addTopDialog").modal("hide");
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/modifyCategory') }}",
                    data: {'name':name,'sort':sort,'url':url,'style':style,'type':addType,'status':addIsShow,'categoryID':cid},
                    dataType:'json',
                    success: function(data){
                        hideLoad();
                        if(data.status == 1){
                            location.reload();
                        }else{
                            show_msg(data.info);
                        }

                    }
                });
            });
        }

        function move(cid){
            moveCategoryID = cid;
            $("#moveDialog").modal("show");
        }

        function doMove(cid) {
            $("#moveDialog").modal("hide");
            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('admin/moveCategory') }}",
                data: {'categoryID':moveCategoryID,'parent':cid},
                dataType:'json',
                success: function(data){
                    hideLoad();
                    if(data.status == 1){
                        location.reload();
                    }else{
                        show_msg(data.info);
                    }

                }
            });
        }

        function delCategory(cid,pid) {
            $("#deleteDialog").modal("show");
            $("#deleteBtn").unbind();
            $("#deleteBtn").on("click",function(){
                $("#deleteDialog").modal("hide");
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/delCategory') }}",
                    data: {'categoryID':cid,'parent':pid},
                    dataType:'json',
                    success: function(data){
                        hideLoad();
                        if(data.status == 1){
                            location.reload();
                        }else{
                            show_msg(data.info);
                        }

                    }
                });
            });
        }
    </script>
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
                <li class="active">栏目管理</li>
            </ul><!-- .breadcrumb -->
            <button type="button" class="btn btn-primary btn-sm pull-right" style="margin: 2px 10px 0px 0px;" onclick="addTop(0);">添加栏目</button>
        </div>


        <div class="page-content">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @if(!empty($category))
                @foreach($category as $k=>$v)
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-{{ $v['categoryID'] }}">
                        <h4 class="panel-title">
                            <a id="name-{{ $v['categoryID'] }}" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $v['categoryID'] }}" aria-expanded="true" aria-controls="collapse-{{ $v['categoryID'] }}">{{ $v['name'] }}</a>
                            <div id="action" class="panel-title">
                                <a role="button" href="#" onclick="modifyCategory('{{ $v["categoryID"] }}',this)" sort="{{ $v['sort'] }}" type="{{ $v['type'] }}" status="{{ $v['status'] }}" url="{{ $v['url'] }}" style="{{ $v['style'] }}">修改</a>&nbsp;&nbsp;|&nbsp;
                                <a role="button" href="#" onclick="addTop({{ $v['categoryID'] }});">添加子类</a>&nbsp;|&nbsp;
                                <a role="button" href="{{ url("admin/categoryArticle",["id"=>$v["categoryID"]]) }}">栏目文章</a>&nbsp;|&nbsp;
                                <a role="button" href="#" onclick="delCategory('{{ $v['categoryID'] }}','{{ $v["parent"] }}')">删除</a>
                            </div>
                        </h4>
                    </div>
                    <div id="collapse-{{ $v['categoryID'] }}" @if($k == 0) class="panel-collapse collapse in" @else class="panel-collapse collapse" @endif role="tabpanel" aria-labelledby="heading-{{ $v['categoryID'] }}">
                        <div class="panel-body">
                            <ul class="list-group">
                                @isset($v['children'])
                                    @foreach($v['children'] as $sv)
                                        <li class="list-group-item">
                                            <span id="name-{{ $sv['categoryID'] }}">{{ $sv["name"] }}</span>
                                            <div id="action" class="panel-title">
                                                <a role="button" href="#" onclick="modifyCategory('{{ $sv["categoryID"] }}',this)" sort="{{ $sv['sort'] }}" type="{{ $sv['type'] }}" status="{{ $sv['status'] }}" url="{{ $sv['url'] }}" style="{{ $sv['style'] }}">修改</a>&nbsp;&nbsp;|&nbsp;
                                                <a role="button" href="#" onclick="move({{ $sv["categoryID"] }})">移动</a>&nbsp;|&nbsp;
                                                <a role="button" href="{{ url("admin/categoryArticle",["id"=>$sv["categoryID"]]) }}">栏目文章</a>&nbsp;|&nbsp;
                                                <a role="button" href="#" onclick="delCategory('{{ $sv['categoryID'] }}','{{ $sv['parent'] }}')">删除</a>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <p style="margin: 5px;">暂无子栏目</p>
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    <div role="dialog" tabindex="-1" id="addTopDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title"><span id="modalTitle">添加栏目</span><span id="addTitle"></span></h4></div>
                <div class="modal-body">
                    <div class="bootbox-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="addName" class="col-sm-2 control-label">栏目名称</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="addName" placeholder="栏目名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addSort" class="col-sm-2 control-label">排序数字</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="addSort" placeholder="排序数字(升序)">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">栏目类型</label>
                                <div class="col-sm-10">
                                    <div class="btn-group btn-group-justified" id="addType" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default active" value="0">列表</button>
                                        <button type="button" class="btn btn-default" value="1">文章</button>
                                        <button type="button" class="btn btn-default" value="2">链接</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addUrl" class="col-sm-2 control-label">栏目链接</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="addUrl" placeholder="栏目类型为链接时生效">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addStyle" class="col-sm-2 control-label">模板样式</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="addStyle" placeholder="模板名(不填默认)">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">栏目可见</label>
                                <div class="col-sm-10">
                                    <div class="btn-group btn-group-justified" id="isShow" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default active" value="0">可见</button>
                                        <button type="button" class="btn btn-default" value="1">不可见</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary" type="button" id="addBtn">确定</button>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" id="moveDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">移动栏目<span id="moveTitle"></span></h4></div>
                <div class="modal-body">
                    <div class="list-group">
                        @if(!empty($category))
                        @foreach($category as $k=>$v)
                            <a href="#" class="list-group-item" onclick="doMove({{ $v['categoryID'] }});">{{ $v["name"] }}</a>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>

    <div role="dialog" tabindex="-1" id="deleteDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">温馨提示<span id="moveTitle"></span></h4></div>
                <div class="modal-body">
                    删除栏目请先删除或移动栏目的子类以及文章，确认删除栏目？
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary" type="button" id="deleteBtn">确定</button>
                </div>
            </div>
        </div>
    </div>

@endsection