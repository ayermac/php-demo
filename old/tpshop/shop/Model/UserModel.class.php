<?php
//goods模型类
namespace Model;
use Think\Model;

class UserModel extends Model{
	//开启批量验证
	protected $patchValidate=true;
	//protected $_validate
	//通过定义$_validate成员,设置表单验证的规则，自动验证
    protected $_validate=array(
        // array(字段,规则，错误提示，验证条件，附加规则，验证时间);
        //①验证用户名，必须填写并且唯一
        array('username','require','用户名必须填写'),
        array('username','','该用户名已经被占用',0,'unique'),
        //②验证密码不为空
        array('password','require',"密码不能为空"),
        //③验证两次密码是否 一致
        array('password2','require',"确认密码不能为空"),
        array('password2','password',"两次密码不一致",0,'confirm'),
        //③邮箱验证
        array('user_email','email',"邮箱格式不正确",2),
        //④user_qq验证，数组组成，5-12位
        array('user_qq','number','qq必须是数字'),
        array('user_qq','5,12','位数在5-12之间',0,'length'),
        //⑤验证学历，必须选择一个
        array('user_xueli','2,5','学历必须选择一个',0,'between'),
        //array('user_xueli','2,3,4,5','学历必须选择一个',0,'in')

        //⑥爱好验证，必须选择两项或以上
        //callback验证
        array('user_hobby','check_hobby','爱好必须选择两项或以上',1,'callback')
    );
    //参数$arg代表被验证的表单信息
    function check_hobby($arg){
    	if(count($arg)<2){
    		return false;
    	}else{
    		return true;
    	}
    }
}
?>