<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 23:09
 */
/**
 * 微信支付功能
 */
$qrcodeLibPath = dirname(__FILE__).'/../library/ThirdParty/Qrcode/';
require_once ($qrcodeLibPath.'Qrcode.php' );

class WxpayController extends Yaf_Controller_Abstract {
    public function indexAction() {
    }

    /**
     * 创建订单
     * @return string
     */
    public function createbillAction() {
        $itemid = $this->getRequest()->getQuery("itemid", "");
        if (!$itemid) {
            return Response::json(-6001, "请传递正确的商品ID");
        }

        /**
         * 检查是否登录
         */
        session_start();
        if(!isset($_SESSION['user_token_time']) || !isset($_SESSION['user_token']) || !isset($_SESSION['user_id'])
            || md5( "salt".$_SESSION['user_token_time'].$_SESSION['user_id'] ) != $_SESSION['user_token']) {
            return Response::json(-6002, "请先登录后操作");
        }

        // 调用 Model
        $model = new WxpayModel();
        if ($data = $model->createbill($itemid, $_SESSION['user_id'])) {
            return Response::json(0, "", $data);
        } else {
            return Response::json($model->code, $model->message);
        }
    }

    /**
     * 返回二维码
     * @return string
     */
    public function qrcodeAction() {
        $billId = $this->getRequest()->getQuery("billid", '');
        if (!$billId) {
            return Response::json(-6008, "账单ID必须传递");
        }

        // 调用Model
        $model = new WxpayModel();
        if ($data = $model->qrcode($billId)) {
            /**
             * 生成二维码
             */
            QRcode::png($data);
        } else {
            return Response::json($model->code, $model->message);
        }
    }

    /**
     * 支付成功后的回调
     */
    public function callbackAction() {
        $model = new WxpayModel();
        $model->callback();
        return Response::json(0, "支付成功");
    }
}