<?php
//装在模板文件
include_once("wx_tpl.php");
include_once("base-class.php");
include_once("getXiaoiInfo.php");

//新建sae数据库类
$mysql = new SaeMysql();

//新建Memcache类
$mc = memcache_init();

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

if (!empty($postStr)) {
    //解析数据
    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    //发送方Id
    $fromUsername = $postObj->FromUserName;
    //接收方Id
    $toUsername = $postObj->ToUserName;
    //消息类型
    $form_MsgType = $postObj->MsgType;

    //事件消息
    if ($form_MsgType == "event")         //关注欢迎词
    {
        //获取事件类型
        $form_Event = $postObj->Event;
        //订阅事件
        if ($form_Event == "subscribe")
            guan_zhu_hui_fu();
    } //文字消息
    else if ($form_MsgType == "text") {
        $textConent = $postObj->Content;
        $textConent = trim($textConent);

        if (!empty($textConent)) {
            //从memcache获取用户上一次动作
            $last_do = $mc->get($fromUsername . "_do");
            //从memcache获取用户上一次数据
            $data0 = $mc->get($fromUsername . "_data0");
            $data1 = $mc->get($fromUsername . "_data1");

            /**********************************************
             * 关键字
             **********************************************/
            //关键字识别
            if ($textConent == "帮助")   //帮助
                help();

            else if ($textConent == "/:,@f" || $textConent == "自习室")
                zixishi0($mc);
            if (is_numeric($textConent))
                zixishi1($mc);

            else if ($textConent == "丫头" || $textConent == "潘丽苹")//丫头专属
                pan_only($textConent);


            else if ($textConent == "入学指南")      //入学指南


            else if ($textConent == "地图")  //地图
            {
                $mc->set($fromUsername . "_do", "ditu", 0, 600);
                $msgType = "text";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请选择东西区：\n1.西区\n2.东区");
                echo $resultStr;
                exit;
            } else if ($textConent == "1") {
                if ($last_do == "ditu") {
                    $msgType = "news";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, 1);
                    $Title2 = "西区地图";
                    $Discription2 = "";
                    $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/dongqudamen.jpg";
                    $Url2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E7%BD%91%E9%A1%B5/xiququdituwangye.html";
                    $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);
                    $resultStr = $news_fore . $item2 . $news_end;
                    echo $resultStr;
                    exit;
                }
            } else if ($textConent == "2") {
                if ($last_do == "ditu") {
                    $msgType = "news";
                    $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, 1);
                    $Title3 = "东区地图";
                    $Discription3 = "";
                    $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/dongqudamen.jpg";
                    $Url3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E7%BD%91%E9%A1%B5/dongqudituwangye.html";
                    $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);
                    $resultStr = $news_fore . $item3 . $news_end;
                    echo $resultStr;
                    exit;
                }
            }
            /*
         * 公选课功能已过期
         *
        else if(substr($textConent,0,9)=="公选课")
         {
          $entityName =trim(substr($textConent,9,strlen($textConent)));
          if ($entityName=="")
          {
          $msgType = "text";
          $contentStr = "发送“公选课”加上课程名称，如“公选课合同法”";
          $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,$contentStr);
           echo $resultStr;
           exit;
          }
		  $gxk_value=array(15);       //定义公选课数组
          if($entityName=="随机")    //随机公选课
           {
           $gxk_rand=rand(1,317);
           $gxk_value[0]=$mysql->getLine("select * 
           							   from gongxuanke
                                       where '$gxk_rand'=gxk_id");
		   $i=0;
           if($gxk_value[0]["gxk_address"]==NULL)
           {
               $gxk_value[0]["gxk_address"]="教室未给出o>_<o";
           }
           while($gxk_value[$i]["gxk_teacher"]==NULL)   
           {
           $temp=$gxk_value[$i]["gxk_id"]-1;
           $gxk_value[$i+1]=$mysql->getLine("select * 
						                     from gongxuanke
                                             where gxk_id=$temp");
           $i=$i+1;       
           }
           $gxk_value[0]["gxk_teacher"]=$gxk_value[$i]["gxk_teacher"];
			$i=0;
            while($gxk_value[$i]["gxk_name"]==NULL)   
           {
           $temp=$gxk_value[$i]["gxk_id"]-1;
           $gxk_value[$i+1]=$mysql->getLine("select * 
		   			                     from gongxuanke
                                             where gxk_id=$temp");
           $i=$i+1;       
           }
           $gxk_value[0]["gxk_name"]=$gxk_value[$i]["gxk_name"];		   
           $msgType = "text";
           $resultStr=sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType,$gxk_value[0]["gxk_name"]."\n老师：".$gxk_value[0]["gxk_teacher"]."\n时间：".$gxk_value[0]["gxk_time"]."\n周次：".$gxk_value[0]["gxk_zhouci"]."周"."\n教室：".$gxk_value[0]["gxk_address"]);
           echo $resultStr;
           exit;   
            }
            //查询数据库
                    
            $gxk_value[0]=$mysql->getLine("select * 
            						   from gongxuanke
                                       where gxk_name Like '%$entityName%'");                    
            //查无此课
            if(!$gxk_value[0])
            {
            $msgType = "text";
            $resultStr = sprintf($textTpl,$fromUsername,$toUsername,time(),$msgType,"o>_<o无此课程，请重新输入，如需帮助，请回复“帮助”。");
            echo $resultStr;
            exit;  
            }
            //查询成功返回消息
            else
           {
            if($gxk_value[0]["gxk_teacher"]==NULL)
            {
               $gxk_value[0]["gxk_teacher"]="未给出";
            }
            do    //同课多教室
           {
           if($gxk_value[$i]["gxk_address"]==NULL)
           {
              $gxk_value[$i]["gxk_address"]="教室未给出o>_<o";
           }
		   $i=$i+1;
           $temp=$gxk_value[0]["gxk_id"]+$i;
           $gxk_value[$i]=$mysql->getLine("select * 
						                     from gongxuanke
                                             where gxk_id=$temp");
            }
            while($gxk_value[$i]["gxk_name"]==NULL);
            $j=1;
            while($j<$i)
            {
                if($gxk_value[$j]["gxk_teacher"]==NULL)
                {
                $gxk_value[$j]["gxk_teacher"]=$gxk_value[$j-1]["gxk_teacher"];
                
                }
                $j=$j+1;
            }
			$j=1;
                $text_content=$gxk_value[0]["gxk_name"]."\n--------\n1、".$gxk_value[0]["gxk_teacher"]." \n".$gxk_value[0]["gxk_time"]."\n第".$gxk_value[0]["gxk_zhouci"]."周"."\n".$gxk_value[0]["gxk_address"];
            while($j<$i)
            {
                $text_content=$text_content."\n--------\n".($j+1)."、".$gxk_value[$j]["gxk_teacher"]." \n".$gxk_value[$j]["gxk_time"]."\n第".$gxk_value[0]["gxk_zhouci"]."周"."\n".$gxk_value[$j]["gxk_address"];
            $j=$j+1;
            }
			$msgType = "text";
			$resultStr=sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType,$text_content);
            echo $resultStr;
            exit;
            }
        }
         */

            else if ($textConent == "校歌")   //校歌
            {
                music_output("校歌", "河南师范大学", "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E9%9F%B3%E4%B9%90/xiaogeyuanchang.mp3", "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E9%9F%B3%E4%B9%90/xiaogeyuanchang.mp3");
                exit;
            } // http://api2.sinaapp.com/search/music/?appkey=0020130430&appsecert=fa6095e1133d28ad&reqtype=music&keyword=%E6%9C%80%E7%82%AB%E6%B0%91%E6%97%8F%E9%A3%8E

            else if (substr($textConent, 0, 6) == "点歌") {
                $entityName = trim(substr($textConent, 6, strlen($textConent)));
                if ($entityName == "") {
                    $contentStr = "发送“点歌”加上歌名，歌曲名前加" - "，如“点歌稻香-周杰伦”";
                    text_output($contentStr);
//              $return = new Saestorage;调试用
//              $return->write('hsdzzxy','text.txt',$resultStr);
                    exit;
                }
                music($entityName);
            }

            else //智能聊天机器人
                {

                    $apiKey = "ef82785d47e0491f5aa7be43c58ba3b8";
                    $apiURL = "http://www.tuling123.com/openapi/api?key=KEY&info=INFO";
                    $reqInfo = $textConent;
                    $url = str_replace("INFO", $reqInfo, str_replace("KEY", $apiKey, $apiURL));
                    $res = file_get_contents($url);
                    $json = json_decode($res, true);
                    $contentStr = $json['text'];
                    text_output($contentStr);
                    exit;
                }
            }
        } /**********************************************
         * 关键字
         **********************************************/
        else {
            echo "";
            exit;
        }
    }
    ?>