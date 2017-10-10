<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/29
 * Time: 13:52
 */
require_once "../include.php";

$username=$_POST['username'];
$password=md5($_POST['password']);
//$username=addslashes($username);
$username=mysql_escape_string($username);
$verify=$_POST['verify'];
$verify1=$_SESSION['verify'];
$autoFlag=$_POST['autoFlag'];

if($verify==$verify1){
    $sql="select * from shop_user where username='{$username}' and password='{$password}'";
    $row=fetchOne($sql);
    if($row){
        if($autoFlag){
            setcookie("UserId",$row['id'],time()+7*24*3600);
            setcookie("UserName",$row['username'],time()+7*24*3600);
        }
        setcookie("UserId",$row['id']);
        setcookie("UserName",$row['username']);

        alertMes("登陆成功","index.php");
    }else{
        alertMes("登陆失败,请重新登陆!","login.php");

    }

}else{
    alertMes("验证码错误!","login.php");
}