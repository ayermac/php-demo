<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 15:09
 */
require_once 'Common.php';
class Init extends Common{

    public function index()
    {
        $this->check();
        // 获取版本升级信息
        $versionUpgrade = $this->getversionUpgrade($this->app['id']);
        if ($versionUpgrade) {
            if ($versionUpgrade['type'] && $this->params['verssion_id'] < $versionUpgrade['verssion_id']) {
                $versionUpgrade['is_upload'] = $versionUpgrade['type'];
            } else {
                $versionUpgrade['is_upload'] = 0;
            }
            return Response::send(200, '版本数据升级成功', $versionUpgrade);
        } else {
            return Response::send(400, '版本升级信息获取失败');
        }
    }
}

$init = new Init();
$init->index();