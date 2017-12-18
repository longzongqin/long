@extends('common.app')

@section('title')
@endsection


@section('head')
    <style>
        .row > div{
            padding: 10px;
        }
        .row-item img:first-child{
            width: 100%;
        }
        .row-item{
            text-align: center;
            border-radius: 10px;
            padding: 10px;
            background: white;
            color: black;
        }
        .row-item > h4{
            height:38px;
        }
        .videoIcon{
            position: absolute ;
            right: 30px;
            top: 30px;
            width: 56px;
        }
        .row-item:hover, .row-item:active{
            background: blueviolet;
            color: white;
        }
    </style>
    <script>
        $(function(){
            var id = "{{ $id }}";
            $("#category-"+id).addClass("active");
            var isTop = $("#category-"+id).attr("isTop");
            if(isTop == "no"){
                $("#category-"+id).parent().parent().addClass("active");
            }

            $.ajax({
                type: "POST",
                url: "{{ url('addLog') }}",
                data: {"type":1,"typeID":id},
                dataType:'json',
                success: function(data){
                }
            });
        });
    </script>
@endsection

@section('body')
    <div class="row">
        @foreach($list as $v)
        <div class="col-xs-12 col-sm-6 col-md-3" onclick="location='{{ url("article",["id"=>$v->articleID]) }}'">
            <div class="row-item">
                <img src="{{ $v->imgUrl }}?x-oss-process=image/resize,m_fill,h_300,w_450,limit_0" onerror="defaultImg(this);" alt="{{ $v->title }}">
                <h4>{{ $v->title }}</h4>
                @if(!empty($v->videoUrl))
                <img src="{{ p() }}img/video.png" class="videoIcon" />
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div style="width: 100%;text-align: center;">
        {{ $list->links() }}
    </div>
@endsection

