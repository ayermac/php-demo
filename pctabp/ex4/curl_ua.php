<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/20
 * Time: 21:11
 */
/**
 * cURL 模拟手机 UA
 */
@header('Content-type: text/html');

// 初始化
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://m.toutiao.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// 设置 http 头信息
$header = array('User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

// 请求 https 请加上以下两个参数，规避ssl的证书检查
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$output = curl_exec($ch);
curl_close($ch);

echo $output;