<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/22
 * Time: 14:40
 */
/**
 * PDO 使用示例
 */
try {
    $dsn = "mysql:host=localhost; dbname=test";
    $db = new PDO($dsn, 'root', 'mysqlroot');
//    设置异常可捕获
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");
    $sql = "INSERT INTO tc0_log (name, content, ip, datetime) VALUES ('admin', '插入一条记录', '{$_SERVER['REMOTE_ADDR']}', now())";
    $db->exec($sql);

//    使用预处理语句
    $insert = $db->prepare("INSERT INTO tc0_log (name, content, ip, datetime) VALUES (?, ?, ?, now())");
    $insert->execute(array('admin', '插入一条记录1111', "{$_SERVER['REMOTE_ADDR']}"));
//    异常
    $insert->execute(array('admin', '插入一条记录2222', "{$_SERVER['REMOTE_ADDR']}", 8, 9));

    $sql = "SELECT name, content, ip, datetime FROM tc0_log";
    $query = $db->prepare($sql);
    $query->execute();
    var_dump($query->fetchAll(PDO::FETCH_ASSOC));


} catch (PDOException $err) {
    echo $err->getMessage();
}