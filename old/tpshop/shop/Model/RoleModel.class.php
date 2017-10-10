<?php
//goods模型类
namespace Model;
use Think\Model;

class RoleModel extends Model{
    function saveAuth($authid,$role_id){
    	//把$authid由array变为string
        $authids=implode(',', $authid);

        $auth_info=D('Auth')->select($authids);
        $s="";
        
        foreach ($auth_info as $k => $v) {
        	# code...
        	if(!empty($v['auth_c'])&&!empty($v['auth_a'])){
        		$s.=$v['auth_c']."-".$v['auth_a'].",";
        	}
        
        }
        $s=rtrim($s,',');

        $sql="update sw_role set role_auth_ids='$authids',role_auth_ac='$s' where role_id='$role_id'";
        return $this->execute($sql);
        
      
    }
}
?>