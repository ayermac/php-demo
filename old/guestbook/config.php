<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PWD", "");
define("DB_NAME", "guestbook");
define("GB_TABLE_NAME", "guestbook");
define("ADMIN_TABLE_NAME", "user");
define("PER_PAGE_GB", 5);
define("ROOT", pathinfo(__FILE__, PATHINFO_DIRNAME));

//开启debug模式，开启所有错误报告
$debug = true;
if($debug){
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
}

?>