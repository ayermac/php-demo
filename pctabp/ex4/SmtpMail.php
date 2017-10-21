<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/21
 * Time: 16:02
 */
/**
 * SMTP 邮件发送类
 */

class SmtpMail {

//    需要连接的 SMTP 服务器
    private $host;
//    SMTP 服务器端口，默认为25
    private $port;
//    登录 SMTP 服务器所要使用的用户名
    private $user;
//    登录 SMTP 服务器所要使用的密码
    private $pass;
//    是否开启调试模式
    private $debug;
//    与 SMTP 服务器连接的句柄
    private $sock;
//    邮件发送格式，0 = 普通文本，1 = HTML
    private $mail_format;

    public function __construct($host = null, $port = 25, $user, $pass, $format = 0, $debug = false)
    {
        $this->host        = $host;
        $this->port        = $port;
        // 用户名和密码不使用 base64 加密可能会登录失败
        $this->user        = base64_encode($user);
        $this->pass        = base64_encode($pass);
        $this->mail_format = $format;
        $this->debug       = $debug;

        // 连接 SMTP 服务器
        $this->sock = fsockopen($this->host, $this->port, $errno, $errstr, 30);
        if (!$this->sock) {
            exit("Error number: $errno, Error message: $errstr\n");
        }
        // 取得服务器的返回信息
        $response = fgets($this->sock);
        // 返回信息中包含220，则成功连接到服务器
        if (strstr($response, "220") === false) {
            exit("server error: $response\n");
        }
    }

    /**
     * 是否显示调试信息
     * @param $message
     */
    private function showDebug($message)
    {
        if ($this->debug) {
            echo "<p>Debug: $message</p>\n";
        }
    }

    /**
     * 向服务器发送命令并执行
     * @param $cmd 命令
     * @param $return_code 返回码
     * @return bool
     */
    private function sendCommand($cmd, $return_code)
    {
        fwrite($this->sock, $cmd);

        $response = fgets($this->sock);
        // 服务器返回的消息中存在 $return_code 命令则执行成功
        if (strstr($response, "$return_code") === false) {
            $this->showDebug($response);
            return false;
        }
        return true;
    }

    /**
     * 判断邮件地址是否合法
     * @param $email
     */
    private function isEmail($email)
    {
        $pattren = "/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/";
        if (preg_match($pattren, $email, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 发送邮件
     * @param $from 发送邮件者
     * @param $to 接收邮件者
     * @param $subject 邮件主题
     * @param $body 邮件内容
     * @return bool
     */
    public function sendMail($from, $to, $subject, $body)
    {
        if (!$this->isEmail($from) || !$this->isEmail($to)) {
            $this->showDebug("Please enter valid from/to email.");
            return false;
        }

        if (empty($subject) || empty($body)) {
            $this->showDebug("Please enter subject/content");
            return false;
        }

        // 发送的主要内容，包括发信人、收信人、邮件主题、邮件内容、邮件格式等。
        $detail = "From:". $from. "\r\n";
        $detail .= "To:". $to. "\r\n";
        $detail .= "Subject:". $subject. "\r\n";

        if ($this->mail_format == 1) {
            $detail .= "Content-Type: text/html;\r\n";
        } else {
            $detail .= "Content-Type: text/plain;\r\n";
        }

        $detail .= "charset = utf-8\r\n\r\n";
        $detail .= $body;

        // 发送 SMTP 协议命令，用来发送邮件，详细命令可以网上查阅
        $this->sendCommand("HELO smtp.qq.com\r\n", 250);
        $this->sendCommand("AUTH LOGIN\r\n", 334);
        $this->sendCommand($this->user."\r\n", 334);
        $this->sendCommand($this->pass."\r\n", 235);
        $this->sendCommand("MAIL FROM: <" . $from . ">\r\n", 250);
        $this->sendCommand("RCPT TO: <" . $to . ">\r\n", 250);
        $this->sendCommand("DATA\r\n", 354);
        $this->sendCommand($detail."\r\n.\r\n", 250);
        $this->sendCommand("QUIT\r\n", 221);

        return true;
    }
}