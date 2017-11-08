<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/8
 * Time: 21:12
 */
class Err_Map {
    const ERRMAP  = array(
        1001 => '请通过正确渠道提交',
        1002 => '用户名和密码不能为空',
        1003 => '用户名不存在',
        1004 => '密码错误',
        1005 => '用户名已存在',
        1006 => '注册失败'
    );

    public static function get($code) {
        if (isset(self::ERRMAP[$code])) {
            return array('code'=>(0-$code), 'message'=>self::ERRMAP[$code]);
        }
        return array('code'=>(0-$code), 'message'=>"undefined this error number.");
    }
}