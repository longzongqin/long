<?php

function getVideoImg($url){
    $urlArr = explode(".",$url);
    return "http://video.longzongqin.".$urlArr[2].".jpg";
}

function publicPath(){
    return "/long/public/";
}
