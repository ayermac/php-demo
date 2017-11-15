<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 20:45
 */
// zval 变量容器
$a = range(0, 3);
/**
 * a: (refcount=1, is_ref=0)=array
 * (
 * 0 => (refcount=1, is_ref=0)=0,
 * 1 => (refcount=1, is_ref=0)=1,
 * 2 => (refcount=1, is_ref=0)=2,
 * 3 => (refcount=1, is_ref=0)=3
 * )
 *
 * refcount: 内存空间，显示有几个变量指向它
 * is_ref: 是否为引用变量，0 为 false
 */
xdebug_debug_zval('a');

// 定义变量 b，把 a 的值赋值给 b
$b = $a;
/**
 * a: (refcount=2, is_ref=0)=array
 * (
 * 0 => (refcount=1, is_ref=0)=0,
 * 1 => (refcount=1, is_ref=0)=1,
 * 2 => (refcount=1, is_ref=0)=2,
 * 3 => (refcount=1, is_ref=0)=3
 * )
 * refcount = 2，意味着有两个变量指向这个内存空间
 */
xdebug_debug_zval('a');

// 修改 a
$a = range(3, 6);
/**
 * a: (refcount=1, is_ref=0)=array
 * (
 * 0 => (refcount=1, is_ref=0)=3,
 * 1 => (refcount=1, is_ref=0)=4,
 * 2 => (refcount=1, is_ref=0)=5,
 * 3 => (refcount=1, is_ref=0)=6
 * )
 * refcount = 1，因为 a 变量又复制了一个新的内存空间，变量 a 指向了新的内存空间
 */
xdebug_debug_zval('a');