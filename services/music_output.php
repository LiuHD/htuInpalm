<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 18:52
 */
include_once('../wx_tpl.php');
function music_output($title,$author,$url1,$url2){
    $msgType="music";
    $resultStr = sprintf($musicTpl,$fromUsername,$toUsername,time(),$msgType,$title,$author,$url1,$url2);
    echo $resultStr;
}