<?php

function getVideoImg($url){
    $urlArr = explode(".",$url);
    return "http://video.longzongqin.".$urlArr[2].".jpg";
}

function p($url=""){
    return "/long/public/".$url;
}