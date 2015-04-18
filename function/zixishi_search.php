<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 0:27
 */
include_once('../services/text_output.php');
function zixishi0(){
    $mc->set($fromUsername."_do", "zxs_0", 0, 1200);
    $contentStr = "请回复数字选择教学楼：\n1.田家炳\n2.二号楼\n3.文科楼\n4.阶梯楼\n5.东区A楼\n6.东区B楼";
    text_output($contentStr);
    exit;
}

function zixishi1($mc){
    if(strlen($textConent)==3)
    {
        $num=intval($textConent);
        $textConent=$num%10;
        $xingqi= floor(($num%100)/10);
        if($xingqi=="1"){$data1="一";$mc->set($fromUsername."_data1", "一", 0, 800);}
        else if($xingqi=="2"){$data1="二";$mc->set($fromUsername."_data1", "二", 0, 800);}
        else if($xingqi=="3"){$data1="三";$mc->set($fromUsername."_data1", "三", 0, 800);}
        else if($xingqi=="4"){$data1="四";$mc->set($fromUsername."_data1", "四", 0, 800);}
        else if($xingqi=="5"){$data1="五";$mc->set($fromUsername."_data1", "五", 0, 800);}
        else
        {
            $msgType="text";
            $contentStr="error 星期几代号错误，请重新输入1-5之间的数字\n如需帮助，请回复“帮助”";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;}

        $jiaoshi= floor($num/100);  //教室
        if($jiaoshi=="1"){$data0="田家炳";$mc->set($fromUsername."_data0","田家炳", 0, 1000);}
        else if($jiaoshi=="2"){$data0="二号楼";$mc->set($fromUsername."_data0","二号楼", 0, 1000);}
        else if($jiaoshi=="3"){$data0="文科楼";$mc->set($fromUsername."_data0","文科楼", 0, 1000);}
        else if($jiaoshi=="4"){$data0="阶梯楼";$mc->set($fromUsername."_data0","阶梯楼", 0, 1000);}
        else if($jiaoshi=="5"){$data0="东区A楼";$mc->set($fromUsername."_data0","东区A楼", 0, 1000);}
        else if($jiaoshi=="6"){$data0="东区B楼";$mc->set($fromUsername."_data0","东区B楼", 0, 1000);}
        else
        {
            $msgType="text";
            $contentStr="error 教学楼编号错误，应输入1-6之间的数字\n如需帮助，请回复“自习室”";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;
        }
        $last_do="zxs_2";
    }
    else if(strlen($textConent)==1)
    {
        if($last_do=="zxs_0")      //选择教学楼
        {
            $mc->set($fromUsername."_do", "zxs_1", 0, 600);
            if($textConent=="1"){$mc->set($fromUsername."_data0","田家炳", 0, 1000);}
            else if($textConent=="2"){$mc->set($fromUsername."_data0","二号楼", 0, 1000);}
            else if($textConent=="3"){$mc->set($fromUsername."_data0","文科楼", 0, 1000);}
            else if($textConent=="4"){$mc->set($fromUsername."_data0","阶梯楼", 0, 1000);}
            else if($textConent=="5"){$mc->set($fromUsername."_data0","东区A楼", 0, 1000);}
            else if($textConent=="6"){$mc->set($fromUsername."_data0","东区B楼", 0, 1000);}
            else
            {
                $mc->set($fromUsername."_do", "zxs_0", 0, 600);
                $msgType="text";
                $contentStr="error 请输入1-6之间的数字\n如需帮助，请回复“帮助”";
                $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
                echo $resultStr;
                exit;
            }
            $msgType="text";
            $contentStr = "请回复数字选择星期几：\n1.周一\n2.周二\n3.周三\n4.周四\n5.周五";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;
        }
        else if($last_do== "zxs_1")     //选择星期几
        {
            $mc->set($fromUsername."_do", "zxs_2", 0, 600);
            if($textConent=="1"){$mc->set($fromUsername."_data1", "一", 0, 800);}
            else if($textConent=="2"){$mc->set($fromUsername."_data1", "二", 0, 800);}
            else if($textConent=="3"){$mc->set($fromUsername."_data1", "三", 0, 800);}
            else if($textConent=="4"){$mc->set($fromUsername."_data1", "四", 0, 800);}
            else if($textConent=="5"){$mc->set($fromUsername."_data1", "五", 0, 800);}
            else
            {
                $mc->set($fromUsername."_do", "zxs_1", 0, 600);
                $msgType="text";
                $contentStr="error 请重新输入1-5之间的数字\n如需帮助，请回复“帮助”";
                $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
                echo $resultStr;
                exit;}
            $msgType="text";
            $contentStr = "请回复数字选择第几节课：\n1.上午第一节[1-2]\n2.上午第二节[3-4]\n3.下午第一节[5-6]\n4.下午第二节[7-8]\n5.晚上第一节[9-10]";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;
        }
    }
    else
    {
        $msgType="text";
        $contentStr="error\n 如果不清楚查询自习室如何操作，请回复“帮助”";
        $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
        echo $resultStr;
        exit;
    }
    if($last_do== "zxs_2")    //选择第几节，后期处理
    {
        if($textConent=="1"){$data2="上午第一";}
        else if($textConent=="2"){$data2="上午第二";}
        else if($textConent=="3"){$data2="下午第一";}
        else if($textConent=="4"){$data2="下午第二";}
        else if($textConent=="5"){$data2="晚上第一";}
        else
        {
            $mc->set($fromUsername."_do", "zxs_2", 0, 600);
            $msgType="text";
            $contentStr="error 选择第几节课应该输入1-5之间的数字，请重新输入\n 如需帮助，请回复“帮助”";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;}

        $x=0;   //自习室搜索下限
        $y=0;   //自习室搜索下限
        $t=0;   //输出自习室的计数器
        switch($data0)
        {
            case "田家炳":$x=57;$y=94;break;
            case "二号楼":$x=1;$y=36;break;
            case "文科楼":$x=37;$y=56;break;
            case "阶梯楼":$x=95;$y=107;break;
            case "东区A楼":$x=108;$y=118;break;
            case "东区B楼":$x=119;$y=124;break;
            default:
                $msgType="text";
                $contentStr="error";
                $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
                echo $resultStr;
        }

        $zxs_value=array(50);

        switch($data1)
        {
            case "一":
                for($i=$x;$i<=$y;$i++)
                {
                    $zxs_temp=0;
                    if($data2=="上午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and one Like'%一%'");
                    else if($data2=="上午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and one Like'%二%'");
                    else if($data2=="下午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and one Like'%三%'");
                    else if($data2=="下午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and one Like'%四%'");
                    else if($data2=="晚上第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and one Like'%五%'");
                    if($zxs_temp!=0)
                    {
                        $zxs_value[$t]=$zxs_temp["jiaoshi"];
                        $t=$t+1;
                    }
                }
                break;

            case "二":
                for($i=$x;$i<=$y;$i++)
                {
                    $zxs_temp=0;
                    if($data2=="上午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and two like'%一%'");
                    else if($data2=="上午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and two like'%二%'");
                    else if($data2=="下午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and two like'%三%'");
                    else if($data2=="下午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and two like'%四%'");
                    else if($data2=="晚上第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and two like'%五%'");
                    if($zxs_temp!=0)
                    {
                        $zxs_value[$t]=$zxs_temp["jiaoshi"];
                        $t=$t+1;
                    }
                }
                break;

            case "三":
                for($i=$x;$i<=$y;$i++)
                {
                    $zxs_temp=0;
                    if($data2=="上午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and three like'%一%'");
                    else if($data2=="上午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and three like'%二%'");
                    else if($data2=="下午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and three like'%三%'");
                    else if($data2=="下午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and three like'%四%'");
                    else if($data2=="晚上第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and three like'%五%'");
                    if($zxs_temp!=0)
                    {
                        $zxs_value[$t]=$zxs_temp["jiaoshi"];
                        $t=$t+1;
                    }
                }
                break;

            case "四":
                for($i=$x;$i<=$y;$i++)
                {
                    $zxs_temp=0;
                    if($data2=="上午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and four like'%一%'");
                    else if($data2=="上午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and four like'%二%'");
                    else if($data2=="下午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and four like'%三%'");
                    else if($data2=="下午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and four like'%四%'");
                    else if($data2=="晚上第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and four like'%五%'");
                    if($zxs_temp!=0)
                    {
                        $zxs_value[$t]=$zxs_temp["jiaoshi"];
                        $t=$t+1;
                    }
                }
                break;

            case "五":
                for($i=$x;$i<=$y;$i++)
                {
                    $zxs_temp=0;
                    if($data2=="上午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and five like'%一%'");
                    else if($data2=="上午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and five like'%二%'");
                    else if($data2=="下午第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and five like'%三%'");
                    else if($data2=="下午第二")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and five like'%四%'");
                    else if($data2=="晚上第一")
                        $zxs_temp=$mysql->getLine("select jiaoshi
from zixishi
where id=$i and five like'%五%'");

                    if($zxs_temp!=0)
                    {
                        $zxs_value[$t]=$zxs_temp["jiaoshi"];
                        $t=$t+1;
                    }
                }
                break;
        }
        if($zxs_value[0]==50)
        {
            $msgType="text";
            $contentStr = "无空闲教室[委屈]\n如需帮助，请回复“帮助”\n-----\n".$data0."星期".$data1.$data2."节\n偷偷的告诉你:即日起可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！速来赐教(≧▽≦)";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
            echo $resultStr;
            exit;
        }
        $contentStr="空闲教室有".$zxs_value[0];
        for($j=1;$j<$t;$j++)
        {
            $contentStr=$contentStr."、".$zxs_value[$j];
        }
        $a="\n本学期自习室课表已更新完全，请同学们放心使用！^ω^";
        $b="\n偷偷的告诉你:即日起可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！速来赐教(≧▽≦)";
        $c="";
        $d="\n喜欢我们的自习室查询功能么，想带动你身边更多的人和你一起自习么，那就快推荐给身边的人关注吧";
        $e="\n点歌功能是个很好玩的功能哦，赶快试试回复【点歌+歌名】如\"点歌稻香\"试试吧";
        $suiji=rand(1,10);
        switch($suiji){
            case 1:$insertStr=$a;break;
            case 2:$insertStr=$b;break;
            case 3:$insertStr=$d;break;
            case 4:$insertStr=$e;break;
            default:$insertStr=$c;
        }
        $contentStr=$contentStr."[奋斗]\n-----\n".$data0."星期".$data1.$data2."节".$insertStr;
        $msgType="text";
        $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
        echo $resultStr;
        exit;
    }
}