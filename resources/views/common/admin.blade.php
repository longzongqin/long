<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>后台管理系统</title>
    <meta name="keywords" content="后台管理系统" />
    <meta name="description" content="后台管理系统" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="{{ p() }}admin/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ p() }}admin/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="{{ p() }}admin/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="{{ p() }}admin/css/ace.min.css" />
    <link rel="stylesheet" href="{{ p() }}admin/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="{{ p() }}admin/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="{{ p() }}admin/css/ace-ie.min.css" />
    <![endif]-->

    <link rel="stylesheet" href="{{ p() }}admin/css/base.css" />


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
    <script src="{{ p() }}admin/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->

    <!-- ace scripts -->

    <script src="{{ p() }}admin/js/ace-elements.min.js"></script>
    <script src="{{ p() }}admin/js/ace.min.js"></script>
    <script src="{{ p() }}admin/js/base.js"></script>

    <!-- inline scripts related to this page -->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="{{ p() }}admin/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="{{ p() }}admin/js/html5shiv.js"></script>
    <script src="{{ p() }}admin/js/respond.min.js"></script>
    <![endif]-->
    <style>
        td{word-break: break-all;}
    </style>
    @yield('head')
</head>

<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>
                    <i class="icon-leaf"></i>
                    管理后台
                </small>
            </a><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{ p() }}admin/avatars/user.png" alt="Jason's Photo" />
                        <span class="user-info">
									<small>欢迎您</small>
									{{ session("adminInfo.name") }}
								</span>

                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a onclick="logout();">
                                <i class="icon-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>


            <ul class="nav nav-list">
                <li id="menu-index">
                    <a href="{{ url('admin') }}">
                        <i class="icon-home"></i>
                        <span class="menu-text"> 首页 </span>
                    </a>
                </li>
                <li id="menu-category">
                    <a href="{{ url('admin/category') }}">
                        <i class="icon-th-list"></i>
                        <span class="menu-text"> 栏目管理 </span>
                    </a>
                </li>
                <li id="menu-article">
                    <a href="{{ url('admin/article') }}">
                        <i class="icon-book"></i>
                        <span class="menu-text"> 文章管理 </span>
                    </a>
                </li>
                <li id="menu-article-add">
                    <a href="{{ url('admin/addArticle') }}">
                        <i class="icon-pencil"></i>
                        <span class="menu-text"> 添加文章 </span>
                    </a>
                </li>
                <li id="menu-html-create">
                    <a href="{{ url('admin/createHtml') }}">
                        <i class="icon-code"></i>
                        <span class="menu-text"> 静态生成 </span>
                    </a>
                </li>
                <li id="menu-param">
                    <a href="{{ url('admin/param') }}">
                        <i class="icon-cogs"></i>
                        <span class="menu-text"> 参数配置 </span>
                    </a>
                </li>

            </ul><!-- /.nav-list -->

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>

            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
            </script>

            <script type="text/javascript">
                function logout(){
                    $.ajax({
                        type: "POST",
                        url: "__APP__/Login/logout",
                        data: {},
                        dataType:'json',
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            </script>

        </div>

        @yield('content')

        <div class="ace-settings-container" id="ace-settings-container">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="icon-cog bigger-150"></i>
            </div>

            <div class="ace-settings-box" id="ace-settings-box">
                <div>
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="default" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; 选择皮肤</span>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                    <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                    <label class="lbl" for="ace-settings-breadcrumbs"> 固定面包屑</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl"> 切换到左右</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                        切换宽窄屏
                    </label>
                </div>
            </div>
        </div><!-- /#ace-settings-container -->
    </div><!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->

<!-- basic scripts -->
<script>
    $(function () {
        initStyle("{{ session('adminStyle') }}");
    });

    function updateStyle(d){
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('admin/updateStyle') }}",
            data: {'style':d},
            dataType:'json',
            success: function(data){
               console.log(data.info);
            }
        });
    }
    function initStyle(d){
        console.log("风格："+d);
        $("#skin-colorpicker").find("option[data-skin='"+d+"']").attr("selected",true);
        $("#skin-colorpicker").change();
    }
</script>

</body>
</html>
