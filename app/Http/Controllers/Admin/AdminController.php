<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Html;
use App\Http\Utils\Common;
use App\Http\Utils\Oss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header("Content-Type: text/html;charset=utf-8");

class AdminController extends Controller {

    public function index(){
        return view('admin.index');
    }

    public function category(){
        $category = Category::getCategory();
        return view('admin.category',["category"=>$category]);
    }

    public function article(){
        $category = Category::getCategory();
        $article = Article::getArticle();
        $articleCount = Article::getArticle(1);
        return view('admin.article',["category"=>$category,"data"=>$article,"articleCount"=>$articleCount]);
    }

    public function loadArticle(Request $request){
        $article = Article::getArticle(0,$request->input("pageNum"),$request->input("categoryID"));
        $articleCount = Article::getArticle(1,$request->input("pageNum"),$request->input("categoryID"));
        return response()->json(["data"=>$article,"info"=>$articleCount,"status"=>1]);
    }

    public function addArticle(Request $request){
        $articleInfo = "";
        $content = "";
        $articleID = 0;
        if($request->has("articleID")){
            $articleInfo = DB::table("article_info")->where("articleID",$request->input("articleID"))->first();
            $articleInfo->cateArr = Category::getCategoryLine($articleInfo->categoryID);
            $articleID = $request->input("articleID");
            $content = $articleInfo->content;
            $articleInfo->content = "";
        }
        $category = Category::getCategory();
        return view('admin.addArticle',["category"=>$category,"article"=>$articleInfo,"content"=>$content,"articleID"=>$articleID]);
    }

    public function addCategory(Request $request){
        $add["name"] = $request->input("name");
        $add["sort"] = $request->input("sort");
        $add["url"] = $request->input("url");
        $add["style"] = $request->input("style");
        $add["type"] = $request->input("type");
        $add["status"] = $request->input("status");
        $add["parent"] = $request->input("parent");
        $categoryID = DB::table("category_info")->insertGetId($add);
        if($categoryID){
            return response()->json(["info"=>"添加成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"添加失败！","status"=>0]);
        }
    }
    public function modifyCategory(Request $request){
        $update["name"] = $request->input("name");
        $update["sort"] = $request->input("sort");
        $update["url"] = $request->input("url");
        $update["style"] = $request->input("style");
        $update["type"] = $request->input("type");
        $update["status"] = $request->input("status");
        $result = DB::table("category_info")->where("categoryID",$request->input("categoryID"))->update($update);
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function moveCategory(Request $request){
        $result = DB::table("category_info")->where("categoryID",$request->input("categoryID"))->update(["parent"=>$request->input("parent")]);
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function delCategory(Request $request){
        if($request->input("parent") == 0){
            $sub = DB::table("category_info")->where("parent",$request->input("categoryID"))->get();
            if($sub->isNotEmpty()){
                return response()->json(["info"=>"请先删除或移动子类！","status"=>0]);
            }
        }
        $article = DB::table("article_info")->where("categoryID",$request->input("categoryID"))->get();
        if($article->isNotEmpty()){
            return response()->json(["info"=>"请先删除或移动栏目下的文章！","status"=>0]);
        }

        $update["status"] = -1;
        $result = DB::table("category_info")->where("categoryID",$request->input("categoryID"))->update($update);
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function param(){
        $result = DB::table("param_config")->where("status",0)->orderBy("sort")->get();
        return view("admin.param",["data"=>$result]);
    }

    public function saveParam(Request $request){
        $add["plain"] = $request->input("plain");
        $add["key"] = $request->input("key");
        $add["value"] = $request->input("value");
        $add["sort"] = $request->input("sort");
        $add["status"] = 0;
        if($request->input("configID") == 0){
            $result = DB::table("param_config")->insertGetId($add);
        }else{
            $result = DB::table("param_config")->where("configID",$request->input("configID"))->update($add);
        }
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function delParam(Request $request){
        $update["status"] = 1;
        $result = DB::table("param_config")->where("configID",$request->input("configID"))->update($update);
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }
    public function updateStyle(Request $request){
        $update["value"] = $request->input("style");
        $result = DB::table("param_config")->where("key","adminStyle")->update($update);
        if($result){
            session(["adminStyle"=>$request->input("style")]);
            return response()->json(["info"=>"风格已更改！","status"=>1]);
        }else{
            return response()->json(["info"=>"风格未更改！","status"=>0]);
        }
    }

    public function doAddArticle(Request $request){
        $articleID = $request->input("articleID");
        if(!empty($request->input("videoUrl"))){
            $add["imgUrl"] = getVideoImg($request->input("videoUrl"));
        }
        if(!empty($request->input("base64")) || !empty($request->input("imgUrl"))){
            if($request->input("isDefaultImg") == 0){
                $add["imgUrl"] = $request->input("imgUrl");
            }else{
                $result = Oss::putBase64Img($request->input("base64"),$request->input("suffix"));
                if($result["status"] == 0){
                    return response()->json(['info'=>$result["info"],'status'=>0]);
                }else{
                    $add["imgUrl"] = $result["info"];
                }
            }
        }

        $add["videoUrl"] = $request->input("videoUrl");
        $add["title"] = $request->input("title");
        $add["categoryID"] = $request->input("categoryID");
        $add["content"] = $request->input("content");
        $add["updateTime"] = time();
        if($articleID == 0){
            $add["createTime"] = time();
            $add["sourceID"] = "longblog".time();
            $result = DB::table("article_info")->insertGetId($add);
            $articleID = $result;
        }else{
            $result = DB::table("article_info")->where("articleID",$request->input("articleID"))->update($add);
        }

        if($result){
            Common::async(url("/async/updateArticleHtml"),"articleID=".$articleID);
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function delArticle(Request $request){
        $update["status"] = 1;
        $result = DB::table("article_info")->where("articleID",$request->input("articleID"))->update($update);
        if($result){
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function categoryArticle($id){
        $categoryInfo = DB::table("category_info")->where("categoryID",$id)->first();
        if(empty($categoryInfo)){
            return view('admin.error',["msg"=>"参数错误！"]);
        }
        $caID = 0;
        $content = "";
        $caInfo = DB::table("category_article")->where("categoryID",$id)->first();
        if(!empty($caInfo)){
            $caID = $caInfo->caID;
            $content = $caInfo->content;
        }
        return view('admin.categoryArticle',["category"=>$categoryInfo,"caID"=>$caID,'content'=>$content]);
    }

    public function saveCategoryArticle(Request $request){
        if($request->input("caID") == 0){
            $add["categoryID"] = $request->input("categoryID");
            $add["content"] = $request->input("content");
            $result = DB::table("category_article")->insertGetId($add);
        }else{
            $update["content"] = $request->input("content");
            $result = DB::table("category_article")->where("caID",$request->input("caID"))->update($update);
        }
        if($result){
            Html::updateArticleList($request->input("categoryID"));
            return response()->json(["info"=>"操作成功！","status"=>1]);
        }else{
            return response()->json(["info"=>"操作失败！","status"=>0]);
        }
    }

    public function createHtml(){
        return view("admin.createHtml");
    }

    public function doCreateHtml(Request $request){
        switch ($request->input("type")){
            case 0:
                $result = Html::index();
                break;
            case 1:
                $result = Html::list();
                break;
            case 2:
                $result = Html::article();
                break;
        }
        return response()->json($result);
    }

}