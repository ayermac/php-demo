<?php
define('SECRET', "67%$#ap28");
function m_token() {
    $str = mt_rand(1000, 9999);
    $str2 = dechex($_SERVER['REQUEST_TIME'] - $str);
    return $str.substr(md5($str.SECRET), 0, 10). $str2;
}
echo m_token();
echo '<br />';

function v_token($str, $delay = 300) {
    // $delay 表示时间延迟，在不同的程序根据业务来自行修改
    $rs = substr($str, 0, 4);
    $middle = substr($str, 0, 14);
    $rs2 = substr($str, 14, 8);
    return ($middle == $rs.substr(md5($rs.SECRET), 0, 10)) && ($_SERVER['REQUEST_TIME'] - hexdec($rs2) - $rs < $delay);
}
var_dump(v_token(m_token()));