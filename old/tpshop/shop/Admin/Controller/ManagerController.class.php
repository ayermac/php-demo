<?php
namespace Admin\Controller;
use Tools\AdminController;
use Think\Verify;
/**
* 
*/
class ManagerController extends AdminController
{
	
	function login()
	{
		# code...
		// echo "登陆系统";
		//两个逻辑，展示表单，收集表单
		if (!empty($_POST)) {
			# code...
            //校验验证码
            $vry=new \Think\Verify();
            if($vry->check($_POST['captcha'])){
                //验证用户名和密码
                $manager=new \Model\ManagerModel();
                //checkNamePwd()验证成功返回整条记录，否则返回null
                $info=$manager->checkNamePwd($_POST['admin_user'],$_POST['admin_psd']);

                if($info){
                    
                    //给用户信息session持久化操作
                    session('admin_id',$info['mg_id']);
                    session('admin_name',$info['mg_name']);
                    session('admin_time',$info['mg_time']);
                    //页面跳转到后台页面
                    $this->redirect("Index/index");

                }else{
                	echo "用户名或密码错误";
                }
                
            }else{
            	echo "验证码错误";
            }
			
		}
			$this->display();
		
		
		
	}
	//退出系统
	function logout(){
		session(null);
		$this->redirect('login');

	}

	//输出验证码
	function verifyImg(){
		$cfg=array(
            'imageH'=>45,
            'imageW'=>100,
            'length'=>4,
            'fontSize'=>15,
            'fontttf'=>'4.ttf'

		);
		//实例化verify对象
		$very=new Verify($cfg);
		$very->entry();
	}
}
?>