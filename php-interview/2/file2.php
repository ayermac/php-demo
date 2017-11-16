<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/16
 * Time: 23:04
 */
$dir = './test';
// 打开目录
// 读取目录当中的文件
// 如果文件类型是目录，继续打开目录
// 读取子目录的文件
// 如果文件类型是文件，输出文件名称
// 关闭目录
function loopDir($dir) {
    $handle = opendir($dir);

    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            echo $file."\n";
            if (filetype($dir.'/'.$file) == 'dir') {
                loopDir($dir.'/'.$file);
            }
        }
    }
}

loopDir($dir);