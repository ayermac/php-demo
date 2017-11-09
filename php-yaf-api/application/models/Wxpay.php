<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 23:09
 */
/**
 * @name WxpayModel
 * @desc 微信支付功能封装
 */
$wxpayLibPath = dirname(__FILE__).'/../library/ThirdParty/WxPay/';
include_once( $wxpayLibPath.'WxPay.Api.php' );
include_once( $wxpayLibPath.'WxPay.Notify.php' );
include_once( $wxpayLibPath.'WxPay.NativePay.php' );
include_once( $wxpayLibPath.'WxPay.Data.php' );

class WxpayModel {

    public $code = 0;
    public $message = "";
    private $_db = null;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
    }

    /**
     * 创建订单
     * @param $itemId 商品Id
     * @param $uid 用户Id
     * @return bool
     */
    public function createbill($itemId, $uid) {
        $query = $this->_db->prepare("select * from `item` where `id`= ? ");
        $query->execute( array($itemId) );
        $ret = $query->fetchAll();
        if( !$ret || count($ret)!=1 ) {
            $this->code = -6003;
            $this->message = "找不到这件商品";
            return false;
        }
        $item = $ret[0];
        if( strtotime($item['etime']) <= time() ) {
            $this->code = -6004;
            $this->message = "商品已过期，不能购买";
            return false;
        }
        if( intval($item['stock'])<=0 ) {
            $this->code = -6005;
            $this->message = "商品库存不够，不能购买";
            return false;
        }

        /**
         * 成功创建账单后，需要扣去商品库存1件
         * TODO 此处应用用事务
         */
        try {
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // 开启事务
            $this->_db->beginTransaction();
            /**
             * 创建bill订单
             */
            $queryBill = $this->_db->prepare("insert into `bill` (`itemid`,`uid`,`price`,`status`) VALUES ( ?, ?, ?, 'unpaid') ");
            $retBill = $queryBill->execute( array( $itemId, $uid, intval($item['price']) ) );
            if ( !$retBill ) {
                $this->code = -6006;
                $this->message = "创建账单失败";
                throw new PDOException("创建账单失败");
            }
            /**
             * 更新库存
             */
            $queryItem = $this->_db->prepare("update `item` set `stock`=`stock`-1 where `id`= ? ");
            $retItem = $queryItem->execute( array( $itemId ) );
            if ( !$retItem ) {
                $this->code = -6007;
                $this->message = "更新库存失败";
                throw new PDOException("更新库存失败");
            }

            $this->_db->commit();

            return intval($this->_db->lastInsertId());
        } catch (Exception $e) {
            $this->_db->rollBack();
            $this->code = -6008;
            $this->message =  "Failed: " . $e->getMessage();
        }
    }

    /**
     * 生成二维码
     * @param $billId 订单Id
     * @return 支付 Url
     */
    public function qrcode( $billId ){
        $query = $this->_db->prepare("select * from `bill` where `id`= ? ");
        $query->execute( array($billId) );
        $ret = $query->fetchAll();
        if( !$ret || count($ret)!=1 ) {
            $this->code = -6009;
            $this->message = "找不到账单信息";
            return false;
        }
        $bill = $ret[0];

        $query = $this->_db->prepare("select * from `item` where `id`= ? ");
        $query->execute( array($bill['itemid']) );
        $ret = $query->fetchAll();
        if( !$ret || count($ret)!=1 ) {
            $this->code = -6010;
            $this->message = "找不到商品信息";
            return false;
        }
        $item = $ret[0];

        /**
         * 调用微信支付lib，生成账单二维码
         */
        $input = new WxPayUnifiedOrder();
        $input->SetBody( $item['name'] );
        $input->SetAttach( $billId );
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee( $bill['price'] );
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time()+86400*3));
        $input->SetGoods_tag( $item['name'] );
        $input->SetNotify_url("http://127.0.0.1/?c=wxpay&a=callback");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id( $billId );

        $notify = new NativePay();
        $result = $notify->GetPayUrl($input);
        $url = $result["code_url"];
        return $url;
    }

    /**
     * 支付成功后的回调
     */
    public function callback() {
        /**
         * 订单成功，更新账单
         * TODO 因为SK没有，没法与微信支付的服务端做Response确认，只能单方面记账
         */
        $xmlData = file_get_contents("php://input");
        if(substr_count($xmlData, "<result_code><![CDATA[SUCCESS]]></result_code>")==1 &&
            substr_count($xmlData, "<return_code><![CDATA[SUCCESS]]></return_code>")==1) {
            preg_match('/<attach>(.*)\[(\d+)\](.*)<\/attach>/i', $xmlData, $match);
            if(isset($match[2])&&is_numeric($match[2])) {
                $billId = intval( $match[2] );
            }

            preg_match('/<transaction_id>(.*)\[(\d+)\](.*)<\/transaction_id>/i', $xmlData, $match);
            if(isset($match[2])&&is_numeric($match[2])) {
                $transactionId = intval($match[2]);
            }
        }

        if(isset($billId) && isset($transactionId)) {
            $query = $this->_db->prepare("update `bill` set `transaction`=? ,`ptime`=? ,`status`='paid' where `id`=? ");
            $query->execute(array( $transactionId, date("Y-m-d H:i:s"), $billId ));
        }
    }
}