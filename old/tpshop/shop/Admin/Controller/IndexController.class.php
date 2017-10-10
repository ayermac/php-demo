<?php
namespace Admin\Controller;
use Tools\AdminController;

/**
* 
*/
class IndexController extends AdminController
{
	//头部
	function head()
	{
		$this->display();
	}
	function left()
	{
		//思路：admin_id-->role_id-->auth_ids
		//获得管理员session持久化的登录信息
		
		$admin_id = session('admin_id');
		$admin_name = session('admin_name');
        //管理员信息
		$admin_info=D('Manager')->find($admin_id);
		$role_id=$admin_info['mg_role_id'];//角色的id信息
        //角色信息
		$role_info=D('Role')->find($role_id);
		$auth_ids=$role_info['role_auth_ids'];//权限的ids信息

		//全部权限信息
		//admin超级管理员获得所有权限
		if($admin_name==="admin"){
        $auth_infoA=D('Auth')->where("auth_level=0")->select();//顶级权限
		$auth_infoB=D('Auth')->where("auth_level=1")->select();//次顶级权限
		}else if($admin_name){
		$auth_infoA=D('Auth')->where("auth_level=0 and auth_id in ($auth_ids)")->select();
		$auth_infoB=D('Auth')->where("auth_level=1 and auth_id in ($auth_ids)")->select();
        }else{
        	$auth_infoA="";
        	$auth_infoB="";
        }
		$this->assign('auth_infoA',$auth_infoA);
		$this->assign('auth_infoB',$auth_infoB);

		$this->display();
	}

    function right()
	{
		$time=time();
		$this->assign('time',$time);
		$this->display();
	}

    function index()
	{
		$this->display();
	}

}
?>