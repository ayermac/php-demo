<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 22:21
 */

/**
 * 个推推送服务接口
 * Class PushModel
 */

$pushLibPath = dirname(__FILE__).'/../library/ThirdParty/Getui/';
require_once( $pushLibPath . 'IGt.Push.php');
require_once( $pushLibPath . 'igetui/IGt.AppMessage.php');
require_once( $pushLibPath . 'igetui/IGt.APNPayload.php');
require_once( $pushLibPath . 'igetui/template/IGt.BaseTemplate.php');
require_once( $pushLibPath . 'IGt.Batch.php');
require_once( $pushLibPath . 'igetui/utils/AppConditions.php');

define('APPKEY','GBmeqZqemw5sWzzew5Ed54');
define('APPID','Oa0E2oIfyaAf8PxltSeLL');
define('MASTERSECRET','FEO1sTVvGW8NTDhMov9487');
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

class PushModel {
    public $code = 0;
    public $message = "";

    /**
     * 单推
     * @param int $cid
     * @param string $msg
     * @return bool
     */
    public function single($cid, $msg="测试内容") {
        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);

        $template = $this->_IGtTransmissionTemplateDemo( $msg );

        $message = new IGtSingleMessage();

        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600*12*1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
        //接收方
        $target = new IGtTarget();
        $target->set_appId(APPID);
        $target->set_clientId( $cid );
        //$target->set_alias(Alias);

        try {
            $rep = $igt->pushMessageToSingle($message, $target);
        }catch(RequestException $e){
            $requstId =$e->getRequestId();
            $rep = $igt->pushMessageToSingle($message, $target,$requstId);
            $this->code = -7003;
            $this->message = $rep['result'];
            return false;
        }
        return true;
    }

    /**
     * 多推
     * @param string $msg
     * @return bool
     */
    function toAll($msg){
        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);

        $template = $this->_IGtTransmissionTemplateDemo($msg);

        $message = new IGtAppMessage();
        $message->set_isOffline(true);
        //$message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
        $message->set_data($template);

        $appIdList=array(APPID);
        $phoneTypeList=array('ANDROID');
        //$provinceList=array('浙江','北京','上海');
        //$age = array("0000", "0010");


        $cdt = new AppConditions();
        $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
        //$cdt->addCondition(AppConditions::REGION, $provinceList);
        //$cdt->addCondition(AppConditions::TAG, $tagList);
        //$cdt->addCondition("age", $age);

        $message->set_appIdList($appIdList);
        $message->condition = $cdt;

        $igt->pushMessageToApp($message);
        return true;
    }

    /**
     * 消息推送模板
     * @param string $msg
     * @return IGtTransmissionTemplate
     */
    private function _IGtTransmissionTemplateDemo($msg = "测试内容") {
        $template =  new IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent( $msg );//透传内容

        $message = new IGtSingleMessage();

        //APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg=new DictionaryAlertMsg();
        $alertmsg->body="body";
        $alertmsg->actionLocKey="ActionLockey";
        $alertmsg->locKey="LocKey";
        $alertmsg->locArgs=array("locargs");
        $alertmsg->launchImage="launchimage";
        //IOS8.2 支持
        $alertmsg->title="Title";
        $alertmsg->titleLocKey="TitleLocKey";
        $alertmsg->titleLocArgs=array("TitleLocArg");

        $apn->alertMsg=$alertmsg;
        $apn->badge=7;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }
}