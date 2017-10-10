<?php
namespace Tools;
use Think\Controller;

class AdminController extends Controller{
	function __construct(){
		//先执行父类构造方法，避免功能确实
		parent::__construct();

		//在此处做用户访问控制权限过滤
		//获得目前访问的“控制器”和“操作方法”，并连接为字符串称作“当前操作”
		//并使得“当前操作”和“权限列表作对比”
		$nowac=CONTROLLER_NAME.'-'.ACTION_NAME;
		//获得用户对应的“权限列表”信息
		//admin_id->role_id->auth_ac
		$admin_id=session('admin_id');
		$admin_name=session('admin_name');

		//没有登录系统的判断
		//有几个权限无需登录系统也可以访问
		$base_allow_ac="Manager-login,Manager-verifyImg";
		if(empty($admin_id)&&strpos($base_allow_ac,$nowac)===false){
			$group_url=__MODULE__;
			$js=<<<eof
			<script type="text/javascript">

			window.top.location.href="$group_url/Manager/login";
			</script>
eof;
        echo $js;
		}//window.top使得framset整个页面都跳转
		$admin_info=D('Manager')->find($admin_id);
		$role_id=$admin_info['mg_role_id'];
		$auth_info=D('Role')->find($role_id);

		$auth_ac=$auth_info['role_auth_ac'];

		//当前操作 是否是权限列表的信息判断
		//strpos($s1,$s2)判断$s1里边从左开始第一次出现$s2的下表信息，并返回该下表信息
		//有出现则返回0/1/2/3...没有返回false
		//具体限制
		//1当前操作没有出现在权限列比饿哦里
		//2当前操作没有出现在默认允许的权限列表里边
		//默认允许访问的权限列表
		$allow_ac="Manager-login,Manager-logout,Manager-verifyImg,Index-left,Index-right,Index-head,Index-index";

		//3当前用户还不是超级管理员admin
		//以上1.2.3条件同时满足则“没有访问权限”
		if(strpos($auth_ac,$nowac)===false&&strpos($allow_ac,$nowac)===false&&$admin_name!=='admin'){
			exit('没有访问权限');
		}
	}
}

?>