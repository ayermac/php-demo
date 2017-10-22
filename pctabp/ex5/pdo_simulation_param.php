<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/22
 * Time: 15:11
 */
/**
 * PDO 模拟参数绑定的功能
 */
function bindParam(&$sql, $location, $var, $type) {
    // 参数类型
    switch ($type) {
        // 字符串
        default:
        case 'STRING':
            $var = addslashes($var);   // 转义
            $var = "'". $var ."'";     // 加上单引号，SQL语句中字符串插入必须加单引号
            break;
        case 'INTEGER':
        case 'INT':
            $var = (int)$var;          // 强制转换成 INT
        // 还可以增加更多类型...
    }

    for ($i = 1, $pos = 0; $i <= $location; $i++) {
        $pos += strpos($sql, '?', $pos + 1);
    }
    // 替换问号
    $sql = substr($sql, 0, $pos) .$var .substr($sql, $pos + 1);
}

$uid = 10086;
$pwd = "123456' or '1'='1";
//$pwd = "pwd";
$sql = "SELECT * FROM table WHEN uid = ? AND pwd = ?";
bindParam($sql, 1, $uid, 'INT');
bindParam($sql, 2, $pwd, 'STRING');
echo $sql;