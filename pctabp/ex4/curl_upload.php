<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/20
 * Time: 22:02
 */
/**
 * cURL 上传文件
 */
$url = "http://localhost/php-demo/pctabp/ex4/upload_output.php";

// 从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 CURLFile 发送。
//$post_data= array(
//    "foo" => "bar",
//    // 要上传的本地文件地址
//    "upload" => "@a.txt"
//);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

$cfile = curl_file_create(__DIR__.'\img.jpg', 'image/jpeg','test_name');
$post_data= array(
    "foo" => "bar",
    // 要上传的本地文件地址
    "test_file' " => $cfile
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
// 设置 CURLOPT_SAFE_UPLOAD 为 TRUE 可禁用 @ 前缀发送文件，以增加安全性
curl_setopt($ch, CURLOPT_SAFE_UPLOAD, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
echo $output;