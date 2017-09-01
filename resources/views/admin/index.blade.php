@extends('common.admin')

@section('head')
    <script>
        $(function () {
            $("#menu-index").addClass("active");
        });
    </script>
@endsection

@section('content')
    <div class="main-content">
        <img src="{{ publicPath() }}img/loading.gif" width="100%">
    </div>
@endsection