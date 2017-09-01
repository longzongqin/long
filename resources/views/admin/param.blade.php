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
    </style>
    <script src="{{ publicPath() }}js/register-validate.js"></script>
    <script>
        $(function () {
            $("#menu-param").addClass("active");
        });
        function addParam(cid,obj,isMust) {
            if(isMust == 1){
                $("#addKey").attr("disabled","disabled");
            }else{
                $("#addKey").removeAttr("disabled");
            }
            if(cid == 0){
                $("#modalTitle").html("添加参数");
                $("#addPlain").val("");
                $("#addSort").val("");
                $("#addKey").val("");
                $("#addValue").val("");
            }else{
                $("#modalTitle").html("修改参数");
                $("#addPlain").val($(obj).attr("plain"));
                $("#addSort").val($(obj).attr("sort"));
                $("#addKey").val($(obj).attr("key"));
                $("#addValue").val($(obj).attr("value"));
            }
            $("#addParamDialog").modal("show");
            $("#addBtn").unbind();
            $("#addBtn").on("click",function () {
                var plain = $("#addPlain").val();
                var sort = $("#addSort").val();
                var key = $("#addKey").val();
                var value = $("#addValue").val();
                if(plain == ""){
                    show_msg("请输入参数说明！");
                    return;
                }
                if(key == ""){
                    show_msg("请输入key！");
                    return;
                }
                if(value == ""){
                    show_msg("请输入value！");
                    return;
                }
                if(sort == ""){
                    sort = "{{ time() }}";
                }
                if(!isInteger(sort)){
                    show_msg("排序请输入整数！");
                    return;
                }
                $("#addTopDialog").modal("hide");
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/saveParam') }}",
                    data: {'plain':plain,'sort':sort,'key':key,'value':value,'configID':cid},
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

        function delParam(cid,isMust){
            if(isMust == 1){
                show_msg("必须参数不可以删除！")
                return;
            }
            $("#deleteDialog").modal("show");
            $("#deleteBtn").unbind();
            $("#deleteBtn").on("click",function(){
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/delParam') }}",
                    data: {'configID':cid},
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
                <li class="active">参数配置</li>
            </ul><!-- .breadcrumb -->
            <button type="button" class="btn btn-primary btn-sm pull-right" style="margin: 2px 10px 0px 0px;" onclick="addParam(0);">添加参数</button>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="sample-table-1">
                                <thead>
                                <tr>
                                    <th>key</th>
                                    <th>value</th>
                                    <th>说明</th>
                                    <th>排序</th>
                                    <th width="110px">操作</th>
                                </tr>
                                </thead>

                                <tbody id="panel">
                                    @foreach($data as $k=>$v)
                                    <tr id="article-{$vo.articleID}"  style="vertical-align: middle;">
                                        <td>{{ $v->key }}</td>
                                        <td>{{ $v->value }}</td>
                                        <td>{{ $v->plain }}</td>
                                        <td>{{ $v->sort }}</td>
                                        <td>
                                            <div class="operation">
                                                <i class="icon-pencil bigger-130 blue" onclick="addParam('{{ $v->configID }}',this,'{{ $v->isMust }}')" plain="{{ $v->plain }}" key="{{ $v->key }}" value="{{ $v->value }}" sort="{{ $v->sort }}"></i>
                                                <i class="icon-trash bigger-130 red" onclick="delParam('{{ $v->configID }}','{{ $v->isMust }}')"></i>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->

    <div role="dialog" tabindex="-1" id="addParamDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title"><span id="modalTitle">添加栏目</span></h4></div>
                <div class="modal-body">
                    <div class="bootbox-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="addKey" class="col-sm-2 control-label">key</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="addKey" placeholder="key">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addValue" class="col-sm-2 control-label">value</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="addValue" placeholder="value">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addPlain" class="col-sm-2 control-label">参数说明</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="addPlain" placeholder="参数说明">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="addSort" class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control" id="addSort" placeholder="排序数字(升序)">
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

    <div role="dialog" tabindex="-1" id="deleteDialog" class="bootbox modal fade in" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="bootbox-close-button close" data-dismiss="modal" type="button">×</button>
                    <h4 class="modal-title">温馨提示<span id="moveTitle"></span></h4></div>
                <div class="modal-body">
                    确认删除参数？
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-primary" type="button" id="deleteBtn">确定</button>
                </div>
            </div>
        </div>
    </div>


@endsection