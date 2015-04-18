<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 18:59
 */
include_once('../services/music_output.php');
include_once('../services/text_output.php');
function music($entityName)
{
    $dstr = array(2);
    $dstr[0] = strtok($entityName, "-");
    if ($dstr[$i] !== false) {
        $dstr[1] = strtok("-");
        $apicallurl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . urlencode($dstr[0]) . "$$" . urlencode($dstr[1]) . "$$$$";
    } else
        $apicallurl = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . urlencode($entityName) . "$$$$$$";
    $postStr = file_get_contents($apicallurl);
    if ($postStr == NULL) {
        $contentStr = "无此歌曲，“点歌”加上歌名，歌曲名前加空格，如“点歌 稻香”";
        text_output($contentStr);
        exit;
    }

//解析数据
    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    $url = $postObj->url->encode;
    $_url = $postObj->url->decode;
    $durl = $postObj->durl->encode;
    $_durl = $postObj->durl->decode;

    $url_str = array(7);
    $url_str[0] = strtok($url, "/");

    $i = 0;
    while ($url_str[$i] !== false) {
        $i = $i + 1;
        $url_str[$i] = strtok("/");
    }

    $_url_str = array(2);
    $_url_str[0] = strtok($_url, "&");
    $musicUrl = $url_str[0] . "//" . $url_str[1] . "/" . $url_str[2] . "/" . $url_str[3] . "/" . $url_str[4] . "/" . $_url_str[0];
    $durl_str = array(7);
    $durl_str[0] = strtok($durl, "/");
    $i = 0;
    while ($durl_str[$i] !== false) {
        $i = $i + 1;
        $durl_str[$i] = strtok("/");
    }
    $_durl_str = array(2);
    $_durl_str[0] = strtok($_durl, "&");
    $QmusicUrl = $durl_str[0] . "//" . $durl_str[1] . "/" . $url_str[2] . "/" . $durl_str[3] . "/" . $durl_str[4] . "/" . $_durl_str[0];
    music_output($entityName, "河师大掌中校园", $musicUrl, $QmusicUrl);
    exit;
}