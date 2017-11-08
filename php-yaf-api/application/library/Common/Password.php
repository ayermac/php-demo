<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/8
 * Time: 22:12
 */
class Common_Password {
    const SALT = "I-Love_Imooc";

    /**
     * 为密码执行加密操作
     * @param $pwd 密码
     * @return string
     */
    public static function pwdEncode($pwd) {
        $pwd = md5(self::SALT.$pwd);
        return $pwd;
    }
}