<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/5
 * Time: 11:00
 */
/**
 * 邮件发送
 */
require __DIR__.'/../../vendor/autoload.php';
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;

class MailModel {
    public $errno = 0;
    public $errmsg = "";
    private $_db = null;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
    }

    public function send($uid, $title, $contents) {
        $query = $this->_db->prepare("select `email` from `user` where `id`=?");
        $query->execute(array(intval($uid)));
        $ret = $query->fetchAll();
        if (!$ret || count($ret) != 1) {
            $this->errno = -3003;
            $this->errmsg = "用户邮箱信息查找失败";
            return false;
        }
        $userEmail = $ret[0]['email'];
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $this->errno = -3004;
            $this->errmsg = "用户邮箱信息不符合标准，邮箱地址为：".$userEmail;
            return false;
        }
        $mail = new Message();
        $mail->setFrom('php-yaf-api<php-yaf-api@163.com>')
        ->addTo($userEmail)
        ->setSubject($title)
        ->setBody($contents);

        $mailer = new SmtpMailer([
            'host' => 'smtp.163.com',
            'username' => 'php-yaf-api',
            'password' => 'phpyafapi', // smtp 独立密码
            'secure' => 'ssl'
        ]);
        $rep = $mailer->send($mail);
        return true;
    }

}