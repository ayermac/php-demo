<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/22
 * Time: 16:05
 */
/**
 * PDO 事务操作
 * 使用事务，数据表类型需要为 InnoDB
 */
try {
    $dsn = "mysql:host=localhost; dbname=test";
    $db = new PDO($dsn, 'root', 'mysqlroot');
//    设置异常可捕获
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");

    $db->beginTransaction(); // 开启事务
    $db->exec("INSERT INTO tc0_log (name, content, ip, datetime) VALUES ('admin', '插入一条记录', '{$_SERVER['REMOTE_ADDR']}', now())");// 执行一个正常的 SQL 语句
    $db->exec("INSERT INTO staff xxx"); // 这条语句是错误的，所以无法执行
    $db->commit();

} catch (PDOException $err) {
    $db->rollBack();
    echo $err->getMessage();
}