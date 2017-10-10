<?php
header("content-tyoe:text/html;charset=utf-8");

//框架两种模式：【默认】生产、开发（调试）
define("APP_DEBUG", true);//开发
//define("APP_DEBUG", false);//生产
define("SITE_URL","http://localhost:8080/Mooc/TP/shop/");
define("ROOT_CSS", "/Mooc/TP/shop/Public/css");
define("ROOT_IMG", "/Mooc/TP/shop/Public/img");
define("ROOT_js", "/Mooc/TP/shop/Public/js");
//引入框架接口文件

include('../ThinkPHP/ThinkPHP.php');


?>