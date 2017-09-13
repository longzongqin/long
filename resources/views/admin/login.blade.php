<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>登录</title>
		<meta name="keywords" content="登陆" />
		<meta name="description" content="登陆" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="{{ p() }}admin/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="{{ p() }}admin/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="{{ p() }}admin/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->


		<!-- ace styles -->

		<link rel="stylesheet" href="{{ p() }}admin/css/ace.min.css" />
		<link rel="stylesheet" href="{{ p() }}admin/css/ace-rtl.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="{{ p() }}admin/css/ace-ie.min.css" />
		<![endif]-->

		<link rel="stylesheet" href="{{ p() }}admin/css/base.css" />

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="{{ p() }}admin/js/html5shiv.js"></script>
		<script src="{{ p() }}admin/js/respond.min.js"></script>

		<![endif]-->

        <!--[if !IE]> -->

        <script type="text/javascript">
            window.jQuery || document.write("<script src='{{ p() }}admin/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='{{ p() }}admin/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->

        <script type="text/javascript">
            if("ontouchend" in document) document.write("<script src='{{ p() }}admin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
        </script>

        <script src="{{ p() }}admin/js/bootstrap.min.js"></script>
        <script src="{{ p() }}admin/js/base.js"></script>
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">夜猫站</span>
									<span class="white">管理后台</span>
								</h1>
								<h4 class="blue">&copy; longzongqin</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												登陆
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" id="username" placeholder="用户名" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" id="password" placeholder="密码" />
															<i class="icon-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">

														<button type="button" onclick="login();" id="login_button" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="icon-key"></i>
															登陆
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

										</div><!-- /widget-main -->

									</div><!-- /widget-body -->
								</div><!-- /login-box -->


							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->


		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='{{ p() }}admin/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='{{ p() }}admin/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='{{ p() }}admin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>

        <script type="text/javascript">
            if(document.addEventListener){//如果是Firefox
                document.addEventListener("keypress",fireFoxHandler, true);
            }else{
                document.attachEvent("onkeypress",ieHandler);
            }

            function fireFoxHandler(evt){
                //alert("firefox");
                if(evt.keyCode==13){
                    $("#login_button").click();
                }
            }
            function ieHandler(evt){
                //alert("IE");
                if(evt.keyCode==13){
                    $("#login_button").click();
                }
            }
            function login(){
                var username = $("#username").val();
                var password = $("#password").val();
                if(username == ""){
                    show_msg("请输入用户名！");
                    setTimeout('$("#username").focus();',1600);
                    return;
                }
                if(password == ""){
                    show_msg("请输入密码！");
                    setTimeout('$("#password").focus();',1600);
                    return;
                }
                showLoad();
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('admin/doLogin') }}",
                    data: {'username':username,'password':password},
                    dataType:'json',
                    success: function(data){
                       hideLoad();
                        if(data.status == 1){
                            location.href = "{{ url('admin') }}";
                        }else{
                            show_msg(data.info);
                        }

                    }
                });
            }
        </script>

</body>
</html>
