@extends('common.app')

@section('title')
@endsection


@section('head')
    <style>
        #J_prismPlayer{
           width: 100% !important;
            height: 100% !important;
        }
        .prism-controlbar{
            display: none;
        }
        .prism-controlbar-bg{
            opacity: 0.5;
        }
        .prism-player .prism-time-display{
            color: white !important;
        }
        .prism-player .prism-progress{
            height: 2px !important;
            margin-top: 11px !important;
        }
        .prism-player .prism-progress .prism-progress-cursor{
            margin-top: -3px !important;
        }
        .prism-player .prism-big-play-btn{
            left: 50% !important;
            margin-left: -45px !important;
            top: 50% !important;
            margin-top: -45px !important;
            opacity: 0;
        }

        #videoDiv{

        }
    </style>
    <script>
        $(function(){
            $("#category-0").addClass("active");
            $.ajax({
                type: "POST",
                url: "{{ url('addLog') }}",
                data: {"type":0,"typeID":0},
                dataType:'json',
                success: function(data){
                }
            });
        });

    </script>
@endsection

@section('body')

@endsection
@section('footer')
    @include('common.snow')
@endsection


