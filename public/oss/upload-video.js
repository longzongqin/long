
accessid = ''
accesskey = ''
host = ''
policyBase64 = ''
signature = ''
callbackbody = ''
filename = ''
key = ''
expire = 0
g_object_name = ''
g_object_name_type = 'random_name'
nameStr = ''
now = timestamp = Date.parse(new Date()) / 1000; 

function send_request()
{
    var xmlhttp = null;
    if (window.XMLHttpRequest)
    {
        xmlhttp=new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  
    if (xmlhttp!=null)
    {
        serverUrl = '/long/common/getOssConfig'
        xmlhttp.open( "GET", serverUrl, false );
        xmlhttp.send( {'type':'video'} );
        return xmlhttp.responseText
    }
    else
    {
        alert("Your browser does not support XMLHTTP.");
    }
};

function random_string(len) {
    len = len || 32;
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    var maxPos = chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}

function get_signature()
{
    //可以判断当前expire是否超过了当前时间,如果超过了当前时间,就重新取一下.3s 做为缓冲
    now = timestamp = Date.parse(new Date()) / 1000; 
    if (expire < now + 3)
    {
        body = send_request()
        var obj = eval ("(" + body + ")");
        host = obj['host']
        policyBase64 = obj['policy']
        accessid = obj['accessid']
        signature = obj['signature']
        expire = parseInt(obj['expire'])
        callbackbody = obj['callback']
        nameStr = obj['name']
        key = obj['dir']
        return true;
    }
    return false;
};


function get_suffix(filename) {
    pos = filename.lastIndexOf('.')
    suffix = ''
    if (pos != -1) {
        suffix = filename.substring(pos)
    }
    return suffix;
}

function calculate_object_name(filename){
        suffix = get_suffix(filename)
        g_object_name = key + nameStr + "_" + random_string(4) + suffix

    return ''
}


function set_upload_param(up, filename, ret)
{
    if (ret == false)
    {
        ret = get_signature()
    }
    g_object_name = key;
    if (filename != '') { suffix = get_suffix(filename)
        calculate_object_name(filename)
    }
    new_multipart_params = {
        'key' : g_object_name,
        'policy': policyBase64,
        'OSSAccessKeyId': accessid, 
        'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
        'callback' : callbackbody,
        'signature': signature,
    };

    up.setOption({
        'url': host,
        'multipart_params': new_multipart_params
    });

    up.start();
}

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'selectfiles', 
    multi_selection: false,
	container: document.getElementById('container'),
	flash_swf_url : 'lib/plupload-2.1.2/js/Moxie.swf',
	silverlight_xap_url : 'lib/plupload-2.1.2/js/Moxie.xap',
    url : 'http://oss.aliyuncs.com',

    filters: {
        mime_types : [ //只允许上传视频
        { title : "Video files", extensions : "avi,wmv,mpeg,mp4,mov,mkv,flv,f4v,m4v,rmvb,rm,3gp,dat,ts,mts,vob" }
        ],
        max_file_size : '100mb', //最大只能上传10mb的文件
        prevent_duplicates : true //不允许选取重复文件
    },
	init: {
		PostInit: function() {
			// document.getElementById('postfiles').onclick = function() {
            // set_upload_param(uploader, '', false);
            // return false;
			// };
            $(".moxie-shim input").attr("accept","video/avi,video/wmv,video/mpeg,video/mp4,video/mov,video/mkv,video/flv,video/f4v,video/m4v,video/rmvb,video/rm,video/3gp,video/dat,video/ts,video/mts,video/vob");
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
                uploadVideo();
                set_upload_param(uploader, '', false);
            });
		},

		BeforeUpload: function(up, file) {
            set_upload_param(up, file.name, true);
        },

		UploadProgress: function(up, file) {
            updateUploadProgress(file.percent);
		},

		FileUploaded: function(up, file, info) {
            if (info.status == 200) {
                uploadOver(200,info.response,g_object_name);
            } else if (info.status == 203) {
                uploadOver(203,info.response,g_object_name);
            } else {
                uploadOver(500,info.response,g_object_name);
            } 
		},

		Error: function(up, err) {
            if (err.code == -600) {
                show_msg('选择的文件太大了！');
            }
            else if (err.code == -601) {
                show_msg('不允许上传的文件类型！');
            }
            else if (err.code == -602) {
                show_msg('文件已经上传过一遍了！');
            }
            else 
            {
                show_msg(err.response);
            }
		}
	}
});

uploader.init();
