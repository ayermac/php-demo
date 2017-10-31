<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/31
 * Time: 20:33
 */
/**
 * 字符串反转
 */
function str_to_reverse($str) {

    for($length=0;$str[$length]!=null;$length++){
        ;
    }
    $strlength = $length-1;
    unset($length);

    for($start=0, $end=$strlength; $start<$end; $start++, $end--){
        $temp = $str[$start];

        $str[$start] = $str[$end];

        $str[$end] = $temp;
    }

    unset($temp,$start,$end,$strlength);

    return $str;
}

echo str_to_reverse('abc');