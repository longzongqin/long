<?php
namespace App\Http\Controllers\App;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Http\Utils\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header("Content-Type: text/html;charset=utf-8");

class IndexController extends Controller {

    public function index(){
        return view('app.index');
    }

    public function list(Request $request,$id){
        $html = base_path()."/../l/".$id.".html";
        $url = url("/l")."/".$id.".html";
        if($request->has("page") && $request->input("page") > 1){
            $html = base_path()."/../l/".$id."_".$request->input("page").".html";
            $url = url("/l")."/".$id."_".$request->input("page").".html";
        }
        if(session("config.useStatic") == "yes" && is_file($html)){
            return redirect($url);
        }else{
            $category = Category::getNextCategory($id,1);
            $category[] = $id;
            $article = DB::table("article_info")->whereIn("categoryID",$category)->orderByDesc("updateTime")->paginate(20);
            return view('app.list',["id"=>$id,"list"=>$article]);
        }
    }

    public function listArticle($id){
        $html = base_path()."/../l/".$id.".html";
        if(session("config.useStatic") == "yes" && is_file($html)){
            return redirect(url("/l")."/".$id.".html");
        }else {
            $article = DB::table("category_article")
                ->where("category_article.categoryID", $id)
                ->leftJoin("category_info", "category_info.categoryID", "=", "category_article.categoryID")
                ->select("category_article.*", "category_info.name")
                ->first();
            if (empty($article)) {
                return view("app.index");
            }
            return view('app.listArticle', ["article" => $article]);
        }
    }

    public function article($id){
        $html = base_path()."/../a/".$id.".html";
        if(session("config.useStatic") == "yes" && is_file($html)){
            return redirect(url("/a")."/".$id.".html");
        }else {
            $article = DB::table("article_info")->where("articleID", $id)->first();
            return view('app.article', ["article" => $article]);
        }
    }

    public function search(){
        return view('app.search');
    }

    public function doSearch(Request $request){
        $result = DB::table("article_info")
            ->where("status",0)
            ->where("title","like","%".$request->input("key")."%")
            ->select("imgUrl","articleID","title")
            ->get();
        if($result->isEmpty()){
            return response()->json(["data"=>"","info"=>"没有找到数据！","status"=>0]);
        }else{
            return response()->json(["data"=>$result,"info"=>"找到数据！","status"=>1]);
        }

    }

    public function addLog(Request $request){
        Common::async(url("async/addLog"),"ip=".$request->getClientIp()."&type=".$request->input("type")."&typeID=".$request->input("typeID"));
        return response()->json(["status"=>1]);
    }

}