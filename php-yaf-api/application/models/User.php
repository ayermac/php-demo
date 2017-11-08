<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/4
 * Time: 16:26
 */

/**
 * 用户 Model 类
 * Class UserModel
 */
class UserModel {
    public $code = 0;
    public $message = "";
    private $_dao = null;

    public function __construct() {
        $this->_dao = new Db_User();
    }

    public function login($uname, $pwd) {
        $userInfo = $this->_dao->find($uname);
        if (!$userInfo) {
            $this->code = $this->_dao->code();
            $this->message = $this->_dao->message();
            return false;
        }
        if ($this->_passwordGenerate($pwd) != $userInfo['pwd']) {
            $this->code = -1004;
            $this->message = "密码错误";
            return false;
        }
        return intval($userInfo[1]);
    }
    /**
     * 用户注册
     * @param $uname 用户名
     * @param $pwd 密码
     * @return bool
     */
    public function register($uname, $pwd) {
        // 检查用户名是否存在
        if (!$this->_dao->checkExists($uname)) {
            $this->code = $this->_dao->code();
            $this->message = $this->_dao->message();
            return false;
        }

        if (strlen($pwd) < 8) {
            $this->code = -1006;
            $this->message = "密码太短，请设置至少8位的密码";
            return false;
        } else {
            $password = $this->_passwordGenerate($pwd);
        }

        if (!$this->_dao->addUser($uname, $password, date('Y-m-d H:i:s'))) {
            $this->code = $this->_dao->code();
            $this->message = $this->_dao->message();
            return false;
        }
        return true;
    }

    /**
     * 为密码执行加密操作
     * @param $password 密码
     * @return string
     */
    private function _passwordGenerate($password) {
        $pwd = md5("salt-xxxxxxxx".$password);
        return $pwd;
    }
}