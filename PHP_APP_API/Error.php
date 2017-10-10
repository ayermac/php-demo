<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 15:41
 */
require_once('./common.php');
class ErrorLog extends Common {
    public function index()
    {
        $this->check();

        $errorLog = isset($_POST['error_log']) ? $_POST['error_log'] : '';
        if (!$errorLog) {
            return Response::send(401, '日志为空');
        }

        $sql = "insert into
					error_log(
						`app_id`,
						`did`,
						`version_id`,
						`version_mini`,
						`error_log`,
						`create_time`)
					values(
						".$this->params['app_id'].",
						'".$this->params['did']."',
						".$this->params['version_id'].",
						".$this->params['version_mini'].",
						'".$errorLog."',
						".time()."
					)";
        $connect = Db::getInstance()->connect();
        $result = $connect->query($sql);
        if($result) {
            return Response::send(200, '错误信息插入成功');
        } else {
            return Response::send(400, '错误信息插入失败');
        }
    }
}

$error = new ErrorLog();
$error->index();