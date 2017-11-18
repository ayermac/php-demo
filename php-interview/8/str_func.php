<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/18
 * Time: 21:34
 */
// 1,2,3,5,8,13,21,34....30
$arr = [1, 1];

for ($i = 2; $i < 30; $i++) {
    $arr[$i] = $arr[$i-1] + $arr[$i - 2];
}
var_dump($arr);

function strHandle($str) {
    $return = '';
    $arr = explode('_', $str);
    foreach ($arr as $val) {
        $return .= ucfirst($val);
    }
    return $return;
}

echo strHandle('open_door');

// abcdefg -> gfedcba
// a,b,c....
function str_rev($str) {
    for ($i = 0; true; $i++) {
        if (!isset($str[$i])) {
            break;
        }
    }
    $return = '';
    for($j = $i-1; $j >=0; $j--) {
        $return .= $str[$j];
    }
    return $return;
}
echo str_rev('abcdefg');

// array_mer($arr1, $arr2, $arr3,...$arrn);

function array_mer() {
    $return = [];
    $arrays = func_get_args();
    foreach ($arrays as $arr) {
        if (is_array($arr)) {
            foreach ($arr as $val) {
                $return[] = $val;
            }
        }
    }
    return $return;
}
var_dump(array_mer([1], [2,3]));