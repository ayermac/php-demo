<?php
namespace Admin\Controller;
use Tools\AdminController;

class AuthController extends AdminController{
	//权限展示
	function showlist(){
		$info=D('Auth')->order("auth_path")->select();

		$this->assign('info',$info);
		$this->display();
	}
    //权限添加
	function add(){

	$auth=new \Model\AuthModel();
	if(!empty($_POST)){
        
        //表单只收集到4个信息，另外两个字段(path/level)需要计算
        //在saveData方法里面实现
        $z=$auth->saveData($_POST);
        //dump($_POST);
        if($z){
            	// $this->redirect(分组/控制器/操作方法,参数array,间隔时间,提示信息);//跳转
            	$this->redirect('showlist',array(),20,'权限添加成功');
            }else{
            	$this->redirect('add',array(),2,'权限添加失败');
            }

	}else{
    //显示父级权限
    $auth_infoA=$auth->where('auth_level=0')->select();
    $this->assign('auth_infoA',$auth_infoA);
    $this->display();
	}
}
	
}

?>