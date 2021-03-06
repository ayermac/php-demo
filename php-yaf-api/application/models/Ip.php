<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 22:46
 */

/**
 * 调用第三方 IP 地址归属地查询 SDK
 * Class IpModel
 */
class IpModel {
    public $code = 0;
    public $message = "";

    /**
     * 根据 IP 地址获取详细地址
     * @param string $ip
     * @return mixed|string
     */
    public function get($ip) {
        $rep = ThirdParty_Ip::find($ip);
        return $rep;
    }
}