<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/8
 * Time: 20:28
 */
class Db_Base {
    public static $code = 0;
    public static $message = "";
    public static $db;

    public static function getDb() {
        if (self::$db == null) {
            self::$db = new PDO("mysql:host=127.0.0.1;dbname=php_yaf_api", "root", '');
        }
        return self::$db;
    }

    public function code() {
        return self::$code;
    }

    public function message() {
        return self::$message;
    }
}