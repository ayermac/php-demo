<?php
require_once '../include.php';
function checkAdmin($sql){
    return fetchOne($sql);
}

function checkLogined(){
	if($_SESSION['adminId']==""&&$_COOKIE['adminId']==""){
		alertMes("请先登录","login.php");
	}
}

function logout(){
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(),"",time()-1);
	}
	if(isset($_COOKIE['adminId'])){
		setcookie("adminId","",time()-1);
	}
	if(isset($_COOKIE['adminName'])){
		setcookie("adminName","",time()-1);
	}

	session_destroy();
    alertMes("成功退出","login.php");
	
}

function addAdmin(){
	$arr=$_POST;
	$arr['password']=md5($_POST['password']);
	if(insert("shop_admin",$arr)){
		$mes="添加成功!<br/><a href='addAdmin.php'>继续添加</a>|<a href='listAdmin.php'>查看管理员列表</a>";
	}else{
		$mes="添加失败!<br/><a href='addAdmin.php'>重新添加</a>";
	}
	return $mes;
}

function editAdmin($id){
    $arr=$_POST;
    $arr['password']=md5($_POST['password']);
    if(update("shop_admin",$arr,"id={$id}")){
        $mes="编辑成功!<br/><a href='listAdmin.php'>查看管理员列表</a>'";
    }else{
        $mes="编辑失败!<br/><a href='listAdmin.php'>查看管理员列表</a>";
    }
    return $mes;

}

function delAdmin($id){
    if(delete("shop_admin","id={$id}")){
        alertMes("删除成功!","listAdmin.php");
    }
}

function getAdminByPage($page,$pagesize=2){
    $sql="select * from shop_admin";
    global $totalRows;
    $totalRows=getResultNum($sql);
    global $totalPage;
    $totalPage=ceil($totalRows/$pagesize);
    if($page<1||$page==null||!is_numeric($page)) {
        $page=1;
    }
    if($page>$totalPage)$page=$totalPage;
    $offset=($page-1)*$pagesize;
    $sql="select id,username,email from shop_admin limit {$offset},{$pagesize}";
    $rows=fetchAll($sql);
    return $rows;

}

?>