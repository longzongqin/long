<?php
namespace App\Http\Controllers\Common;


use App\Http\Controllers\Controller;
use App\Http\Model\Html;
use App\Http\Utils\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header("Content-Type: text/html;charset=utf-8");

class AsyncController extends Controller {

    public function updateArticleHtml(Request $request){
        ignore_user_abort(true);
        $result = Html::updateArticle($request->input("articleID"));
        dump($result);
    }

    public function addLog(Request $request){
        ignore_user_abort(true);
        if($request->input("ip") != "127.0.0.1"){
            $result = Common::getIpLookup($request->input("ip"));
            $add["ip"] = $request->input("ip");
            $add["type"] = $request->input("type");
            $add["typeID"] = $request->input("typeID");
            $add["time"] = date("Y-m-d H:i:s");
            if($request){
                $add["country"] = $result["country"];
                $add["province"] = $result["province"];
                $add["city"] = $result["city"];
                $add["district"] = $result["district"];
            }
            DB::table("log_info")->insertGetId($add);
            dump($add);
        }
    }
}