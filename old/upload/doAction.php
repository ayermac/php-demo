<?php 
header('content-type:text/html;charset=utf-8');
include_once 'upload.func.php';
$fileInfo=$_FILES['myFile'];
// $newName=uploadFile($fileInfo);
// echo $newName;
// $newName=uploadFile($fileInfo,'imooc');
// echo $newName;
//$allowExt='txt';
$allowExt=array('jpeg','jpg','png','gif','html','txt');
$newName=upload($fileInfo,'imooc',false,$allowExt,2097152);
echo $newName;
