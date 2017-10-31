<?php
$mysqli=new mysqli('localhost','root','','imoocComment');
if($mysqli->errno){
	die('Connect Error:'.$mysqli->error);
}else{
	$mysqli->set_charset('UTF8');
}