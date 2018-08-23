<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Model\Category;
use App\Http\Utils\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

header("Content-Type: text/html;charset=utf-8");

class ApiController extends Controller {
    /**
     * @api {get/post} /category 获取文章分类
     * @apiDescription 获取文章分类，包含两级分类
     * @apiGroup blog
     * @apiVersion 1.0.0
     * @apiSuccess {Array} data 数据
     * @apiSuccess {String} info 提示信息
     * @apiSuccess {number} status 状态：0失败，1成功
     * @apiSuccess {number} categoryID 分类ID
     * @apiSuccess {String} name 分类名称
     * @apiSuccess {number} parent 上级分类
     * @apiSuccessExample {json} 正确返回值:
     * {"data": [{"categoryID": 1,"name": "程序日记","parent": 0,"children": [{"categoryID": 5,"name": "PHP","parent": 1}]}],"info": "找到数据！","status": 1}
     */
    public function category(Request $request){
        $result = DB::table("category_info")
            ->where("status",0)
            ->where("parent",0)
            ->select("categoryID","name","parent")
            ->get();
        foreach ($result as $k=>$v){
            $result[$k]->children = DB::table("category_info")
                ->where("status",0)
                ->where("parent",$v->categoryID)
                ->select("categoryID","name","parent")
                ->get();
        }
        return response()->json(["data"=>$result,"info"=>"找到数据！","status"=>1]);
    }

    /**
     * @api {get/post} /search 搜索文章
     * @apiDescription 根据关键字搜索文章
     * @apiGroup blog
     * @apiParam {String} key 关键字
     * @apiVersion 1.0.0
     * @apiSuccess {Array} data 数据
     * @apiSuccess {String} info 提示信息
     * @apiSuccess {number} status 状态：0失败，1成功
     * @apiSuccess {number} articleID 文章ID
     * @apiSuccess {String} imgUrl 封面
     * @apiSuccess {String} title 标题
     * @apiErrorExample {json} 错误返回值:
     *    {"data":"","info":"缺少搜索关键字","status":0}
     * @apiSuccessExample {json} 正确返回值:
     *    {"data":[{"imgUrl":"http:\/\/oss.longzongqin.cn\/long\/default-img\/linux.jpg","articleID":55,"title":"contos\u4e0a\u642d\u5efagit\u670d\u52a1\u5668"}],"info":"\u627e\u5230\u6570\u636e\uff01","status":1}
     */
    public function search(Request $request){
        if($request->has("key") && !empty($request->input("key"))){
            $result = DB::table("article_info")
                ->where("status",0)
                ->where("title","like","%".$request->input("key")."%")
                ->select("imgUrl","articleID","title")
                ->get();
            if($result->isEmpty()){
                return response()->json(["data"=>"","info"=>"没有找到数据","status"=>0]);
            }else{
                return response()->json(["data"=>$result,"info"=>"找到数据","status"=>1]);
            }
        }else{
            return response()->json(["data"=>"","info"=>"缺少搜索关键字","status"=>0]);
        }

    }


    /**
     * @api {get/post} /article 获取文章列表
     * @apiDescription 获取文章列表
     * @apiGroup blog
     * @apiParam {number} [category] 所属分类
     * @apiParam {number} [page] 页数
     * @apiParam {number} [pageCount] 每页条数，默认20条
     * @apiVersion 1.0.0
     * @apiSuccess {Array} data 数据
     * @apiSuccess {String} info 提示信息
     * @apiSuccess {number} status 状态：0失败，1成功
     * @apiSuccess {number} articleID 文章ID
     * @apiSuccess {String} imgUrl 封面
     * @apiSuccess {String} title 标题
     * @apiErrorExample {json} 错误返回值:
     *    {"data":"","info":"没有找到数据","status":0}
     * @apiSuccessExample {json} 正确返回值:
     *    {"data":{"current_page":1,"data":[{"imgUrl":"http:\/\/video.longzongqin.cn\/long\/video\/2017\/07\/1501509321_17317_8RfZ.jpg","articleID":2,"title":"\u6700\u521d\u7684\u68a6\u60f3"}],"from":1,"last_page":2,"next_page_url":"http:\/\/localhost\/long\/api\/article?page=2","path":"http:\/\/localhost\/long\/api\/article","per_page":"20","prev_page_url":null,"to":20,"total":43},"info":"\u627e\u5230\u6570\u636e","status":1}
     */
    public function article(Request $request){
        $article = DB::table("article_info");
        if($request->has("category")){
            $article->where("categoryID",$request->input("category"));
        }
        $article->where("status",0);
        $article->select("imgUrl","articleID","title");
        $pageCount = 20;
        if($request->has("pageCount")){
            $pageCount = $request->input("pageCount");
        }
        $result = $article->paginate($pageCount);
        if($result->isEmpty()){
            return response()->json(["data"=>"","info"=>"没有找到数据","status"=>0]);
        }else{
            return response()->json(["data"=>$result,"info"=>"找到数据","status"=>1]);
        }
    }

    /**
     * @api {get/post} /articleDetail 获取文章详情
     * @apiDescription 获取文章详情
     * @apiGroup blog
     * @apiParam {number} id 文章ID
     * @apiVersion 1.0.0
     * @apiSuccess {Array} data 数据
     * @apiSuccess {String} info 提示信息
     * @apiSuccess {number} status 状态：0失败，1成功
     * @apiSuccess {number} articleID 文章ID
     * @apiSuccess {String} imgUrl 封面
     * @apiSuccess {String} title 标题
     * @apiErrorExample {json} 错误返回值:
     *    {"data":"","info":"没有找到数据","status":0}
     * @apiSuccessExample {json} 正确返回值:
     * {
     *   "data": {
     *   "articleID": 1,
     *   "title": "新版博客上线了",
     *   "content": "<p>今天是7月的最后一天，这篇文章的发出就标志着这一版博客正式上线了！<br\/><\/p>",
     *   "status": 0,
     *   "categoryID": 2,
     *   "sourceID": "longblog1501506466",
     *   "imgUrl": "http:\/\/video.longzongqin.cn\/long\/video\/2017\/07\/1501503547_54188_4NtJ.jpg",
     *   "videoUrl": "http:\/\/oss.longzongqin.cn\/long\/video\/2017\/07\/1501503547_54188_4NtJ.mp4",
     *   "createTime": 1501506466,
     *   "updateTime": 1501506466
     *   },
     *   "info": "找到数据",
     *   "status": 1
     *   }
     */
    public function articleDetail(Request $request){
        $article = DB::table("article_info")->where("status",0)->where("articleID",$request->input("id"))->first();
        if(empty($article)){
            return response()->json(["data"=>"","info"=>"没有找到数据","status"=>0]);
        }else{
            return response()->json(["data"=>$article,"info"=>"找到数据","status"=>1]);
        }
    }


}