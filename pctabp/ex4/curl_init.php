<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/19
 * Time: 22:50
 */
/**
 * 1. 初始化
 * 2. 设置选项，包括 URL
 * 3. 执行并获取 HTML 文档内容
 * 4. 释放 cURL 句柄
 */
// 1. 初始化
$ch = curl_init();

// 2. 设置选项，包括 URL
curl_setopt($ch, CURLOPT_URL, "http://www.php.net");

// 将 curl_exec() 获取的信息以文件流的形式返回，而不是直接输出
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// 启用时会将头文件的信息作为数据流输出
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 执行并获取 HTML 文档内容
$output = curl_exec($ch);

// 4. 释放 cURL 句柄
curl_close($ch);
echo $output;