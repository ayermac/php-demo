<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/20
 * Time: 20:23
 */
/**
 * cURL 抓取图片
 */
header('Content-type: image/jpeg');
// 1. 初始化
$ch = curl_init();

// 2. 设置选项，包括 URL
curl_setopt($ch, CURLOPT_URL, "http://cdn.totoroc.cn/blog/2017_09/7b98b2b8c0ea63199f53e66d137a1b02.jpg");

// 将 curl_exec() 获取的信息以文件流的形式返回，而不是直接输出
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// 启用时会将头文件的信息作为数据流输出
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. 执行并获取内容
$output = curl_exec($ch);

$info = curl_getinfo($ch);
file_put_contents("./a.jpg", $output);
$size = filesize("./a.jpg");

// 校验下载数据是否完整
if ($size != $info['size_download']) {
    echo '下载数据不完整';
    // 尝试再次下载，最多三次不成功则放弃，或加入失败队列
} else {
// 下载数据完整，O(∩_∩)O~
    echo $output;
}

// 4. 释放 cURL 句柄
curl_close($ch);