<?php
header("content-type:text/html;charset=utf-8");
//print_r($_FILES);
error_reporting(E_ERROR|E_WARNING|E_PARSE);
require_once 'common.func.php';
require_once 'upload.func1.php';
$files=getFiles();

foreach($files as $fileInfo){
    $res=uploadFile($fileInfo);
    echo $res['mes'].'<br/>';
    $uploadFiles[]=$res['des'];
}
$uploadFiles=array_values(array_filter($uploadFiles));
print_r($uploadFiles);
?>