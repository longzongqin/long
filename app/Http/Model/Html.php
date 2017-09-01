<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2017/7/23
 * Time: 下午5:47
 */
namespace App\Http\Model;

use Illuminate\Support\Facades\DB;

class Html
{

  public static function index(){
      $path = base_path()."/../";
      $file = $path."index.html";
      if(is_file($file)){
          unlink($file);
      }
      $html  = file_get_contents(url("/"));
      $result = file_put_contents($file,$html);
      if($result){
          return ["info"=>"首页已创建！","status"=>1];
      }else{
          return ["info"=>"首页创建失败！","status"=>0];
      }
  }

  public static function list(){
      $category = DB::table("category_info")->where("status","!=",-1)->whereIn("type",[0,1])->get();
      $fail = 0;
      $success = 0;
      foreach ($category as $v){
          $path = base_path()."/../l/";
          $file = $path.$v->categoryID.".html";
          if(is_file($file)){
              unlink($file);
          }
          if($v->type == 1){
              $html  = file_get_contents(url("/listArticle/".$v->categoryID));
          }else{
              $html  = file_get_contents(url("/list/".$v->categoryID));
          }
          $result = file_put_contents($file,$html);
          self::updateListPage($v->categoryID);
          if($result){
              $success++;
          }else{
              $fail++;
          }
      }
      return ["info"=>"列表页创建成功".$success."条，失败".$fail."条。","status"=>1];
  }

  public static function updateListPage($categoryID){
      $count = Article::getArticle(1,0,$categoryID);
      if($count <= 20){
          return true;
      }
      $page = ceil($count / 20);
      for($i = 2; $i <= $page; $i++){
          $path = base_path()."/../l/";
          $file = $path.$categoryID."_".$i.".html";
          if(is_file($file)){
              unlink($file);
          }
          $html  = file_get_contents(url("/list/".$categoryID."?page=".$i));
          $result = file_put_contents($file,$html);
      }
      return true;
  }

  public static function updateArticleList($id){
      $path = base_path()."/../l/";
      $file = $path.$id.".html";
      if(is_file($file)){
          unlink($file);
      }
      $html  = file_get_contents(url("/listArticle/".$id));
      $result = file_put_contents($file,$html);
      if($result){
          return ["info"=>"首页已创建！","status"=>1];
      }else{
          return ["info"=>"首页创建失败！","status"=>0];
      }
  }

  public static function article(){
      $article = DB::table("article_info")->where("status",0)->select("articleID")->get();
      $fail = 0;
      $success = 0;
      foreach ($article as $v){
          $path = base_path()."/../a/";
          $file = $path.$v->articleID.".html";
          if(is_file($file)){
              unlink($file);
          }
          $html  = file_get_contents(url("/article/".$v->articleID));
          $result = file_put_contents($file,$html);
          if($result){
              $success++;
          }else{
              $fail++;
          }
      }
      return ["info"=>"文章创建成功".$success."条，失败".$fail."条。","status"=>1];
  }

  public static function updateArticle($articleID){
      $article = DB::table("article_info")
          ->where("articleID",$articleID)
          ->leftJoin("category_info","category_info.categoryID","=","article_info.categoryID")
          ->select("article_info.articleID","article_info.categoryID","category_info.parent")
          ->first();

      if($article->parent > 0){
          //更新顶级列表
          $path = base_path()."/../l/";
          $file = $path.$article->parent.".html";
          if(is_file($file)){
              unlink($file);
          }
          $html  = file_get_contents(url("/list/".$article->parent));
          $result = file_put_contents($file,$html);
          self::updateListPage($article->parent);
      }

      //更新列表
      $path = base_path()."/../l/";
      $file = $path.$article->categoryID.".html";
      if(is_file($file)){
          unlink($file);
      }
      $html  = file_get_contents(url("/list/".$article->categoryID));
      $result = file_put_contents($file,$html);
      self::updateListPage($article->categoryID);


      //更新文章
      $path = base_path()."/../a/";
      $file = $path.$article->articleID.".html";
      if(is_file($file)){
          unlink($file);
      }
      $html  = file_get_contents(url("/article/".$article->articleID));
      $result = file_put_contents($file,$html);
      if($result){
          return ["info"=>"文章已更新！","status"=>1];
      }else{
          return ["info"=>"操作失败！","status"=>0];
      }
  }

}