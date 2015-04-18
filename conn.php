<?php
function get_pdo($dbname,$user,$pswd)
{
    try {
        $dbtype = "mysql";
        $host = "localhost";
        $dns = "$dbtype:host=$host;dbname=$dbname";
        $pdo = new PDO($dns, $user, $pswd);
        $pdo->query("set NAMES UTF8");
    } catch (Exception $e) {
        echo "连接失败" . $e->getMessage();
    }
    return $pdo;
}

//$sql="CREATE TABLE articles(
//    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
//    title VARCHAR(50),
//    content MEDIUMTEXT NOT NULL,
//    PRIMARY key(id)
//)";
//$pdo->query($sql);
//echo "成功";
?>