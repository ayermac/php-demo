<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 19:50
 */
$src='Music - tomasino.jpeg';

$info=getimagesize($src);

$type=image_type_to_extension($info[2],false);

$fun="imagecreatefrom{$type}";
$image=$fun($src);

$image_Mark='1.jpeg';
$info2=getimagesize($image_Mark);
$type2=image_type_to_extension($info[2],false);
$fun2="imagecreatefrom{$type2}";
$water=$fun2($image_Mark);
imagecopymerge($image,$water,20,30,0,0,$info2[0],$info2[1],30);

imagedestroy($water);

header("Content-type:",$info['mime']);
$func="image{$type}";
$func($image);

$func($image,'new1.'.$type);
imagedestroy($image);

