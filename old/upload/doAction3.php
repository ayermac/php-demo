<?php 
require_once 'upload.class.php';
error_reporting(E_ERROR|E_WARNING|E_PARSE);
$upload=new upload();
$dest=$upload->uploadFile();
echo $dest;
?>