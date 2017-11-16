<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/16
 * Time: 22:31
 */
$str = '中文';

// utf-8
$pattern = '/[\x{4e00}-\x{9fa5}]+/u';

// gbk
//$pattern = '/['.chr(0xb0).'-'.chr(0xf7).']['.chr(0xa1).'-'.chr(0xfe).']/';
preg_match($pattern, $str, $match);

var_dump($match);

// 请写出以139开头的11位手机号码的正则表达式
// 13988888888

$str = '13988888888';
$pattern = '/^139\d{8}$/';

preg_match($pattern, $str, $match);

var_dump($match);

// 请匹配所有img标签中的src的值

$str = '<img alt="高清无码" id="av" src="av.jpg" />';

$pattern = '/<img.*?src="(.*?)".*?\/?>/i';

preg_match($pattern, $str, $match);

var_dump($match);
