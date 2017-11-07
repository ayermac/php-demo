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
    private $_db = null;

    public function __construct() {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
    }

    public function login($uname, $pwd) {
        $query = $this->_db->prepare("select `pwd`, `id` from `user` where `name` = ?");
        $query->execute(array($uname));
        $ret = $query->fetchAll();
        if (!$ret || count($ret) != 1) {
            $this->code = -1003;
            $this->message = "用户名不存在";
            return false;
        }
        $userInfo = $ret[0];
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
        $query = $this->_db->prepare("select count(*) as c from `user` where `name` = ?");
        $query->execute(array($uname));
        $count = $query->fetchAll();

        if ($count[0]['c'] != 0) {
            $this->code = -1005;
            $this->message = "用户名已存在";
            return false;
        }

        if (strlen($pwd) < 8) {
            $this->code = -1006;
            $this->message = "密码太短，请设置至少8位的密码";
            return false;
        } else {
            $password = $this->_passwordGenerate($pwd);
        }

        $query = $this->_db->prepare("insert into `user` (`id`, `name`, `pwd`, `reg_time`) VALUES (null, ?, ?, ?)");
        $ret = $query->execute(array($uname, $password, date("Y-m-d H:i:s")));
        if (!$ret) {
            $this->code = -1006;
            $this->message = "注册失败";
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