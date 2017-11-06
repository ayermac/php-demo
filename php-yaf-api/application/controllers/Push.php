<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/6
 * Time: 22:21
 */

/**
 * 推送服务接口
 * Class PushController
 */
class PushController extends Yaf_Controller_Abstract {

    /**
     * 单独推送
     */
    public function singleAction() {
        if (!$this->_isAdmin()) {
            return Response::json(-7001, "需要管理员权限才能操作");
        }

        $cid = $this->getRequest()->getQuery( "cid", "" );
        $msg = $this->getRequest()->getQuery( "msg", "" );
        if (!$cid || !$msg) {
            return Response::json(-7002, "请输入推送用户的设备ID与要推送的内容");
        }

        // 调用 Model
        $model = new PushModel();
        if (!$model->single($cid, $msg)) {
            return Response::json(0, "推送成功");
        } else {
            return Response::json($model->code, $model->message);
        }
    }

    /**
     * 广播推送
     */
    public function toallAction() {
        if (!$this->_isAdmin()) {
            return Response::json(-7001, "需要管理员权限才能操作");
        }

        $msg = $this->getRequest()->getQuery( "msg", "" );
        if (!$msg) {
            return Response::json(-7004, "请输入要推送的内容");
        }

        // 调用 Model
        $model = new PushModel();
        if ($model->toAll($msg)) {
            return Response::json(0, "推送成功");
        } else {
            return Response::json($model->code, $model->message);
        }
    }

    private function _isAdmin(){
        return true;
    }
}