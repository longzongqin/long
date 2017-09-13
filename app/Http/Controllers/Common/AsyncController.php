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
        $this->addSiteMap();
    }

    public function addSiteMap(){
        $list = DB::table("category_info")->where("status",0)->get();
        $article = DB::table("article_info")->where("status",0)->get();
        $day = date("Y-m-d");
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset>';
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>站点地图-夜猫站</title>
</head>
<body>';


foreach ($list as $l){
    $xml .= '
    <url>
        <loc>http://www.longzongqin.cn/l/'.$l->categoryID.'.html</loc>
        <priority>1.0</priority>
        <lastmod>'.$day.'</lastmod>
        <changefreq>always</changefreq>
    </url>';
    $html .= '
    <a href="http://www.longzongqin.cn/l/'.$l->categoryID.'.html">'.$l->name.'</a><br>';
        }
        foreach ($article as $a){
            $xml .= '
    <url>
        <loc>http://www.longzongqin.cn/a/'.$a->articleID.'.html</loc>
        <priority>1.0</priority>
        <lastmod>'.$day.'</lastmod>
        <changefreq>always</changefreq>
    </url>';
    $html .= '
    <a href="http://www.longzongqin.cn/a/'.$a->articleID.'.html">'.$a->title.'</a><br>';
    }

$xml .= '
</urlset>';
 $html .= '
</body>
</html>';

        $result = file_put_contents(base_path('/../')."sitemap.xml",$xml);
        echo "xml:".$result;
        $result = file_put_contents(base_path('/../')."sitemap.html",$html);
        echo "<br>html:".$result;
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