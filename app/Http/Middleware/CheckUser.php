<?php

namespace App\Http\Middleware;

use App\Http\Model\Category;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(session("config") == "" || $request->has("update")){
            $config = DB::table("param_config")->where("status",0)->get();
            $configArr = array();
            foreach ($config as $v){
                $configArr[$v->key] = $v->value;
            }
            session(["config"=>$configArr]);
            $menu = Category::getCategory();
            session(["menu"=>$menu]);
        }
        if(session("config.webStop") == "yes"){
            return redirect()->route("error",["msg"=>"抱歉！网站暂时停止访问。"]);
        }
        return $next($request);
    }
}
