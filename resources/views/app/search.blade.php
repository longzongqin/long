@extends('common.app')

@section('title')搜索-@endsection


@section('head')
    <style>
        #search{
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin: 0px;
        }
        #result{
            background: white;
            border-radius: 5px;
            padding: 5px 0px;
            margin-top: 20px;
            display: none;
            margin-bottom: 90px;
        }
        #result > div:last-child{
            border-bottom: none !important;
        }
        .result{
            position: relative;
            border-bottom: 1px solid gainsboro;
            padding: 5px 0px;
        }
        .result:hover{
            background: blueviolet;
            color: white;
        }
        .result > div:first-child{
            width: 64px;
            margin: 5px 10px;

        }
        .result >div:last-child{
            float: right;
            position: absolute;
            top: 5px;
            right: 10px;
            left: 80px;
            vertical-align: middle;
            height: 52px;
            padding: 5px 10px;
        }
    </style>

@endsection

@section('body')
    <div id="search" class="row">
        <div class="col-xs-8">
            <input class="form-control" placeholder="请输入关键字" id="key" type="text">
        </div>
        <div class="col-xs-4">
            <button class="btn btn-default" onclick="search();">搜索</button>
        </div>
    </div>

    <div id="result">
        <div v-for="m in content" class="result" @click="go(m.articleID)">
            <div>
                <img :src="m.imgUrl+'?x-oss-process=image/resize,m_fill,h_200,w_300'" onerror="defaultImg(this);" width="100%">
            </div>
            <div>
                <p>@{{ m.title }}</p>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="{{ p() }}js/vue.min.js"></script>
    <script>
        $(function(){
            $("#category-search").addClass("active");
            $.ajax({
                type: "POST",
                url: "{{ url('addLog') }}",
                data: {"type":4,"typeID":0},
                dataType:'json',
                success: function(data){
                }
            });
        });

        var app = new Vue({
            el: '#result',
            data:{
                content: ""
            },
            mounted: function(){
            },
            methods:{
                go: function(id){
                    location.href = "{{ url('article') }}/"+id;
                }
            }
        });

        function search(){
            var key = $("#key").val();
            if(key == ""){
                show_msg("请输入关键字！");
                return;
            }
            showLoad();
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('doSearch') }}",
                data: {'key':key},
                dataType:'json',
                success: function(data){
                    hideLoad();
                    if(data.status == 1){
                        app.content = data.data;
                        $("#result").show();
                    }else{
                        $("#result").hide();
                        show_msg(data.info);
                    }

                }
            });
        }
    </script>

    @include('common.adFixed')
@endsection


