<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 23:22
 */
$filename="one_piece.jpg";
list($src_w,$src_h,$imagetype)=getimagesize($filename);
$mime=image_type_to_mime_type($imagetype);
//mimi类型: image/jpg,image/gif
$createFun=str_replace("/","createfrom",$mime);
$outFun=str_replace("/",null,$mime);
$src_image=$createFun($filename);
$dst_100_image=imagecreatetruecolor(100,100);
$dst_220_image=imagecreatetruecolor(220,220);
$dst_350_image=imagecreatetruecolor(350,350);
$dst_800_image=imagecreatetruecolor(800,800);

imagecopyresampled($dst_100_image,$src_image,0,0,0,0,50,50,$src_w,$src_h);
imagecopyresampled($dst_220_image,$src_image,0,0,0,0,220,220,$src_w,$src_h);
imagecopyresampled($dst_350_image,$src_image,0,0,0,0,350,350,$src_w,$src_h);
imagecopyresampled($dst_800_image,$src_image,0,0,0,0,800,800,$src_w,$src_h);

$outFun($dst_100_image,"uploads/image_100/".$filename);
$outFun($dst_220_image,"uploads/image_220/".$filename);
$outFun($dst_350_image,"uploads/image_350/".$filename);
$outFun($dst_800_image,"uploads/image_800/".$filename);
imagedestroy($src_image);
imagedestroy($dst_100_image);
imagedestroy($dst_220_image);
imagedestroy($dst_350_image);
imagedestroy($dst_800_image);
?>

