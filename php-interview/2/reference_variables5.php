<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/15
 * Time: 20:58
 */
// unset 只会取消引用，不会销毁空间
$a = 1;
xdebug_debug_zval('a');

$b = &$a;
xdebug_debug_zval('a');

unset($b);
xdebug_debug_zval('a');

echo $a . "\n";