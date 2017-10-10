<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/28
 * Time: 22:41
 */
session_start();
$action=$_GET['action'];


if ($action == "login"){
    $usr=login();
}elseif($action=="checkLoginState"){
    checkLoginState();
}

function login(){
    $user=$_GET['name'];
    $pass=$_GET['password'];

    if($user=="admin"&&$pass=="admin"){


        $content="<li>".$user."</li>"."<br/>"."<li>".$pass."</li>";

        $myfile = fopen("test.txt", "a") or die("Unable to open file!");
        fwrite($myfile, $content);
        fclose($myfile);
        echo "success";

    }else{
        echo "fail";
    }
}
function checkLoginState(){
    $user=$_GET['name'];
    $pass=$_GET['password'];
    $_SESSION["user"]=$user;
    $_SESSION["pass"]=$pass;
    if($_SESSION['user'] != ""&&$_SESSION['pass']!=""){
        echo "true";
    }else{
        echo "false";
    }
}

function logout(){
    session_abort();
}

?>