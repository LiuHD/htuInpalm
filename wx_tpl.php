<?php

$textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>0</FuncFlag>
            </xml>";   
$newsTpl_fore = "<xml>
           <ToUserName><![CDATA[%s]]></ToUserName>
           <FromUserName><![CDATA[%s]]></FromUserName>
           <CreateTime>%s</CreateTime>
           <MsgType><![CDATA[%s]]></MsgType>
           <ArticleCount>%s</ArticleCount>
           <Articles>";
           
$news_end ="</Articles>
           <FuncFlag>0</FuncFlag>
           </xml>";
$itemTpl ="<item>
           <Title><![CDATA[%s]]></Title> 
           <Description><![CDATA[%s]]></Description>
           <PicUrl><![CDATA[%s]]></PicUrl>
           <Url><![CDATA[%s]]></Url>
           </item>";

    
$musicTpl = "<xml>
             <ToUserName><![CDATA[%s]]></ToUserName>
             <FromUserName><![CDATA[%s]]></FromUserName>
             <CreateTime>%s</CreateTime>
             <MsgType><![CDATA[%s]]></MsgType>
             <Music>
             <Title><![CDATA[%s]]></Title>
             <Description><![CDATA[%s]]></Description>
             <MusicUrl><![CDATA[%s]]></MusicUrl>
             <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
             </Music>
             <FuncFlag>0</FuncFlag>
             </xml>";
?>