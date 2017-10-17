<?php
/*$date = '2012-12-20';
if (ereg("([0-9]{4}) - ([0-9]{1,2} - ([0-9]{1,2})", $date, $regs)) {
    echo "$regs[3].$regs[2].$regs[1]";
} else {
    echo "Invalid date format: $date";
}

if ($i > 5) {
    echo '$i 没有初始化啊', PHP_EOL;
}

$a = array('0' => 2, 4, 6, 8);
echo $a[0];
$result = array_sum($a, 3);
echo fun();
echo '致命错误之后呢? 还会执行吗?';*/
// echo '最高级别的错误', $55;


/*function customError($errno, $errstr, $errfile, $errline) {
    echo "<b>错误代码: </b> [${errno}] ${errstr}\r\n";
    echo "错误所在的代码行: {$errline} 文件 {$errfile}\r\n";
    echo "PHP 版本 ", PHP_VERSION, "(", PHP_OS, ")\r\n";
}

set_error_handler("customError", E_ALL | E_STRICT);
$a = array('0' => 2, 4, 6, 8);
echo $a[o];*/

function customError($errno, $errstr, $errfile, $errline) {
    // 自定义错误处理时，手动抛出异常
    throw new Exception($level. '|' . ${errstr});
}

set_error_handler("customError", E_ALL | E_STRICT);
try {
    $a = 5/0;
} catch (Exception $e) {
    echo '错误信息: ', $e->getMessage();
}