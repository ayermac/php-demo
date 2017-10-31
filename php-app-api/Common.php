<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 15:09
 */
require_once 'Response.php';
require_once 'Db.php';

class Common{

    public $params;
    public $app;

    public function check()
    {
        $this->params['app_id']       = $appId = $_POST['app_id'] ?: '';
        $this->params['version_id']   = $version_id = $_POST['version_id'] ?: '';
        $this->params['version_mini'] = $version_mini = $_POST['version_mini'] ?: '';
        $this->params['did'] = $did   = $_POST['did'] ?: '';
        $this->params['encrypt_did']  = $encrypt_did = $_POST['encrypt_did'] ?: '';

        if (!is_numeric($appId) || !is_numeric($version_id)) {
            return Response::send(401, '参数不合法');
        }

        // 判定 APP 是否需要加密
        $this->app = $this->getApp($appId);
        if (!$this->app) {
            return Response::send(402, 'app_id 不存在');
        }

        if ($this->app['is_encryption'] && $encrypt_did != md5($did . $this->app['key'])) {
            return Response::send(403, '没有该权限');
        }
    }

    public function getApp($id)
    {
        $sql = "SELECT * FROM `app` WHERE id = ". $id . " AND status = 1 limit 1";
        $connect = Db::getInstance()->connect();
        $result = $connect->query($sql);
        return $result->fetch_assoc();
    }

    public function getversionUpgrade($appId)
    {
        $sql = "SELECT * FROM `version_upgrade` WHERE app_id = ". $appId . " AND status = 1 limit 1";
        $connect = Db::getInstance()->connect();
        $result = $connect->query($sql);
        return $result->fetch_assoc();
    }
}