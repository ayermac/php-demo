<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 23:12
 */
$filename="one_piece.jpg";
$src_iamge=imagecreatefromjpeg($filename);

list($src_w,$src_h)=getimagesize($filename);
$scale=0.5;
$dst_w=ceil($src_w*$scale);
$dst_h=ceil($src_h*$scale);
$dst_image=imagecreatetruecolor($dst_w,$dst_h);
imagecopyresampled($dst_image,$src_iamge,0,0,0,0,$dst_w, $dst_h,$src_w,$src_h);
header("content-type:image.jpeg");
imagejpeg($dst_image,"uploads/".$filename);
imagedestroy($src_iamge);
imagedestroy($dst_image);