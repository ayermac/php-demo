<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/13
 * Time: 10:02
 */
//require_once "../lib/string.func.php";
require_once "upload.func.php";

foreach($_FILES as $val){
    $mes=uploadFile($val);
    echo $mes;

}


echo "<br/><a href='upload1.php'>返回继续上传</a>";

?>

