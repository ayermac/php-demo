<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/5
 * Time: 21:31
 */
function transByte($size){
    $arr=array("B","KB","MB","GB","TB","PB");
    $i=0;
    while($size>1024){
        $size/=1024;
        $i++;
    }
    return round($size,2).$arr[$i];
}

function createFile($filename){
    //验证文件名的合法性，是否包含/,*,?,<>,|等非法字符
    $pattern="/[\/,\*,<>,\?,\|]/";
    if(!preg_match($pattern,basename($filename))){
        if(!file_exists($filename)){
            if(touch($filename)){
                return "文件创建成功";
            }else{
                return "文件创建失败";
            }
        }else{
            return "文件已存在，请重命名后创建";
        }
    }else{
        return "非法文件名";
    }
}