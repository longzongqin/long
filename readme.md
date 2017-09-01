本博客使用PHP的Laravel框架开发，前端框架使用了Bootstrap，做了电脑、pad、手机的屏幕适配。<br>
也使用了现在比较火的Vue，评论则使用了搜狐的畅言。<br>
图片跟视频存储使用的是阿里云OSS<br>
<br>
需要修改配置如下：（需要更换掉出现***********的地方）<br>
    1、找到项目中long.sql文件，这是数据库结构，有一些测试数据<br>
    2、找到.env文件，配置数据库连接，并配置自己阿里云OSS连接<br>
    3、找到app\Http\Utils\Oss.php，更换自己OSS的对应配置<br>
    4、找到resources\views\common\comment.blade.php，更换自己的畅言账号配置<br>
    <br>
博客展示<a href="http://longzongqin.cn">longzongqin.cn</a>    
