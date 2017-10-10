<?php 
header('content-type:text/html;charset=utf8');
require_once 'upload.func.php';
foreach ($_FILES as $fileInfo) {
	$files[]=upload($fileInfo);

}

print_r($files);
?>