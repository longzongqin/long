<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header("Content-Type: text/html;charset=utf-8");

class LoginController extends Controller {

    public function index(){
        return view('admin.login');
    }

    public function doLogin(Request $request){
        $result = DB::table("admin_info")
            ->where("username",$request->input("username"))
            ->where("password",$request->input("password"))
            ->first();
        if(empty($result)){
            return response()->json(["info"=>"用户名或密码错误！","status"=>0]);
        }else{
            if($result->status == 1){
                return response()->json(["info"=>"用户已被禁用！","status"=>0]);

            }else{
                $adminInfo = json_decode(json_encode($result),true);
                session(["adminInfo"=>$adminInfo]);
                $adminStyle = DB::table("param_config")->where("key","adminStyle")->value("value");
                session(["adminStyle"=>$adminStyle]);
                return response()->json(["info"=>"登陆成功！","status"=>1]);
            }
        }
    }
}