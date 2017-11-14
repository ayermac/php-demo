<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 22:45
 */

/**
 * IP 地址归属地查询功能
 * Class IpController
 */
class IpController extends Yaf_Controller_Abstract {

    public function indexAction() {

    }

    /**
     * 查询IP地址归属地
     * @return String
     */
    public function findAction() {
        $ip = $this->getRequest()->getQuery("ip", "");
        if( !$ip || !filter_var($ip, FILTER_VALIDATE_IP) ) {
            return Response::json(-5001, "请传递正确的IP地址");
        }

        // 调用 Model
        $model = new IpModel();
        if ($data = $model->get(trim($ip))) {
            return Response::json(0, "", $data);
        } else {
            return Response::json($model->code, $model->message);
        }
    }
}