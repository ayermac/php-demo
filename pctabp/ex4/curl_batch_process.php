<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/21
 * Time: 10:13
 */
/**
 * cURL 批处理
 * 允许同时或异步打开多个 cURL 连接
 */
//创建两个 cURL 资源
$ch1 = curl_init();
$ch2 = curl_init();

//指定 URL 和适当的参数
curl_setopt($ch1, CURLOPT_URL, "http://www.php.net/sites.php");
curl_setopt($ch1, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_URL, "http://www.php.net");
curl_setopt($ch2, CURLOPT_HEADER, 0);

//创建 cURL 批处理句柄
$mh = curl_multi_init();
//加上前面两个资源句柄
curl_multi_add_handle($mh, $ch1);
curl_multi_add_handle($mh, $ch2);
//预定一个状态变量
$active = null;

//执行批处理
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);
while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) != -1) {
        do {
            $mrc = curl_multi_exec($mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
    }
}

//关闭各个句柄
curl_multi_remove_handle($mh, $ch1);
curl_multi_remove_handle($mh, $ch2);
curl_multi_close($mh);