<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/10
 * Time: 11:39
 */
class Db{

    static private $_instance;
    static private $_connectSource;
    private $_dbConfig;

    private function __construct()
    {
        $this->_dbConfig = array(
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => '',
            'database' => 'video'
        );
    }

    static public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function connect()
    {
        if (!(self::$_connectSource)) {
            // 创建连接
            self::$_connectSource = new mysqli(
                $this->_dbConfig['host'],
                $this->_dbConfig['user'],
                $this->_dbConfig['password'],
                $this->_dbConfig['database']
            );

            if (self::$_connectSource->connect_error) {
                throw new Exception('Mysql connect error: '.mysqli_connect_error());
            }

            self::$_connectSource->set_charset('UTF8');
        }

        return self::$_connectSource;
    }

    public function __destruct()
    {
        $this->connect()->close();
    }
}