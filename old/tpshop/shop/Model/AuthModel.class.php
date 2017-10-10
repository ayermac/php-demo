<?php
//goods模型类
namespace Model;
use Think\Model;

class AuthModel extends Model{
    //是子安path和level的制作，并完善信息记录的全部字段写入数据表
    function saveData($four){
        //1.根据已有的四个字段生成一个新纪录
        $newid=$this->add($four);
        
        //2.根据新纪录信息制作path和level
        //A.制作path
        if($four['auth_pid']==0){
            //①顶级权限
            $path=$newid;
        }else{
            //②非顶级权限
            $pinfo=$this->find($four['auth_pid']);//获得父级权限信息
            $p_path=$pinfo['auth_path'];//父级全路径
            $path=$p_path.'-'.$newid;
        }

        //B.制作level
        $level=substr_count($path, '-');//计算字符串中出现多少个子字符串
        $sql="update sw_auth set auth_path='$path',auth_level='$level' where auth_id='$newid'";
        return $this->execute($sql);
        
    }
}
?>