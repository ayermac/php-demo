<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/18
 * Time: 19:00
 */
// 冒泡排序原理和实现
function BubbleSort(array $container)
{
    $count = count($container);
    for ($j = 0; $j <= $count; $j++) {
        for ($i = 0; $i < $count - $j; $i++) {
            if ($container[$i] > $container[$i + 1]) {
                $temp = $container[$i];
                $container[$i] = $container[$i + 1];
                $container[$i + 1] = $temp;
            }
        }
    }
    return $container;
}
var_dump(BubbleSort([4, 21, 41, 2]));

$arr1 = array(100, 90, 80, 60);
$arr2 = array(100, 80, 70, 60);
$arr3 = array_merge($arr1, $arr2);
sort($arr3);

var_dump($arr3);