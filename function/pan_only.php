<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/12
 * Time: 0:49
 */
include_once('../services/text_output.php');
function ($textConent)
{
    if ($textConent == "丫头"){      //丫头专属
        $contentStr = "死生契阔 与子成说\n执子之手 与子偕老\n             [爱情]";
        text_output($contentStr);
        exit;
    } else if ($textConent == "潘丽苹"){      //丫头专属
        $contentStr = "我媳妇！\n    [爱情]";
        text_output($contentStr);
        exit;
    }
}