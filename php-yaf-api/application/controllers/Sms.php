<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/5
 * Time: 16:00
 */
/**
 * 短信处理
 */

class SmsController extends Yaf_Controller_Abstract {
    public function indexAction() {
    }

    /**
     * 短信发送操作
     * @return string
     */
    public function sendAction() {
        // 防止爬虫模拟操作
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            return Response::json(-2001, "请通过正确渠道提交");
        }

        $uid = $this->getRequest()->getPost("uid", '');
        $templateId = $this->getRequest()->getPost("template", '');
        if (!$uid || !$templateId) {
            return Response::json(-4002, "用户ID和模板ID均不能为空");
        }

        // 调用 Model，发送邮件
        $model = new SmsModel();

        if ($model->send($uid, $templateId)) {
            return Response::json(0, "发送成功");
        } else {
            return Response::json($model->code, $model->message);
        }
    }
}