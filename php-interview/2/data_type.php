<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 21:15
 */
/**
 * PHP字符串的定义方式和各自区别
 * 定义方式：
 * * 单引号
 * * 双引号
 * * heredoc 和 newdoc
 * 区别：
 * * 单引号不能解析变量
 * * 单引号不能解析转义字符，只能解析单引号和反斜线本身
 * * 变量和变量、变量和字符串、字符串和字符串之间可以用.连接
 *
 * * 双引号可以解析变量，变量可以使用特殊字符和{}包含
 * * 双引号可以解析所有转义字符
 * * 也可以用.连接
 * *
 * * 单引号效率更高
 */
$a = 'a';
$str = 'a b c d e f $a g h';
echo $str . "\n";

$str = "a b c d e f '{$a}' g h";
echo $str . "\n";

/**
 * Heredoc 类似于双引号
 * Newdoc 类似于单引号
 */
// Heredoc
$str = <<< EOT
a b c d e f '{$a}' g h
EOT;
echo $str . "\n";

// Newdoc
$str = <<< 'EOT'
a b c d e f $a g h
EOT;
echo $str . "\n";


/**
 * 浮点类型不能运用到比较运算中
 */
$a = 0.1;
$b = 0.7;
if ($a + $b == 0.8) {
//    false = 0.7999....
}

/**
 * 布尔类型
 * FALSE 的七种情况
 * 整型0，浮点0.0，布尔false，字符串''，字符串'0'，数组array()，NULL
 */


/**
 * 数组类型
 * 超全局数组
 * $GLOBALS、$_GET、$_POST、$_REQUEST、$_SESSION、$_COOKIE、$_SERVER、$_FILES、$_ENV
 * $GLOBALS 包含了之后的所有
 * $_REQUEST 包含了 $_GET、$_POST、$_COOKIE，$_REQUEST 尽量少用，安全性低
 */
$_SERVER['SERVER_ADDR'];  // 服务器 IP 地址
$_SERVER['SERVER_NAME'];  // 服务器名称
$_SERVER['REQUEST_TIME']; // 请求时间
$_SERVER['QUERY_STRING']; // 查询字符串
$_SERVER['HTTP_REFERER']; // 上级请求页面
$_SERVER['HTTP_USER_AGENT']; // HTTP请求头信息
$_SERVER['REMOTE_ADDR'];     // 客户端 IP
$_SERVER['REQUEST_URI'];  // 请求URI，例如/index.php
$_SERVER['PATH_INFO'];    // 路径信息，例如/user/id

/**
 * NULL
 * 三种情况：
 * 直接赋值为 NULL、未定义的变量、unset 销毁的变量
 */

/**
 * 常量
 * 定义：
 * * const、define
 * * const 更快，是语言结构，define 是函数
 * * define 不能用于类常量定义，const 可以
 * * 常量一旦被定义，不能修改
 * 预定义常量：
 * *  __FILE__、__LINE__、__DIR__、__FUNCTION__、__CLASS__、__TRAIT__、__METHOD__、__NAMESPACE__
 */