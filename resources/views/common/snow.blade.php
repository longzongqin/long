
    <script src="{{ publicPath() }}js/jquery.let_it_snow.js" type="text/javascript"></script>
    <style>
        .wrapper {
            height: auto !important;
            height: 100%;
            margin: 0 auto;
            overflow: hidden;
        }

        a {
            text-decoration: none;
        }


        h1, h2 {
            width: 100%;
            float: left;
        }
        h1 {
            margin-top: 100px;
            color: #1D3185;
            text-shadow: 0 1px 5px rgba(0,0,0,0.5);
            margin-bottom: 5px;
            font-size: 70px;
            letter-spacing: -4px;
        }
        h2 {
            color: #3C487A;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .pointer {
            position: fixed;
            bottom: 10px;
            left: 50%;
            margin-left: -245px;
            color: #2744BE;
            font-family: 'Open Sans', cursive;
            font-weight: 400;
            font-style: italic;
            font-size: 14px;
            margin-top: 15px;
        }
        pre {
            margin: 80px auto;
        }
        pre code {
            padding: 35px;
            border-radius: 5px;
            font-size: 15px;
            background: rgba(0,0,0,0.1);
            border: rgba(0,0,0,0.05) 5px solid;
            max-width: 500px;
        }


        .main {
            float: left;
            width: 100%;
            margin: 0 auto;
        }


        .main h1 {
            padding:20px 50px;
            float: left;
            width: 100%;
            font-size: 60px;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            font-weight: 100;
            margin: 0;
            padding-top: 25px;
            font-family: 'Pacifico';
            letter-spacing: 2px;
        }

        .main h1.demo1 {
            background: #1ABC9C;
        }

        .reload.bell {
            font-size: 12px;
            padding: 20px;
            width: 45px;
            text-align: center;
            height: 47px;
            border-radius: 50px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
        }

        .reload.bell #notification {
            font-size: 25px;
            line-height: 140%;
        }

        .reload, .btn{
            display: inline-block;
            border: 4px solid #A2261E;
            border-radius: 5px;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            background: #CC3126;
            display: inline-block;
            line-height: 100%;
            padding: 0.7em;
            text-decoration: none;
            color: #2744BE;
            width: 100px;
            line-height: 140%;
            font-size: 17px;
            font-family: open sans;
            font-weight: bold;
        }
        .reload:hover{
            background: #A2261E;
        }
        .btn {
            width: 200px;
            color: #2744BE;
            border: none;
            margin-left: 10px;
            background: rgba(0, 0, 0, 0.31);
        }
        .clear {
            width: auto;
        }
        .btn:hover, .btn:hover {
            background: rgba(0,0,0,0.5);
        }
        .btns {
            width: 410px;
            margin: 50px auto;
        }
        .credit {
            font-style: italic;
            text-align: center;
            color: #1D3185;
            padding: 10px;
            margin: 0 0 40px 0;
            float: left;
            width: 100%;
        }

        .pointer a {
            color: #2744BE;
            text-decoration: none;
            font-weight: bold;
        }

        .credit a {
            color: #2744BE;
            text-decoration: none;
            font-weight: bold;
        }

        .back {
            position: absolute;
            top: 0;
            left: 0;
            text-align: center;
            display: block;
            padding: 7px;
            width: 100%;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            background: rgba(0, 0, 0, 0.35);
            font-weight: bold;
            font-size: 13px;
            color: #2744BE;
            -webkit-transition: all 200ms ease-out;
            -moz-transition: all 200ms ease-out;
            -o-transition: all 200ms ease-out;
            transition: all 200ms ease-out;
        }
        .back:hover {
            background: rgba(0, 0, 0, 0.85);
        }
        canvas {
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
        }
        .header {
            position: relative;
        }
        canvas.flare {
            opacity: 0.5;
        }
        #snowDiv{
            margin-top: -20px;
        }
    </style>
    <script>
        var now_setting = 1;
        var bg = 1;
        var autoChange = "";
        var setting0 = new Array(10,5,0,10,5,0,10,10,0);
        var setting1 = new Array(10,5,0,10,5,500,5,5,50);
        var setting2 = new Array(500,5,0,20,10,1500,10,10,80);
        var setting3 = new Array(900,5,2,30,15,3000,20,20,120);
        var setting = new Array(setting0,setting1,setting2,setting3);

        if(document.addEventListener){//如果是Firefox
            document.addEventListener("keypress",keyHandler, true);
        }else{
            document.attachEvent("onkeypress",keyHandler);
        }

        function keyHandler(evt){
            console.log(evt);
            if(evt.charCode == 45 || evt.keyCode == 45){
                if(now_setting != 0){
                    now_setting--;
                    location.href="{{ url('/') }}?s="+now_setting;
                }
            }
            if(evt.charCode == 61 || evt.keyCode == 61){
                if(now_setting != 3){
                    now_setting++;
                    location.href="{{ url('/') }}?s="+now_setting;
                }
            }

            if(evt.charCode == 13 || evt.keyCode == 13){
                changeBg();
            }
        }
        $(document).ready( function() {
            if($_GET["s"] == 0 || $_GET["s"] == 1 || $_GET["s"] == 2 || $_GET["s"] == 3){
                init(setting[$_GET["s"]]);
                now_setting = $_GET["s"];
            }else{
                init(setting[1]);
                now_setting = 1;
            }

            autoChange = setInterval(function(){
                    changeBg();
            },5000);
        });
        function init(s){
            $("canvas.flare").let_it_snow({
                windPower: s[0],
                speed: s[1],
                color: "#392F52",
                size: 80,
                opacity: 0.00000001,
                count: s[2],
                interaction: false
            });
            $("canvas.snow").let_it_snow({
                windPower: s[3],
                speed: s[4],
                count: s[5],
                size: 0,
            });
            $("canvas.flake").let_it_snow({
                windPower: s[6],
                speed: s[7],
                count: s[8],
                size: 5,
                image: "{{ publicPath() }}img/white-snowflake.png"
            });
        }


        var $_GET = (function(){
            var url = window.document.location.href.toString();
            var u = url.split("?");
            if(typeof(u[1]) == "string"){
                u = u[1].split("&");
                var get = {};
                for(var i in u){
                    var j = u[i].split("=");
                    get[j[0]] = j[1];
                }
                return get;
            } else {
                return {};
            }
        })();

        function changeBg(){
            bg++;
            if(bg > 10){
                bg = 1;
            }
            $("#snowPc").attr("src","{{ publicPath() }}welcome/"+bg+".jpg");
            $("#snowPhone").attr("src","{{ publicPath() }}welcome/p"+bg+".jpg");
        }
        function divClick(){
            changeBg();
            clearInterval(autoChange);
        }
    </script>
<div id="snowDiv" onclick="divClick();">
    <img src="{{ publicPath() }}welcome/p1.jpg" id="snowPhone" class="visible-xs-block visible-sm-block" width="100%">
    <img src="{{ publicPath() }}welcome/1.jpg" id="snowPc" class="visible-md-block visible-lg-block" width="100%">
    <canvas width="100%" height="100%" class="flare"></canvas>
    <canvas width="100%" height="100%" class="snow"></canvas>
    <canvas width="100%" height="100%" class="flake"></canvas>
</div>

