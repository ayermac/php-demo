<?php
namespace Admin\Controller;
use Tools\AdminController;

class RoleController extends AdminController{
	//列表展示
	function showlist(){
		$info=D('Role')->select();

		$this->assign('info',$info);
		$this->display();
	}

	function fenpei($role_id){
		$role=new \Model\RoleModel();
		if(!empty($_POST)){
            $z=$role->saveAuth($_POST['authid'],$_POST['role_id']);

            if($z){
                $this->redirect('showlist',array(),2,"分配成功");
            }else{
                $this->redirect('fenpei',array('role_id'=>$role_id),2,"分配失败");
            }
		}else{

		//根据role_id获取被分配的角色信息
		$role_info=$role->find($role_id);
        //获得已经拥有的权限信息并变为Array
        $have_auth=explode(',', $role_info['role_auth_ids']);

		//获得被分配的全部权限，并传递给模板使用

		$auth_infoA=D('Auth')->where('auth_level=0')->select();
		$auth_infoB=D('Auth')->where('auth_level=1')->select();

		$this->assign('auth_infoA',$auth_infoA);
		$this->assign('auth_infoB',$auth_infoB);
		$this->assign('role_info',$role_info);
		$this->assign('have_auth',$have_auth);
		$this->display();
	}
	}

}

?>