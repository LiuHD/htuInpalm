<?php
/**
 * Created by PhpStorm.
 * User: Dong
 * Date: 2015/4/8
 * Time: 22:04
 */
session_start();

if(!isset($_SESSION['username'])){
    if(isset($_POST['username'])){
        $conn=@mysqli_connect("localhost","root","root");
        @mysql_select_db('olive',$conn);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $pswd=mysqli_real_escape_string($conn,$_POST['pswd']);


        $query ="SELECT username FROM users WHER username ='$username' AND pswd='$pswd'";
        $result=mysql_query($query,$conn);

        if(mysql_num_rows($result)==1){
            $_SESSION['username']=@mysql_result($result,0,"username");
            echo "You have succesfully logged in.";
        }

    }else{
        include "login.html";
    }
}else{
    printf("Welcome back,%s!",$_SESSION['username']);
}
?>