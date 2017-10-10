<?php
namespace Model;
use Think\Model;

class ManagerModel extends Model{
    function checkNamePwd($name,$pwd){
    	//先根据$name查询是否存在指定名字的记录
    	//find()方法如果没有查询到结果则返回Null,否则返回整条信息
    	$z=$this->where("mg_name='$name'")->find();
    	
    	
        //把查询到记录的密码与用户输入密码做比较
        if($z){
        	if($z['mg_pwd']==$pwd){
                return $z;
        	}
        }
        return null;
    }
}

?>