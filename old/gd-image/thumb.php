<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 20:41
 */
$src='Music - tomasino.jpeg';

$info=getimagesize($src);
$type=image_type_to_extension($info[2],false);

$fun="imagecreatefrom{$type}";
$image=$fun($src);

$image_thumb=imagecreatetruecolor(300,200);

imagecopyresampled($image_thumb,$image,0,0,0,0,300,200,$info[0],$info[1]);

imagedestroy($image);
header("Content-type:",$info['mime']);
$funs="image{$type}";
$funs($image_thumb);
$funs($image_thumb,"new2.".$type);
imagedestroy($image_thumb);