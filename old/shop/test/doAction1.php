<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/13
 * Time: 10:02
 */
//require_once "../lib/string.func.php";
require_once "upload.func.php";

$fileInfo=$_FILES['myFile'];
$info=uploadFile($fileInfo);
echo $info;

echo "<br/><a href='upload.php'>返回继续上传</a>";


?>

