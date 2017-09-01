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
                <li class="active page-action">错误提示</li>
            </ul><!-- .breadcrumb -->
        </div>


        <div class="page-content">
            <h4>{{ $msg }}</h4>

        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
@endsection