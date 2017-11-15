<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 21:06
 */
/**
 * 写出如下程序的输出结果
 * <?php
 * $data = ['a', 'b', 'c'];
 * foreach($data as $key => $val) {
 *     $val = &$data[$key];
 * }
 * 程序运行时，每一次循环结束后变量$data的值是什么？请解释
 * 程序执行完成后，变量$data的值是什么？请解释
 */

$data = ['a', 'b', 'c'];
foreach($data as $key => $val) {
    $val = &$data[$key];
    var_dump($data);
}
var_dump($data);