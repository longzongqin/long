@extends('common.app')

@section('title'){{ $article->name }}-@endsection


@section('head')
    <style>
        .article-div{
            background: white;
            border-radius: 10px;
            padding: 10px;
        }
        .article{
            border-top: 1px solid gainsboro;
            margin-top: 10px;
            padding-top: 10px;
        }
    </style>
    <script>
        $(function(){
            var categoryID = "{{ $article->categoryID }}";
            $("#category-"+categoryID).addClass("active");
            var isTop = $("#category-"+categoryID).attr("isTop");
            if(isTop == "no"){
                $("#category-"+categoryID).parent().parent().addClass("active");
            }

            $.ajax({
                type: "POST",
                url: "{{ url('addLog') }}",
                data: {"type":3,"typeID":categoryID},
                dataType:'json',
                success: function(data){
                }
            });
        });
    </script>
@endsection

@section('body')
    <div class="article-div">
        <h4>{{ $article->name }}</h4>
        <div class="article">
            {!! $article->content !!}
        </div>
    </div>
@endsection

@section('footer')
    @include('common.reward')
    <br>
    @include('common.ad')
    <div id="SOHUCS" sid="longlistarticlecategory{{ $article->categoryID }}"></div>
    @include('common.comment')
@endsection
