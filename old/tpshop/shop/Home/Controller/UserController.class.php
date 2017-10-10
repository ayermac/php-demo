<?php
namespace Home\Controller;
use Think\Controller;
//前台用户控制器
/**
* 父类Controller
*/
class UserController extends Controller{
   function login(){
   	// echo " I am logining!";

   	//调用view视图
   	$this->display();//展现视图与当前操作名一样
   	// $this->display('register');//访问其他名字模板文件
    // $this->display('Goods/detail');//访问其他控制器下的模板文件
   } 
   //无验证注册功能
   function register1(){
   	// echo "registering";
      $info=D('User');
      if(!empty($_POST)){
         $_POST['user_hobby']=implode(',', $_POST['user_hobby']);
         $_POST['user_time']=time();
         $z=$info->add($_POST);
         //dump($z);
         if($z){
            $this->redirect('/index/index',array(),2,"注册成功");
         }else{
            $this->redirect('/index/index',array(),2,"注册失败");
         }
      }else{
   	$this->display();
   }
   }
   //开启自动验证注册功能
   function register(){
      $user=new \Model\UserModel();

      if(!empty($_POST)){
         //收集表单、过滤表单信息、非法字段过滤、表单自动验证
         $info=$user->create();
         //create方法自动接收$_POST传递过来的表单数据
         //通过create方法判断返回值是否成功
         if($info){
            $info['user_hobby']=implode(',',$info['user_hobby']);
            $info['user_time']=time();
            $z=$user->add($info);
            if($z){
               //$this->redirect('Index/index');
               $this->success('注册成功');
            }
         }else{

            $this->assign('errorinfo',$user->getError());
         }

      }
      $this->display();
   }

   function loginCheck(){
      echo "Welcom jason";
   }
}
?>