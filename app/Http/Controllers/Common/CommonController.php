<?php

namespace App\Http\Controllers\Common;



use App\Http\Controllers\Controller;
use App\Http\Utils\Oss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{

    public function error(Request $request){
        return view('app.error',['msg'=>$request->input("msg")]);
    }

    public function getOssConfig(Request $request){
        $result = Oss::getConfig('video');
        echo $result;
    }

    public function saveVideoUrl(Request $request){
        $add["url"] = $request->input("url");
        $add["userID"] = 0;
        $add["estTime"] = time();
        $add["status"] = 0;
        DB::table("video_info")->insert($add);
        return response()->json(['status'=>1]);
    }
}
