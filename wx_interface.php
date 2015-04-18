<?php
//装载模板文件
include_once("wx_tpl.php");
include_once("base-class.php");


//新建sae数据库类
$mysql = new SaeMysql();

//新建Memcache类
$mc=memcache_init();

//获取微信发送数据
$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

//操作菜单
$help_menu="回复“BM”按部门查询\n回复“XM”通过姓名查询\n回复“GH”通过工号查询\n回复“DH”通过手机查询\n回复“MY”查看个人信息\n";

//在职状态
$roster_status_ary=array('','在职','休假','病假','离职');

  //返回回复数据
if (!empty($postStr)){
          
    	//解析数据
          $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    	//发送消息方ID
          $fromUsername = $postObj->FromUserName;
    	//接收消息方ID
          $toUsername = $postObj->ToUserName;
   	    //消息类型
          $form_MsgType = $postObj->MsgType;
    
    	//欢迎消息
          if($form_MsgType=="event")
          {
             //获取事件类型
            $form_Event = $postObj->Event;
            //订阅事件
            if($form_Event=="subscribe")
            {
             
              
                 //根据关注用户的OPENID判断是否已经绑定员工号
                if(check_user($fromUsername))
                {
                	
                    //关注绑定欢迎词
                    $welcome_str="感谢关注军情六处！\n\n".$help_menu;
                
                }
                else
                {
                
                  //关注未绑定欢迎词
                    $welcome_str="感谢关注军情六处！你还未绑定微信账号，不能查询通讯录，请回复“BD”开始绑定！";
                }
                   //回复欢迎文字消息
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $welcome_str);
               	  echo $resultStr;
                  exit;  
             }
          }
    
    	//用户文字回复进行绑定、查询等操作
         
        if($form_MsgType=="text")
        {
            //获取用户发送的文字内容并过滤
            $form_Content = trim($postObj->Content);
            $form_Content = string::un_script_code($form_Content);
            
            
	  	   //如果发送内容不是空白则执行相应操作
 		    if(!empty($form_Content))
            {
                //从memcache获取用户上一次动作
                $last_do=$mc->get($fromUsername."_do");
                //从memcache获取用户上一次数据
                $last_data=$mc->get($fromUsername."_data");
                
                
                //用户帮助提示
 	           if(strtolower($form_Content)=="help")
               {
                     //根据关注用户的OPENID判断是否已经绑定员工号
                    if(check_user($fromUsername))
                    {
                        
                        //关注绑定欢迎词
                        $help_str="军情六处使用帮助：\n\n".$help_menu;
                    
                    }
                    else
                    {
                    
                      //关注未绑定欢迎词
                        $help_str="你还未绑定微信账号，不能查询通讯录，请回复“BD”开始绑定！";
                    }
                       //回复文字消息
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, $help_str);
                      echo $resultStr;
                      exit;  
               }
                
                
  		  		//用户跳出操作
 	           if(strtolower($form_Content)=="exit")
               {
                    //清空memcache动作
                   $mc->delete($fromUsername."_do");
                   
                   //清空memcache数据
                   $mc->delete($fromUsername."_data");
                   
                   //回复操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "你已经退出当前操作，进行其他操作请输入“help”");
               	  echo $resultStr;
                  exit;  
               }
                
                
                //查询个人信息
 	           if(strtolower($form_Content)=="my")
               {
                    //清空memcache动作
                   $mc->delete($fromUsername."_do");
                   
                   //清空memcache数据
                   $mc->delete($fromUsername."_data");
                   
                   //监测是否已经绑定账号
                    if($my_value=check_user($fromUsername))
                    {
                        
                        //用图文消息输出员工信息
                        $resultStr="<xml>\n
                                    <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
                                    <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
                                    <CreateTime>".time()."</CreateTime>\n
                                    <MsgType><![CDATA[news]]></MsgType>\n
                                    <ArticleCount>1</ArticleCount>\n
                                    <Articles>\n
                                    <item>\n
                                    <Title><![CDATA[".$my_value["roster_number"].".".$my_value["roster_name"]."（".$roster_status_ary[$my_value["roster_status"]]."）"."]]></Title> \n
                                    <Description><![CDATA[个人详情请点击阅读全文！]]></Description>\n
                                    <PicUrl><![CDATA[".$my_value["roster_pic"]."]]></PicUrl>\n
                                    <Url><![CDATA[".'http://weixincourse.sinaapp.com/detail.php?id='.$my_value["roster_id"]."]]></Url>\n
                                    </item>\n
                                    </Articles>\n
                                    <FuncFlag>0</FuncFlag>\n
                                    </xml>";
                        echo $resultStr;
                        exit;
                    }
                    else
                    {
                    
                       //回复未绑定提示
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "你还未绑定微信账号，请回复“BD”开始绑定！");
                      echo $resultStr;
                      exit;  
                    }
               }
                
                
                //各种搜索开始……
                
                
                 //手机搜索
                if(strtolower($form_Content)=="dh")
                {
                   //用memcache保存部门搜索操作状态
                   $mc->set($fromUsername."_do", "dh_search", 0, 600);
                  
                   //回复操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入员工手机查询：");
               	  echo $resultStr;
                  exit;  
                }
                //接收到上一步是工号搜索状态，获取用户查询关键字
                if($last_do=="dh_search")
                {
                    //查询数据库
                    $roster_value=$mysql->getLine("select roster_id,roster_name,roster_number,roster_pic,roster_status 
                    							   from roster
                                                   where roster_mp='$form_Content'");
                    //查无此人
                    if(!$roster_value)
                    {
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "无此员工，请重新输入，或者输入exit退出操作！");
                      echo $resultStr;
                      exit;  
                    }
                    //查询成功返回图文消息
                    else
                    {
                        //用图文消息输出员工信息
                        $resultStr="<xml>\n
                                    <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
                                    <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
                                    <CreateTime>".time()."</CreateTime>\n
                                    <MsgType><![CDATA[news]]></MsgType>\n
                                    <ArticleCount>1</ArticleCount>\n
                                    <Articles>\n
                                    <item>\n
                                    <Title><![CDATA[".$roster_value["roster_number"].".".$roster_value["roster_name"]."（".$roster_status_ary[$roster_value["roster_status"]]."）"."]]></Title> \n
                                    <Description><![CDATA[详情请点击阅读全文，输入其他员工手机继续查询，退出手机查询状态请输入exit]]></Description>\n
                                    <PicUrl><![CDATA[".$roster_value["roster_pic"]."]]></PicUrl>\n
                                    <Url><![CDATA[".'http://weixincourse.sinaapp.com/detail.php?id='.$roster_value["roster_id"]."]]></Url>\n
                                    </item>\n
                                    </Articles>\n
                                    <FuncFlag>0</FuncFlag>\n
                                    </xml>";
                        echo $resultStr;
                        exit;
                    }
               
                }
                
                
               //工号搜索
                if(strtolower($form_Content)=="gh")
                {
                   //用memcache保存部门搜索操作状态
                   $mc->set($fromUsername."_do", "gh_search", 0, 600);
                  
                   //回复操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入员工工号查询：");
               	  echo $resultStr;
                  exit;  
                }
                //接收到上一步是工号搜索状态，获取用户查询关键字
                if($last_do=="gh_search")
                {
                    //查询数据库
                    $roster_value=$mysql->getLine("select roster_id,roster_name,roster_number,roster_pic,roster_status 
                    							   from roster
                                                   where roster_number='$form_Content'");
                    //查无此人
                    if(!$roster_value)
                    {
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "无此员工，请重新输入，或者输入exit退出操作！");
                      echo $resultStr;
                      exit;  
                    }
                    //查询成功返回图文消息
                    else
                    {
                        //用图文消息输出员工信息
                        $resultStr="<xml>\n
                                    <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
                                    <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
                                    <CreateTime>".time()."</CreateTime>\n
                                    <MsgType><![CDATA[news]]></MsgType>\n
                                    <ArticleCount>1</ArticleCount>\n
                                    <Articles>\n
                                    <item>\n
                                    <Title><![CDATA[".$roster_value["roster_number"].".".$roster_value["roster_name"]."（".$roster_status_ary[$roster_value["roster_status"]]."）"."]]></Title> \n
                                    <Description><![CDATA[详情请点击阅读全文，输入其他员工工号继续查询，退出工号查询状态请输入exit]]></Description>\n
                                    <PicUrl><![CDATA[".$roster_value["roster_pic"]."]]></PicUrl>\n
                                    <Url><![CDATA[".'http://weixincourse.sinaapp.com/detail.php?id='.$roster_value["roster_id"]."]]></Url>\n
                                    </item>\n
                                    </Articles>\n
                                    <FuncFlag>0</FuncFlag>\n
                                    </xml>";
                        echo $resultStr;
                        exit;
                    }
               
                }
                
                
                //姓名搜索
                if(strtolower($form_Content)=="xm")
                {
                   //用memcache保存部门搜索操作状态
                   $mc->set($fromUsername."_do", "xm_search", 0, 600);
                  
                   //回复操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入员工姓名查询：");
               	  echo $resultStr;
                  exit;  
                }
                //接收到上一步是姓名搜索状态，获取用户查询关键字
                if($last_do=="xm_search")
                {
                    //查询数据库
                    $roster_value=$mysql->getLine("select roster_id,roster_name,roster_number,roster_pic,roster_status 
                    							   from roster
                                                   where roster_name='$form_Content'");
                    //查无此人
                    if(!$roster_value)
                    {
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "无此员工，请重新输入，或者输入exit退出操作！");
                      echo $resultStr;
                      exit;  
                    }
                    //查询成功返回图文消息
                    else
                    {
                        //用图文消息输出员工信息
                        $resultStr="<xml>\n
                                    <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
                                    <FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
                                    <CreateTime>".time()."</CreateTime>\n
                                    <MsgType><![CDATA[news]]></MsgType>\n
                                    <ArticleCount>1</ArticleCount>\n
                                    <Articles>\n
                                    <item>\n
                                    <Title><![CDATA[".$roster_value["roster_number"].".".$roster_value["roster_name"]."（".$roster_status_ary[$roster_value["roster_status"]]."）"."]]></Title> \n
                                    <Description><![CDATA[详情请点击阅读全文，输入其他员工姓名继续查询，退出姓名查询状态请输入exit]]></Description>\n
                                    <PicUrl><![CDATA[".$roster_value["roster_pic"]."]]></PicUrl>\n
                                    <Url><![CDATA[".'http://weixincourse.sinaapp.com/detail.php?id='.$roster_value["roster_id"]."]]></Url>\n
                                    </item>\n
                                    </Articles>\n
                                    <FuncFlag>0</FuncFlag>\n
                                    </xml>";
                        echo $resultStr;
                        exit;
                    }
               
                }
                
                
                //部门搜索
                if(strtolower($form_Content)=="bm")
                {
                   //用memcache保存部门搜索操作状态
                   $mc->set($fromUsername."_do", "bm_search", 0, 600);
                    //部门查询可能会有多个，要使用分页，用memcache保存翻页，先设成第一页，同时将搜索部门字设成NULL；
                    $mc->set($fromUsername."_data", "null||1", 0, 600);
                  
                   //回复操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入部门名称查询：");
               	  echo $resultStr;
                  exit;  
                }
                //接收到上一步是部门搜索状态，获取用户查询关键字
                if($last_do=="bm_search")
                {
                    
                    //从memcache数据中获取搜索关键字和当前页码；
                    $last_data=explode("||",$last_data);
                    //设定当前搜索部门名称；如果memcache数据中搜索关键字是null则设定关键字为当前用户回复的文字
                    $search_content=($last_data[0]=="null")?$form_Content:$last_data[0];
                    //先查询是否有该部门，并获取该部门的id
                    $class_id=$mysql->getVar("select class_id from class where class_name='$search_content' and status=1");
                    //查询不到该部门名称则提示
                    if(!$class_id)
                    {
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "无此部门名称，请重新输入，或者输入exit退出操作！");
                      echo $resultStr;
                      exit;  
                    }
                   
                    //查询该部门下的记录总数
 					$count=$mysql->getVar("select COUNT(*) from roster where roster_class=$class_id and status=1");
                    //如果总数为0则提示
                    if(!$count)
                    {
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "该部门没有员工，请重新输入，或者输入exit退出操作！");
                      echo $resultStr;
                      exit;  
                    }
                    //每次返回数据条数
                    $page_num=4;
                    //当前页码
                    $page=$last_data[1];
                    //起始记录标号
                    $from_record = ($page - 1) * $page_num;
                    //获取符合条件的数据
				    $roster_res=$mysql->getData("select roster_id,roster_name,roster_number,roster_pic,roster_status
                                        from roster where status=1 and roster_class=$class_id 
                                        order by roster_id desc 
                                        limit $from_record,$page_num");
                    
                    //生成输出的数组
                    $roster_list=array();
                    //设定返回图文消息的封面图文消息
                    $roster_list[]=array('title'=>$search_content."搜索结果(第".$page."页)：",
                                         'doc'=>'',
                                         'pic'=>'http://weixincourse-weixincourse.stor.sinaapp.com/fengmian.jpg',
                                         'url'=>'http://weixincourse.sinaapp.com/list.php?id='.$class_id);
                    //循环输出员工数据格式化
                    foreach($roster_res as $value)
                    {
                     $roster_list[]=array('title'=>$value["roster_number"].".".$value["roster_name"]."（".$roster_status_ary[$value["roster_status"]]."）",
                                         'doc'=>'',
                                         'pic'=>$value["roster_pic"],
                                         'url'=>'http://weixincourse.sinaapp.com/detail.php?id='.$value["roster_id"]);
                   
                    }
                    //检测是否还有下页
                    $roster_next=0;
                    $roster_tip="";
                    //计算总页数
                    $real_page=@ceil($count / $page_num);
                    //如果页码已经超过或者到达最后一页，将页码设置成一
                    if($page>=$real_page)
                    {
                        $roster_next=1;
                        $roster_tip="已经到最后一页，重复查询输入任何字符，退出请输入exit";
                    }
                    //否则当前页码加1
                    else
                    {
                        $roster_next=$page+1;
                        $roster_tip="还有".($count-($page*$page_num))."条记录，输入任何字符查看下一页，退出请输入exit";
                    }
                    //设定memcache，保存搜索部门名称和关键字；
                    $mc->set($fromUsername."_data", $search_content."||".$roster_next, 0, 600);

                    //添加结尾提示
                    $roster_list[]=array('title'=>$roster_tip,
                                         'doc'=>'',
                                         'pic'=>'http://weixincourse-weixincourse.stor.sinaapp.com/fengmian.jpg',
                                         'url'=>'http://weixincourse.sinaapp.com/list.php?id='.$class_id);
                  
                    
                    //用多图文消息输出员工信息
                    $resultStr="<xml>\n
								<ToUserName><![CDATA[".$fromUsername."]]></ToUserName>\n
								<FromUserName><![CDATA[".$toUsername."]]></FromUserName>\n
								<CreateTime>".time()."</CreateTime>\n
								<MsgType><![CDATA[news]]></MsgType>\n
								<ArticleCount>".count($roster_list)."</ArticleCount>\n
								<Articles>\n";
                    foreach($roster_list as $key=>$value)
                    {
                        $resultStr.="<item>\n
									<Title><![CDATA[".$value["title"]."]]></Title> \n
									<Description><![CDATA[".$value["doc"]."]]></Description>\n
									<PicUrl><![CDATA[".$value["pic"]."]]></PicUrl>\n
									<Url><![CDATA[".$value["url"]."]]></Url>\n
									</item>\n";
                    }
                    $resultStr.="</Articles>\n
								<FuncFlag>0</FuncFlag>\n
								</xml>";
                    echo $resultStr;
                    exit;
                    
                   
                }
               
                //各种搜索结束……
                
                    
                    
                    
                 //绑定微信用户步骤开始
               
 		  		//用户输入BD进行账号绑定
 	           if(strtolower($form_Content)=="bd")
               {
                   //监测微信用户openid是否已经绑定
                   
                    if(check_user($fromUsername))
                    {
                        
                      //提示已经绑定警告
                      $msgType = "text";
                      $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "你已经绑定账号，请不要重复操作！");
                      echo $resultStr;
                      exit;  
                    }
                  
                   //用memcache保存这步操作，格式为名称、值、有效时间(单位秒)；
                   $mc->set($fromUsername."_do", "bd_0", 0, 600);
                   //回复绑定下一步操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入你的姓名，输入exit退出操作！");
               	  echo $resultStr;
                  exit;  
               }
                
                //绑定第一步，输入姓名
               if($last_do=="bd_0")
               {
                   //用memcache保存这步操作
                   $mc->set($fromUsername."_do", "bd_1", 0, 600);
                   
                   //用memcache保存这步数据
                   $mc->set($fromUsername."_data", $form_Content, 0, 3600);
                   
                   //回复绑定下一步操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入你的工号，输入exit退出操作！");
               	  echo $resultStr;
                  exit;  
              }
                
                //绑定第二步，输入工号
               if($last_do=="bd_1")
               {
                   //用memcache保存这步操作
                   $mc->set($fromUsername."_do", "bd_2", 0, 600);
                   
                   //用memcache保存这步数据，同时与上次数据合并，两个数据之间用||分割
                   $mc->set($fromUsername."_data", $last_data."||".$form_Content, 0, 3600);
                   
                   //回复绑定下一步操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType, "请输入你的手机号码，输入exit退出操作！");
               	  echo $resultStr;
                  exit;  
              }
                 //绑定第三步，输入手机号码
               if($last_do=="bd_2")
               {
                   //清空memcache动作
                   $mc->delete($fromUsername."_do");
                   
                   //清空memcache数据
                   $mc->delete($fromUsername."_data");
                   
                   //将之前保存数据变为数组；
                   list($roster_name,$roster_number,$roster_mp)=explode("||",$last_data."||".$form_Content);
                   
                   //判断资料是否完全吻合，并且openid为空即未绑定状态
                   
                   $roster_data=$mysql->getLine("select roster_id from roster where 
                   roster_name='$roster_name' and roster_number='$roster_number' and 
                   roster_mp='$roster_mp' and roster_openid='' and status=1");
                   
                   //资料一致确认绑定
                   
                   if($roster_data)
                   {
                       //将用户openid与该记录绑定
                       $roster_id=$roster_data["roster_id"];
 					   $sql = "update roster set roster_openid='$fromUsername' where roster_id=$roster_id";
 		               $mysql->runSql( $sql );
                        if( $mysql->errno() != 0 )
                        {
                            $back_str="绑定失败，可能是资料不正确或者该账号已经绑定，请重新输入BD进行绑定！";
                           
                        }
                        else
                        {
                   			$back_str="绑定成功！请输入“help”选择操作";
                        }
                       
                   }
                   else
                   {
                   		$back_str="绑定失败，可能是资料不正确或者该账号已经绑定，请重新输入BD进行绑定！";
                   }
                   
                   //回复绑定下一步操作提示
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType,  $back_str);
               	  echo $resultStr;
                  exit;  
              }
                //绑定用户操作结束
                
                   //用户自动回复
                  $msgType = "text";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgType,  "无法识别你的指令，需求帮助请输入help");
               	  echo $resultStr;
                  exit;  
                
             
            
            }
    
        }
    
    
  }
  else 
  {
          echo "";
          exit;
  }

//检测微信用户是否绑定
function check_user($fromUsername)
{
    //定义全局变量
    global $mysql;
    
    $roster_value=$mysql->getLine("select * from roster where roster_openid='$fromUsername'");
    //如果没有绑定
    if(!$roster_value)
    {
        
        return false;
    }
    //如果已经绑定（误取消重新关注员工）
    else
    {
		return $roster_value;        
    }

}
?>