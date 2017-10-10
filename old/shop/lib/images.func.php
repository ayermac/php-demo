<?php

require_once "string.func.php";

// 通过GD库创建验证码
// 创建画布
function verifyImage($type=3,$length=4,$pixel=30,$line=5,$sess_name="verify"){
session_start();
$width=80;
$height=30;
$image=imagecreatetruecolor($width, $height);
$white=imagecolorallocate($image,255, 255, 255);
$black=imagecolorallocate($image,0, 0, 0);
//用填充矩形填充画布
imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
$chars=buildRandomString($type,$length);

$_SESSION[$sess_name]=strtolower($chars);
$fontfiles=array("arial.ttf","courbi.ttf","lsansdi.ttf","lucon.ttf");

for($i = 0; $i < $length; $i ++) {
		$size = mt_rand ( 14, 18 );
		$angle = mt_rand ( - 15, 15 );
		$x = 5 + $i * $size;
		$y = mt_rand ( 20, 26 );
		$fontfile = "../fonts/" . $fontfiles [mt_rand ( 0, count ( $fontfiles ) - 1 )];
		$color = imagecolorallocate ( $image, mt_rand ( 50, 90 ), mt_rand ( 80, 200 ), mt_rand ( 90, 180 ) );
		$text = substr ( $chars, $i, 1 );
		imagettftext ( $image, $size, $angle, $x, $y, $color, $fontfile, $text );
	}

if($pixel){
for($i=0;$i<$pixel;$i++){
	imagesetpixel($image, mt_rand(0,$width-1), mt_rand(0,$height-1), $black);
}
}

if($line){
	for ($i=1; $i < $line; $i++) { 
		# code...
		$color = imagecolorallocate ( $image, mt_rand ( 50, 90 ), mt_rand ( 80, 200 ), mt_rand ( 90, 180 ) );
		imageline($image, mt_rand(0,$width-1), mt_rand(0,$height-1), mt_rand(0,$width-1), mt_rand(0,$height-1), $color);
	}
}
header("content-type:image/gif");
imagegif($image);
imagedestroy($image);
}
// verifyImage();

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
	if($destination&&!file_exists(dirname($destination))){
		mkdir($destination,0777,true);
	}
	$ext=getUniName().".".getExt($filename);
	$dstFilename=$destination==null?$ext:$destination;
	$outFun($dst_image,$dstFilename);
	imagedestroy($src_image);
	imagedestroy($dst_image);
	if(!$isReservedSource){
		unlink($filename);
	}
	return $dstFilename;
}

function waterText($filename,$text="水印",$fontfile="msyh.ttf"){
	$fileInfo=getimagesize($filename);
	$mime=$fileInfo['mime'];
	$createFun=str_replace("/","createfrom",$mime);
	$outFun=str_replace("/",null,$mime);
	$image=$createFun($filename);
	$color=imagecolorallocatealpha($image,255,0,0,30);
	$fontfile="../fonts/{$fontfile}";
	imagettftext($image,20,0,10,30,$color,$fontfile,$text);
//	header("content-type:".$mime);
	$outFun($image,$filename);
	imagedestroy($image);
}

function waterPic($dstFile,$srcFile='../images/logo.jpg',$pct=50){
	$srcFileInfo=getimagesize($srcFile);
	$src_w=$srcFileInfo[0];
	$src_h=$srcFileInfo[1];
	$dstFileInfo=getimagesize($dstFile);
	$srcMime=$srcFileInfo['mime'];
	$dstMime=$dstFileInfo['mime'];
	$createSrcFun=str_replace("/","createfrom",$srcMime);
	$createDstFun=str_replace("/","createfrom",$dstMime);
	$outDstFun=str_replace("/",null,$dstMime);
	$dst_im=$createDstFun($dstFile);
	$src_im=$createSrcFun($srcFile);
	imagecopymerge($dst_im,$src_im,0,0,0,0,$src_w,$src_h,$pct);
	$outDstFun($dst_im,$dstFile);
	imagedestroy($src_im);
	imagedestroy($dst_im);
}



?>