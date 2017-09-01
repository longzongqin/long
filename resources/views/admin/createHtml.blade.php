@extends('common.admin')

@section('head')
	<style>
		.page-content > button{
			padding: 5px 20px;
		}
		#info{
			padding: 10px;
			border: 1px solid rebeccapurple;
			margin-top: 10px;
			display: none;
		}
	</style>
	<script>
        $(function () {
            $("#menu-html-create").addClass("active");
        });
        function create(type){
            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('admin/doCreateHtml') }}",
                data: {'type':type},
                dataType:'json',
                success: function(data){
                    hideLoad();
					$("#info").append("<p>"+data.info+"</p>");
					$("#info").show();
                }
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
				<li class="active page-action">静态生成</li>
			</ul><!-- .breadcrumb -->
		</div>
		<div class="page-content">

			<button class="btn" onclick="create(0);">首页生成</button>
			<button class="btn" onclick="create(1);">列表生成</button>
			<button class="btn" onclick="create(2);">文章生成</button>

			<div id="info">

			</div>

		</div><!-- /.page-content -->
	</div><!-- /.main-content -->
@endsection