<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/7
 * Time: 22:59
 */
/**
 * User 模块测试脚本
 */
require_once __DIR__.'/../vendor/autoload.php';
use \Curl\Curl;

$host = "http://localhost/php-demo/php-yaf-api/public";
$curl = new Curl();
$uname = 'apitest_uname_'.rand(10000, 99999);
$pwd = 'apitest_pwd_'.rand(10000, 99999);

/**
 * 注册用户
 */
$curl->post($host . "/user/register", array(
    'uname' => $uname,
    'pwd' => $pwd
));
if ($curl->error) {
    die('Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n");
} else {
    // 对象转数组
    $rep = json_decode(json_encode($curl->response), true);
    if ($rep['code'] !== 0) {
        die('注册用户失败，注册接口异常。错误信息: ' . $rep['message'] . "\n");
    }
    echo "注册用户接口测试成功，注册新用户: {$uname}, 密码: {$pwd}\n";
}

/**
 * 用户登录
 */
$curl->post($host. "/user/login/?submit=1", array(
    'uname' => $uname,
    'pwd' => $pwd
));
if ($curl->error) {
    die('Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n");
} else {
    // 对象转数组
    $rep = json_decode(json_encode($curl->response), true);
    if ($rep['code'] !== 0) {
        die('用户登录失败，错误信息: ' . $rep['message'] . "\n");
    }
    echo "使用新用户账号密码测试登录接口成功，账号: {$uname}，密码: {$pwd}\n";
}

/**
 * 使用错误密码登录
 */
$curl->post($host. "/user/login/?submit=1", array(
    'uname' => $uname,
    'pwd' => $pwd.rand()
));
if ($curl->error) {
    die('Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n");
} else {
    // 对象转数组
    $rep = json_decode(json_encode($curl->response), true);
    if ($rep['code'] !== 0) {
        die('用户登录失败，错误信息: ' . $rep['message'] . "\n");
    }
    echo "使用新用户账号密码测试登录接口成功，账号: {$uname}，密码: {$pwd}\n";
}

echo "用户接口测试完毕。\n";