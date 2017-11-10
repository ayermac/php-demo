<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/10
 * Time: 20:58
 */
/**
 * Article 模块测试脚本
 */
require_once __DIR__.'/../vendor/autoload.php';
use \Curl\Curl;

$host = "http://localhost/php-demo/php-yaf-api/public/article";
$curl = new Curl();
$title = '测试文章 TestId:'.rand(10000, 99999);
$contents = str_repeat("测试内容".rand(), 100);
$author = "yi".rand();
$cate = 1;

$curl->post($host."/add/?submit=1", array(
    'title' => $title,
    'contents' => $contents,
    'author' => $author,
    'cate' => $cate
));
/**
 * 新增文章
 */
if ($curl->error) {
    die( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n" );
} else {
    $rep = json_decode(json_encode($curl->response), true);
    if( $rep['code']!==0 ) {
        die( '发布文章失败。错误信息:'.$rep['message']."\n" );
    }
    $artId = $rep['data']['lastId'];
    echo "发布文章成功，文章ID：{$artId}\n";
}

/**
 * 文章编辑
 */
$curl->post( $host."/edit?submit=1&artId=".$artId, array(
    'title' => $title."Changed".rand(100,999),
    'contents'	=> $contents.rand(100,999),
    'author' => $author.rand(100,999),
    'cate'	=> $cate,
));
if ($curl->error) {
    die( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n" );
} else {
    $rep = json_decode(json_encode($curl->response), true);
    if( $rep['code']!==0 ) {
        die( '修改文章失败，错误信息:'.$rep['message']."\n" );
    }
    echo "修改文章成功！\n";
}

/**
 * 修改文章状态
 */
$curl->post( $host."/status?submit=1&artId=".$artId."&status=online", array());
if ($curl->error) {
    die( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n" );
} else {
    $rep = json_decode(json_encode($curl->response), true);
    if( $rep['code']!==0 ) {
        die( '修改文章状态失败，错误信息:'.$rep['message']."\n" );
    }
    echo '修改文章状态[online]成功！已修改为发布状态。'."\n";
}

/**
 * 删除文章
 */
$curl->post( $host."/del?submit=1&artId=".$artId, array());
if ($curl->error) {
    die( 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n" );
} else {
    $rep = json_decode(json_encode($curl->response), true);
    if( $rep['code']!==0 ) {
        die( '删除文章失败。错误信息:'.$rep['message']."\n" );
    }
    echo '删除文章成功！删除文章ID:'.$artId."\n";
}


echo "文章接口测试完毕。\n";

