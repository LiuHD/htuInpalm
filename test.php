<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/5
 * Time: 13:07
 */


//$a="a";
//$b="b";
//$c="c";
//function fun1($a){
//    echo "func1".$a;
//}
//
//function fun2($a,$b){
//    echo "fun2:".$a.$b;
//}
//
//function fun3($a,$b,$c){
//    echo "fun3:".$a.$b.$c;
//}
//
//$num="1";
//
//if($num=="1")
//    $args=array($a);
//elseif($num=="2")
//    $args=array($a,$b);
//elseif($num=="3")
//    $args=array($a,$b,$c);
//call_user_func_array('fun'.$num,$args);
//$dates =array('10-10-2003','2-17-2002','2-16-2003','1-01-2005','10-10-2004');
//sort($dates);
//print_r($dates);
//natsort($dates);
//print_r($dates);
//
//function dateSort($a,$b){
//    if($a==$b)
//        return 0;
//    list($amonth,$aday,$ayear) = explode('-',$a);
//    list($bmonth,$bday,$byear) = explode('-',$b);
//    $amonth=str_pad($amonth,2,"0",STR_PAD_LEFT);
//    $bmonth=str_pad($bmonth,2,"0",STR_PAD_LEFT);
//    $aday=str_pad($aday,2,"0",STR_PAD_LEFT);
//    $bday=str_pad($bday,2,"0",STR_PAD_LEFT);
//    $a=$ayear.$amonth.$aday;
//    $b=$byear.$bmonth.$bday;
//
//    return ($a>$b) ?1:-1;
//
//}
//
//usort($dates,'dateSort');
//print_r($dates);

//setcookie('flavorstyle','comic');
//setcookie('flavorbg','worldcub');
//$time=getdate();
//while($temp=each($time))
//    echo $temp['key']."=>".$temp['value']."<br>";
//$lastmod=date("F-d,Y H:i:s",getlastmod());
//echo "The page last modified on $lastmod";
//$browser=get_browser();
//$browser=get_object_vars($browser);
//echo $browser['browser'].$browser['version'];

$url = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . "大约在冬季" . "$$"."齐秦";
$postStr=file_get_contents($url);
if($postStr==NULL)
    echo "error";
$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
print_r($postObj);
$url = $postObj->url->encode;
$_url = $postObj->url->decode;
$durl = $postObj->durl->encode;
$_durl = $postObj->durl->decode;







