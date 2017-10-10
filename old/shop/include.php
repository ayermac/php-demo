<?php 
error_reporting(E_ERROR|E_PARSE|E_WARNING);
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
require_once '../lib/mysql.func.php';
session_start();
require_once '../lib/common.func.php';
require_once '../lib/images.func.php';
require_once '../lib/page.func.php';
require_once '../lib/upload.func.php';
require_once '../core/admin.inc.php';
require_once '../core/cate.inc.php';
require_once '../core/pro.inc.php';
require_once '../core/album.inc.php';
require_once '../core/user.inc.php';


// define("ROOT",dirname(__FILE__));
// set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.ROOT."/configs".PATH_SEPARATOR.get_include_path());
// require_once 'user.inc.php';

connect();


?>