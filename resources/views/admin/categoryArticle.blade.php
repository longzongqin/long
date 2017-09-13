@extends('common.admin')

@section('head')
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
                try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>
            <ul class="breadcrumb">
                <li class="active page-action">{{ $category->name }}</li>
            </ul><!-- .breadcrumb -->
            <button type="button" class="btn btn-success btn-sm pull-right page-action" style="margin: 2px 10px 0px 0px;" onclick="save();">保存</button>
        </div>


        <div class="page-content">

            <div id="editor" type="text/plain" style="width:100%;height:500px;"></div>

        </div><!-- /.page-content -->
    </div><!-- /.main-content -->





    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="{{ p() }}ueditor/lang/zh-cn/zh-cn.js"></script>

    <script>
        var ue = UE.getEditor('editor');
        var caID = "{{ $caID }}";
        var categoryID = "{{ $category->categoryID }}";
        $(function () {
            $("#menu-category").addClass("active");
            ue.ready(function(){
                var initContent = escapeHtml("{{ $content }}");
                UE.getEditor('editor').setContent(initContent,false);
            });
        });

        function save(){
            var content = UE.getEditor('editor').getContent();

            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ url('admin/saveCategoryArticle') }}",
                data:{'content':content,'caID':caID,'categoryID':categoryID},
                dataType:'json',
                success: function(data){
                    hideLoad();
                    show_msg(data.info);
                    if(data.status == 1){
                        location.href = "{{ url('admin/category') }}";
                    }
                }
            });

        }
    </script>
@endsection