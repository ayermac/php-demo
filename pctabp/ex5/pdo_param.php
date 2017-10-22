<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/22
 * Time: 15:03
 */
/**
 * PDO 参数绑定
 */
try {
    $dsn = "mysql:host=localhost; dbname=test";
    $db = new PDO($dsn, 'root', 'mysqlroot');
//    设置异常可捕获
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'UTF8'");

    $calories = 150;
    $colour = 'red';
    $sth = $db->prepare("SELECT name, colour, calories
                        FROM fruit
                        WHERE calories < :calories AND colour = :colour");
    $sth->bindParam(':calories', $calories, PDO::PARAM_INT);
    $sth->bindParam(':colour', $colour, PDO::PARAM_STR, 12);
    $sth->execute();

    $sth = $db->prepare("SELECT name, colour, calories
                        FROM fruit
                        WHERE calories < ? AND colour = ?");
    $sth->bindParam(1, $calories, PDO::PARAM_INT);
    $sth->bindParam(2, $colour, PDO::PARAM_STR, 12);
    $sth->execute();

} catch (PDOException $err) {
    echo $err->getMessage();
}
