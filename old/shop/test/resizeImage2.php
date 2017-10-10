<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13
 * Time: 23:46
 */
require_once "../lib/string.func.php";
//thumb("one_piece.jpg");
$filename="one_piece.jpg";
thumb($filename,"upload");
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=true,$scale=0.5){
    list($src_w,$src_h,$imagetype)=getimagesize($filename);
    if(is_null($dst_w)&&is_null($dst_h)){
        $dst_w=$src_w*$scale;
        $dst_h=$src_h*$scale;
    }
    $mime=image_type_to_mime_type($imagetype);
    $createFun=str_replace("/","createfrom",$mime);
    $outFun=str_replace("/",null,$mime);

    $src_image=$createFun($filename);
    $dst_image=imagecreatetruecolor($dst_w,$dst_h);
    imagecopyresampled($dst_image,$src_image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);

    /*if($destination&&!file_exists(($destination))){
        mkdir(dirname($destination),0777,true);
    }*/
    if($destination&&!file_exists($destination)){
        mkdir($destination,0777,true);
    }
    $ext=getUniName().".".getExt($filename);
    $dstFilename=$destination==null?$ext:$destination."/".$ext;
    $outFun($dst_image,$dstFilename);
    imagedestroy($src_image);
    imagedestroy($dst_image);
    if(!$isReservedSource){
        unlink($filename);
    }
    return $dstFilename;
}