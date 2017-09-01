<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2017/7/23
 * Time: 下午5:47
 */
namespace App\Http\Model;

use Illuminate\Support\Facades\DB;

class Article
{

    /**
     * 获取文章
     * @param int $isCount
     * @param int $page
     * @param int $categoryID
     * @return \Illuminate\Support\Collection
     */
    public static function getArticle($isCount=0,$page=0,$categoryID=0){
        $article = DB::table("article_info");
        $article->where("status",0);
        if($categoryID != 0){
            $categoryInfo = DB::table("category_info")->where("categoryID",$categoryID)->first();
            if($categoryInfo->parent > 0){
                $article->where("categoryID",$categoryID);
            }else{
                $nextIDs = Category::getNextCategory($categoryID,1);
                $nextIDs[] = $categoryID;
                $article->whereIn("categoryID",$nextIDs);
            }
        }
        if($isCount == 1){
            return $article->count();
        }
        $article->orderByDesc("updateTime");
        $article->offset($page * 20);
        $article->limit(20);
        $article->select("articleID","title","imgUrl","updateTime");
        return $article->get();
    }
}