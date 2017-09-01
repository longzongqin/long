<?php
namespace App\Http\Utils;


use DateTime;
use OSS\OssClient;

class Oss{

    const endpoint = "http://oss-cn-hangzhou.aliyuncs.com";
    const accessKeyId = "***********";
    const accessKeySecret = "***********";
    const bucket = "***********";
    const project = "***********";
    const host = 'http://***********.oss-cn-hangzhou.aliyuncs.com';
    const backUrl = 'http://oss-demo.aliyuncs.com:23450';
    const ossUrl = 'http://***********/';


    public static function getConfig($type='',$userID=0){
        $id= self::accessKeyId;
        $key= self::accessKeySecret;
        $host = self::host;
        $callbackUrl = self::backUrl;
        $project = self::project;

        $callback_param = array('callbackUrl'=>$callbackUrl,
            'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}',
            'callbackBodyType'=>"application/x-www-form-urlencoded");
        $callback_string = json_encode($callback_param);

        $base64_callback_body = base64_encode($callback_string);
        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = Oss::gmt_iso8601($end);

        $dir = $project."/".$type."/".date("Y/m")."/";

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        if($userID == 0){
            $userID = rand(10000,90000);
        }
        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        $response['callback'] = $base64_callback_body;
        $response['name'] = time()."_".$userID;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return json_encode($response);
    }

    public static function getOssClient(){
        try {
            $ossClient = new OssClient(self::accessKeyId, self::accessKeySecret, self::endpoint, false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    /**上传base64图片
     * @param $base64Img base64图片
     * @param $suffix 后缀
     * @param $userID
     * @return mixed
     */
    public static function putBase64Img($base64Img, $suffix,$userID=0){
        if($userID == 0){
            $userID = rand(10000,90000);
        }
        $time = time();
        $object = self::project."/image/".date("Y/m")."/".$time."-".$userID."-".Common::getRandChar(4).".".$suffix;

        $return["status"] = 1;
        $return["info"] = self::ossUrl.$object;

        try{
            Oss::getOssClient()->putObject(self::bucket, $object, base64_decode(substr(strstr($base64Img,','),1)));
        } catch(OssException $e) {
            $return["status"] = 0;
            $return["info"] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 上传远程图片
     * @param $url
     * @param $userID
     * @return mixed
     */
    public static function putImageUrl($url,$userID=0){
        if($userID == 0){
            $userID = rand(10000,90000);
        }
        $time = time();
        $suffixArr = explode(".",$url);
        $arr = array("jpeg","jpg","png","gif");
        if(in_array($suffixArr[count($suffixArr) - 1],$arr)){
            $suffix = $suffixArr[count($suffixArr) - 1];
        }else{
            $suffix = "jpg";
        }
        $object = self::project."/image/".date("Y/m")."/".$time."-".$userID."-".Common::getRandChar(4).".".$suffix;
        $return["status"] = 1;
        $return["info"] = self::ossUrl.$object;

        $imgData = Common::curl_img($url);
        try{
            Oss::getOssClient()->putObject(self::bucket, $object, $imgData);
        } catch(OssException $e) {
            $return["status"] = 0;
            $return["info"] = $e->getMessage();
        }
        return $return;
    }

    public static function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }

}
