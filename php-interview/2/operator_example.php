<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 22:07
 */
/**
 * 下列程序中请写出打印输出的结果
 * <?php
 *
 * $a = 0;
 * $b = 0;
 *
 * if ($a = 3 > 0 || $b = 3 > 0)
 * {
 *      $a++;
 *      $b++;
 *      echo $a. "\n";
 *      echo $b. "\n";
 * }
 */


$a = 0;
$b = 0;

if ($a = 3 > 0 || $b = 3 > 0)
{
    $aa = $a++;
    $bb = $b++;
    echo $aa. "\n"; // true ++ == 1
    echo $bb. "\n"; // 0
    echo $a. "\n";  // 1
    echo $b. "\n";  // 1
}
