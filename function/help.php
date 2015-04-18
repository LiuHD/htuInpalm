<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 0:29
 */
include_once('../services/text_output.php');
function help(){
    $contentStr = "河师大掌中校园使用帮助\n-------------\n回复【入学指南】查看《新生入学指南》\n----\n回复【自习室】或[奋斗]表情开始查询自习室\n----\n回复【公选课】加关键字\n如\"公选课幸福\"查看《幸福学》课程信息\n----\n回复【点歌+歌名】如\"点歌稻香\"收听《稻香》\n--------\n你还可以回复任意关键字跟我聊天哦，无节操无下限，有问必答！(≧▽≦)
          <a href=\"http://www.henannu.edu.cn/#\">校园网</a> <a href=\"http://www.htu.cn/datongshe/\">大通社</a>";
    text_output($contentStr);
    exit;
}
