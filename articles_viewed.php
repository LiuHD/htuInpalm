<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/9
 * Time: 19:49
 */
include_once('conn.php');
session_start();
$pdo=get_pdo("localhost","root","root");

$article_id=mysqli_real_escape_string($_GET['id']);
$sql="SELECT title,content FROM articles WHERE id='$article_id'";
$result=$pdo->query($sql);

list($title,$content)=$pdo->mysql_fetch_row($result);
$articlelink="<a herf='article.php?id=$article_id'>$title</a>>";

if(!in_array($articlelink,$_SESSION['articles']))
    $_SESSION['articles'][]=$articlelink;
echo "<p>$title</p><p>$content</p>";
echo "recently viewed Articles";
echo "<ul>";
foreach($_SESSION['articles'] as $articlelink)
    echo "<li>$articlelink</li>";
echo "</ul>";