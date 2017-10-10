<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 19:20
 */
//配置图片路径
$src='Music - tomasino.jpeg';
//获取图片的信息（大小）
$info=getimagesize($src);
//获取图片的类型
$type=image_type_to_extension($info[2],false);
//复制一个图片存到$fun中
$fun="imagecreatefrom{$type}";
$image=$fun($src);

$font='msyh.ttf';
$content="这是一个水印";

$col=imagecolorallocatealpha($image,255,255,255,50);

imagettftext($image,20,0,20,30,$col,$font,$content);

header("Content-type:".$info['mime']);

$func="image{$type}";
$func($image);

$func($image,'new.'.$type);
imagedestroy($image);