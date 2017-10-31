<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 14:20
 */
// 让 crontab 定时执行的脚本程序  */5 * * * * php cron.php
// 获取 video 中的数据
require_once './Db.php';
require_once './File.php';

$sql = "SELECT * FROM video WHERE status = 1 ORDER BY orderby DESC ";

try {
    $query = Db::getInstance()->connect();
} catch (Exception $e) {
    file_put_contents('./logs/'.date('y-m-d').'.txt', $e->getMessage(), FILE_APPEND);
    return;
}

$result = $query->query($sql);
$videos = array();
while ($video = $result->fetch_assoc()) {
    $videos[] = $video;
}

$file = new File();
if ($videos) {
    $file->cacheData('index_cron_cache', $videos);
} else {
    file_put_contents('./logs/'.date('y-m-d').'.txt', '没有相关数据', FILE_APPEND);
}
return;