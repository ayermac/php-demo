<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 20:55
 */
$a = range(0, 3);
/**
 * a: (refcount=1, is_ref=0)=array
 * (0 => (refcount=1, is_ref=0)=0,
 * 1 => (refcount=1, is_ref=0)=1,
 * 2 => (refcount=1, is_ref=0)=2,
 * 3 => (refcount=1, is_ref=0)=3)
 * refcount: 内存空间，显示有几个变量指向它
 * is_ref: 是否为引用变量，0 为 false
 */
xdebug_debug_zval('a');

$b = &$a;
/**
 * a: (refcount=2, is_ref=1)=array
 * (0 => (refcount=1, is_ref=0)=0,
 * 1 => (refcount=1, is_ref=0)=1,
 * 2 => (refcount=1, is_ref=0)=2,
 * 3 => (refcount=1, is_ref=0)=3)
 */
xdebug_debug_zval('a');

$a = range(3, 6);
/**
 * a: (refcount=2, is_ref=1)=array
 * (0 => (refcount=1, is_ref=0)=3,
 * 1 => (refcount=1, is_ref=0)=4,
 * 2 => (refcount=1, is_ref=0)=5,
 * 3 => (refcount=1, is_ref=0)=6)
 *
 * 因为 a 为引用变量，内存不会另外开辟空间，所以 a 和 b 始终指向该空间
 */
xdebug_debug_zval('a');