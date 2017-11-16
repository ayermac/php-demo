<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/16
 * Time: 19:37
 */
/**
 * 写出如下程序的输出结果：
 * <?php
 *
 * $count = 5;
 * function get_count()
 * {
 *     static $count;
 *     return $count++;
 * }
 * echo $count;
 * ++$count;
 *
 * echo get_count();
 * echo get_count();
 *
 * ?>
 *
 */

$count = 5;
function get_count()
{
    static $count;
    return $count++;
}

echo $count . "\n";
++$count;

echo get_count() . "\n";
echo get_count() . "\n";

/////////////////////////////////////////////////

function &myFunc()
{
    static $b = 10;
    return $b;
}

echo myFunc() . "\n"; // 10

// 引用函数，指向同一个内存空间
$a = &myFunc();

$a = 100;

echo myFunc() . "\n"; // 100

/////////////////////////////////////////////////

$var1 = 5;
$var2 = 10;

function foo(&$my_var)
{
    global $var1;
    $var1 += 2;
    $var2 = 4;
    $my_var += 3;
    return $var2;
}

$my_var = 5;
echo foo($my_var). "\n"; // 4
echo $my_var. "\n"; // 8
echo $var1; // 7
echo $var2; // 10
$bar = 'foo';
$my_var = 10;
echo $bar($my_var). "\n"; // 4