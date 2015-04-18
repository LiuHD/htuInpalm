<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 0:32
 */
include_once('wx_tpl.php');
function text_output($contentStr){
    $msgType="text";
    $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
    echo $resultStr;
}