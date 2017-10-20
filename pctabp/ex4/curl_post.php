<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/20
 * Time: 21:50
 */
/**
 * 使用 cURL 发送数据
 */
$url = "http://localhost/php-demo/pctabp/ex4/post_output.php";

$post_data = array(
    "foo" => "bar",
    "query" => "php",
    "action" => 'Submit'
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// 设置为 post
curl_setopt($ch, CURLOPT_POST, 1);
// 添加 post 变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
echo $output;