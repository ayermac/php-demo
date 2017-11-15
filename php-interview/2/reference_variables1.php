<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 20:34
 */
/**
 * 引用变量
 * 概念：在 PHP 中引用意味着用不同的名字访问同一个变量内容
 * 定义方式：使用 & 符号
 */
// 定义一个变量
$a = range(0, 10);
var_dump(memory_get_usage());

// 定义变量 b，将 a 变量的值赋值给 b，内存不会另外开辟空间
// COW Copy On Write
$b = $a;
var_dump(memory_get_usage());

// 对 a 进行修改，内存另外开辟空间
$a = range(10, 20);
var_dump(memory_get_usage());