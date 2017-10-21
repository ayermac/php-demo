<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/21
 * Time: 16:43
 */
/**
 * 邮件发送
 * 亲测可用
 */
// 报告所有 PHP 错误 (参见 changelog)
error_reporting(E_ALL);
require_once "SmtpMail.php";

// 如果想要使用 ssl 或 tls，应该在主机名地址前面添加访问协议ssl://或者是tls://
$host = "ssl://smtp.qq.com";
$port = 465;
$user = "";
$pass = "";

$from = "";
$to = "";
$subject = "Hello World!";
$content = "This is example mail for you";

$mail = new SmtpMail($host, $port, $user, $pass, null, true);
$result = $mail->sendMail($from, $to, $subject, $content);
