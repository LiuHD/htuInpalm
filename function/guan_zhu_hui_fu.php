<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 0:39
 */
include_once('../services/text_output.php');
function guan_zhu_hui_fu(){
    $contentStr = "欢迎关注\n[玫瑰]河师大掌中校园[玫瑰]\n-----使用帮助-----\n回复“入学指南”查看《新生入学指南》\n----\n回复“自习室”或[奋斗]表情开始查询自习室\n----\n回复“公选课”加关键字\n如\"公选课幸福\"查看《幸福学》课程信息\n----\n回复“点歌”加歌名\n如\"点歌稻香\"收听《稻香》";
    text_output($contentStr);
    exit;
}
