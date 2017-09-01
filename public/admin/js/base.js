/**
 * Created by long on 16/1/6.
 */
/**
 * Created by long on 2015/4/29.
 */
var systemUrl = "http://longzongqin.cn/"
function defaultImg(obj,img){
    if(img == null){
        img = "blank_pic.png";
    }
    var errorImg = systemUrl+"long/"+img;//替换图片地址
    obj.src = errorImg;
}
function show_msg(msg){
    if(!document.getElementById("infoPop")){
        var infoPop = '<div class="modal fade" id="showMsgPop" tabindex="-1" role="dialog" aria-labelledby="infoPopModalLabel">';
        infoPop +='<div class="modal-dialog" role="document">';
        infoPop +='<div class="modal-content">';
        infoPop +='<div class="modal-header">';
        infoPop +='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        infoPop +='<h4 class="modal-title" id="infoPopModalLabel">提示信息</h4>';
        infoPop +='</div>';
        infoPop +='<div class="modal-body">';
        infoPop +='<form>';
        infoPop +='<div class="form-group">';
        infoPop +='<p id="showMsgPopInfo"></p>';
        infoPop +='</div>';
        infoPop +='</form>';
        infoPop +='</div>';
        infoPop +='</div>';
        infoPop +='</div>';
        infoPop +='</div>';
        $("body").append(infoPop);
    }
    $("#showMsgPopInfo").html(msg);
    $("#showMsgPop").modal("show");
    setTimeout('$("#showMsgPop").modal("hide");',1500);
}

function showLoad(msg){
    if(!document.getElementById("loadingDiv")){
        var loadDiv = '<div id="loadingDiv" class="loading">';
        loadDiv +='<div class="loading-back"></div>';
        loadDiv +='<div class="loading-div">';
        loadDiv +='<img src="'+systemUrl+'long/public/img/loading.gif">';
        loadDiv +='<p id="loadingStr">请稍等...</p>';
        loadDiv +='</div>';
        loadDiv +='</div>';
        $("body").append(loadDiv);
    }
    if(msg != ""){
        $("#loadingStr").html(msg);
    }
    $("#loadingDiv").show();
}
function hideLoad(){
    $("#loadingDiv").hide();
}

function escapeHtml(str) {
    var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"','\/':'/'};
    return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){return arrEntities[t];});
}