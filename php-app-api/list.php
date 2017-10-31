<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 13:03
 */
require_once './Response.php';
require_once './File.php';

$file = new File();
$data = $file->cacheData('index_cron_cache');

if ($data) {
    return Response::send(200, '首页数据获取成功', $data);
} else {
    return Response::send(400, '首页数据获取失败', $data);
}

exit();
require_once './Db.php';
require_once './File.php';

$page = $_GET['page'] ?: 1;
$pageSize = $_GET['pageSize'] ?: 6;

if (!is_numeric($page) || !is_numeric($pageSize)) {
    return Response::send(401, '数据不合法');
}

$offset = ($page - 1) * $pageSize;
$sql = "SELECT * FROM video WHERE status = 1 ORDER BY orderby DESC LIMIT ".$offset.", ".$pageSize;

$cache = new File();
$videos = array();

if (!($videos = $cache->cacheData('index_list_cache'.$page.'-'.$pageSize))) {
    try {
        $query = Db::getInstance()->connect();
    } catch (Exception $e) {
        return Response::send(403, '数据库连接失败');
    }

    $result = $query->query($sql);
    while ($video = $result->fetch_assoc()) {
        $videos[] = $video;
    }

    if ($videos) {
        $cache->cacheData('index_list_cache'.$page.'-'.$pageSize, $videos, 1200);
    }
}

if ($videos) {
    return Response::send(200, '首页数据获取成功', $videos);
} else {
    return Response::send(400, '首页数据获取失败', $videos);
}

