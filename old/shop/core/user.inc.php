<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/29
 * Time: 10:47
 */

function addUser(){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    if(insert("shop_user",$arr)){
        $mes="添加成功!<br/><a href='addUser.php'>继续添加</a>|<a href='listUser.php'>查看用户列表</a>";
    }else{
        $mes="添加失败!<br/><a href='addUser.php'>重新添加</a>";
    }
    return $mes;
}

function getUserByPage($page,$pagesize=2){
    $sql="select * from shop_user";
    global $totalRows;
    $totalRows=getResultNum($sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pagesize);
    if($page<1||$page==null||!is_numeric($page)){
        $page=1;
    }
    if($page>$totalPage)$page=$totalPage;
    $offset=($page-1)*$pagesize;
    $sql="select id,username,email,sex from shop_user limit {$offset},{$pagesize}";
    $row=fetchAll($sql);
    return $row;

}

function editUser($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    $arr['regTime']=time();
    if(update("shop_user",$arr,"id={$id}")){
        $mes="修改成功!<br/><a href='listuser.php'>查看用户列表</a>";
    }else{
        $mes="修改失败!<br/><a href='listuser.php'>请重新修改</a>";
    }
    return $mes;
}
function delUser($id){
    if(delete("shop_user","id={$id}")){
        alertMes("删除成功!","listUser.php");
    }
}

function userlogout(){
    /*$_SESSION=array();
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name(),"",time()-1);
    }*/
    if(isset($_COOKIE['UserId'])){
        setcookie("UserId","",time()-1);
    }
    if(isset($_COOKIE['UserName'])){
        setcookie("UserName","",time()-1);
    }


    alertMes("成功退出","index.php");

}