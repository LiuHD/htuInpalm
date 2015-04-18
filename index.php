<?php

$_str="歌曲-周杰伦";

$dstr= array(2);
$dstr[0]=strtok($_str,"-");
$i=0;
while($dstr[$i]!== false)
{
$i=$i+1;
$dstr[$i]= strtok("-");
}
echo $dstr[0]."\n".$dstr[1];
$apicallurl="http://box.zhangmen.baidu.com/x?op=12&count=1&title=".urlencode($dstr[0])."$$".urlencode($dstr[1])."$$$$";
echo $apicallurl;
$postStr = file_get_contents($apicallurl);         
exit;
?>