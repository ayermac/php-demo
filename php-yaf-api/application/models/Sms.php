<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/5
 * Time: 16:00
 */
/**
 * @name SmsModel
 * @desc 短信操作Model类,使用sms.cn服务，账号phpapi密码phpapi321
 * @author Jason
 */
class SmsModel {
    public $code = 0;
    public $message = "";
    private $_db = null;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
    }

    public function send($uid, $templateId) {
        if (!is_numeric($uid) || !is_numeric($templateId)) {
            $this->code = -4002;
            $this->message = "非法参数";
            return false;
        }

        $query = $this->_db->prepare("select `mobile` from `user` where `id` = ?");
        $query->execute(array(intval($uid)));
        $ret = $query->fetchAll();
        if (!$ret || count($ret) !=1) {
            $this->code = -4003;
            $this->message = "用户手机号信息查找失败";
            return false;
        }
        $userMobile = $ret[0]['mobile'];
        if( !$userMobile || !is_numeric($userMobile) || strlen($userMobile)!=11 ) {
            $this->code = -4004;
            $this->message = "用户手机号信息不符合标准，手机号为：".(!$userMobile?"空":$userMobile);
            return false;
        }

        $smsUid = "phpapi";
        $smsPwd = "phpapi321";
        $sms = new ThirdParty_Sms($smsUid, $smsPwd);

        // 消息内容
        $contentParam = array('code' => rand(1000, 9999));
        // 消息模板
        $template = $templateId;
        $result = $sms->send($userMobile, $contentParam, $template);
        if ($result['stat'] == '100') {
            /**
             * 成功则记录，用于日后对账
             */
            $query = $this->_db->prepare("insert into `sms_record` (`uid`, `contents`, `template`) VALUES (?, ?, ?)");
            $ret = $query->execute(array($uid, json_encode($contentParam), $template));
            if (!$ret) {
                /**
                 * TODO 应该返回true还是false，有待商榷
                 */
                $this->code = -4006;
                $this->message = "消息发送成功，但发送记录失败";
                return false;
            }
            return true;
        } else {
            $this->code = -4005;
            $this->message = '发送失败:'.$result['stat'].'('.$result['message'].')';
            return false;
        }
    }
}