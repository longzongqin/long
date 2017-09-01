<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2017/7/23
 * Time: 下午5:47
 */
namespace App\Http\Model;

use App\Http\Utils\Tree;
use Illuminate\Support\Facades\DB;

class Category
{
    /**
     * 获取分类树
     * @return array
     */
    public static function getCategory(){
        $categoryInfo = DB::table("category_info")->where("status","!=",-1)->orderBy("sort")->get();
        $tree = new Tree("categoryID","parent");
        $tree->load(json_decode(json_encode($categoryInfo),true));
        return $tree->DeepTree();
    }

    /**
     * 获取下级分类
     * @param int $categoryID
     * @param int $isAll
     * @return array
     */
    public static function getNextCategory($categoryID=0,$isAll=0){
        $categoryInfo = DB::table("category_info")
            ->where("status","!=",-1)
            ->where("parent",$categoryID)
            ->orderBy("sort")
            ->get();
        if($isAll == 0){
           return $categoryInfo;
        }else{
            $idArr = array();
            foreach ($categoryInfo as $v) {
                $idArr[] = $v->categoryID;
            }
            return $idArr;
        }
    }

    public static function getCategoryLine($categoryID=0){
            $categoryInfo = DB::table("category_info")->where("categoryID",$categoryID)->first();
            $cateArr = array();
            $categoryInfo = json_decode(json_encode($categoryInfo),true);
            if($categoryInfo["parent"] != 0){
                $parentCategory = DB::table("category_info")->where("categoryID",$categoryInfo["parent"])->first();
                $cateArr[] = $parentCategory;
            }
            $cateArr[] = $categoryInfo;
            return $cateArr;
    }
}