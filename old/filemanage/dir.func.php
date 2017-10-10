<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/5
 * Time: 15:59
 */

//所有根目录相关操作

//打开指定目录
function readDirectory($path)
{
    $handle = opendir($path);
    while (($item = readdir($handle)) !== false) {
        if ($item != "." && $item != "..") {
            if (is_file($path . "/" . $item)) {
                $arr['file'][] = $item;
            }
            if (is_dir($path . "/" . $item)) {
                $arr['dir'][] = $item;
            }
        }
    }
    closedir($handle);
    return $arr;
}

/*$path="file";
print_r(readDirectory($path));*/

