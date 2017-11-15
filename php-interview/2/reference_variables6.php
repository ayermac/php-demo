<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 21:01
 */

/**
 * 对象本身就是引用传递
 * Class Person
 */
class Person {
    public $name = "zhangsan";
}

$p1 = new Person();
/**
 * p1: (refcount=1, is_ref=0)=class
 * Person {
 * public $name = (refcount=1, is_ref=0)='zhangsan'
 * }
 */
xdebug_debug_zval('p1');

$p2 = $p1;
/**
 * p1: (refcount=2, is_ref=0)=class
 * Person {
 * public $name = (refcount=1, is_ref=0)='zhangsan'
 * }
 */
xdebug_debug_zval('p1');

$p2->name = "lisi";
/**
 * p1: (refcount=2, is_ref=0)=class
 * Person {
 * public $name = (refcount=1, is_ref=0)='lisi'
 * }
 */
xdebug_debug_zval('p1');