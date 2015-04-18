<?php

/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 1:02
 */
include_once('../services/news_outpu.php');
class freshman
{
    function freshman_zhinan(){
        $mc->set($fromUsername."_do", "fy_0", 0, 600);
        $msgType = "news";
        $ArticleCount = "5";
        $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);

        $Title1 = "河师大新生入学指南";
        $Discription1 = "";
        $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
        $Url1 = "";
        $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

        $Title2 = "一、新生入学篇";
        $Discription2 = "";
        $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
        $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000016&itemidx=1&sign=6561122042d8ea3f7e2d57f5dfb185d9#wechat_redirect";
        $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

        $Title3 = "二、入校购物篇";
        $Discription3 = "";
        $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
        $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000021&itemidx=1&sign=dc72f8b504de981813859aac63f3ffc0#wechat_redirect";
        $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

        $Title4 = "三、关于助学贷款";
        $Discription4 = "";
        $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
        $Url4 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=1&sign=a6c69419b5b04d1d8118c5afb8b59778#wechat_redirect";
        $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

        $Title5 = "回复“fy”看下一页\n回复“帮助”查看帮助";
        $Discription5 = "";
        $PicUrl5 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
        $Url5 = "";
        $item5 = sprintf($itemTpl, $Title5, $Discription5, $PicUrl5, $Url5);

        $resultStr = $news_fore.$item1.$item2.$item3.$item4.$item5.$news_end;

        echo $resultStr;
        exit;

    else
        if ($textConent == "fy")     //翻页
        {
            if ($last_do == "fy_0")  //第一次翻页
            {
                $mc->set($fromUsername . "_do", "fy_1", 0, 600);
                $msgType = "news";
                $ArticleCount = "5";
                $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);


                $Title1 = "河师大新生入学指南";
                $Discription1 = "";
                $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
                $Url1 = "";
                $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

                $Title2 = "四、关于吃饭";
                $Discription2 = "";
                $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=2&sign=61526b341798b62c487811eeebc37461#wechat_redirect";
                $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

                $Title3 = "五、关于图书馆和教学楼和校区";
                $Discription3 = "";
                $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=3&sign=8e2c81377de1d0566ed82c243cca2e79#wechat_redirect";
                $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

                $Title4 = "六、公交和银行系列";
                $Discription4 = "";
                $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url4 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000026&itemidx=4&sign=0652bed5f7a513185565d7f291bfe80e#wechat_redirect";
                $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

                $Title5 = "回复“fy”查看最后一页\n回复“帮助”查看帮助";
                $Discription5 = "";
                $PicUrl5 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
                $Url5 = "";
                $item5 = sprintf($itemTpl, $Title5, $Discription5, $PicUrl5, $Url5);

                $resultStr = $news_fore . $item1 . $item2 . $item3 . $item4 . $item5 . $news_end;
                $return = new Saestorage;
                $return->write('hsdzzxy', 'text.txt', $resultStr);
                echo $resultStr;
                exit;
            }

            if ($last_do == "fy_1")  //第二次翻页
            {
                //清空memcache动作
                $mc->delete($fromUsername . "_do");
                $msgType = "news";
                $ArticleCount = "4";
                $news_fore = sprintf($newsTpl_fore, $fromUsername, $toUsername, time(), $msgType, $ArticleCount);


                $Title1 = "河师大新生入学指南";
                $Discription1 = "";
                $PicUrl1 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/201308010023.png";
                $Url1 = "";
                $item1 = sprintf($itemTpl, $Title1, $Discription1, $PicUrl1, $Url1);

                $Title2 = "七、社团推荐";
                $Discription2 = "";
                $PicUrl2 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url2 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000038&itemidx=1&sign=6bdace6dbd99fdc7cbbb63a0072cb79d#wechat_redirect";
                $item2 = sprintf($itemTpl, $Title2, $Discription2, $PicUrl2, $Url2);

                $Title3 = "八、周末出行";
                $Discription3 = "";
                $PicUrl3 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/7e3e6709c93d70cfd4764fd8f8dcd100bba12b53.jpg";
                $Url3 = "http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDEyMTYyMw==&appmsgid=10000038&itemidx=2&sign=9ff47c89986a5df571095e1b3d16d200#wechat_redirect";
                $item3 = sprintf($itemTpl, $Title3, $Discription3, $PicUrl3, $Url3);

                $Title4 = "回复“帮助”查看帮助";
                $Discription4 = "";
                $PicUrl4 = "http://ilovesun1993-hsdzzxy.stor.sinaapp.com/%E5%9B%BE%E7%89%87/%E5%9B%BE%E6%A0%87/fanyetubiao.png";
                $Url4 = "";
                $item4 = sprintf($itemTpl, $Title4, $Discription4, $PicUrl4, $Url4);

                $resultStr = $news_fore . $item1 . $item2 . $item3 . $item4 . $news_end;
                $return = new Saestorage;
                $return->write('hsdzzxy', 'text.txt', $resultStr);
                echo $resultStr;
                exit;
            }
        }
    }

}