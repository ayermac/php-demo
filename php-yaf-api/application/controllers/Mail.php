<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/4
 * Time: 23:02
 */

/**
 * 邮件处理
 * Class MailController
 */
$libPath = dirname(__FILE__).'/../library/';
require_once ($libPath . 'common.php');

class MailController extends Yaf_Controller_Abstract {

    public function indexAction() {

    }

    public function sendAction() {
        // 防止爬虫模拟操作
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            echo json(-2001, "请通过正确渠道提交");
            return false;
        }

        // 获取参数
        $uid = $this->getRequest()->getPost("uid", '');
        $title = $this->getRequest()->getPost("title", '');
        $contents = $this->getRequest()->getPost("contents", '');

        if (!$uid || !$title || !$contents) {
            echo json(-3002, "用户ID、邮件标题、邮件内容均不能为空");
            return false;
        }

        $model = new MailModel();
        if ($model->send(intval($uid), trim($title), trim($contents))) {
            echo json(0, "");
        } else {
            echo json($model->errno, $model->errmsg);
        }
        return true;
    }
}