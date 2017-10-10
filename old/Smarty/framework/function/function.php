<?php

function C($name,$method){
	require_once('libs/Controller/'.$name.'Controller.class.php');
	$controller=$name.'Controller';
	$obj=new $controller;
	$obj->$method();
}

function M($name){
	require_once('libs/Model/'.$name.'Model.class.php');
	$Model=$name.'Model';
	$obj=new $Model;
	return $obj;
}

function V($name){
	require_once('libs/View/'.$name.'View.class.php');
	$View=$name.'View';
	$obj=new $View;
	return $obj;
}

function ORG($path,$name,$params=array()){
	require_once('libs/ORG/'.$path.$name.'.class.php');
	$obj=new $name();
	$obj->setTemplateDir('tpl');
    $obj->setCompileDir('templates_c/');
// $smarty->setConfigDir('/configs/');
    $obj->caching=true;
	$obj->cache_lifetime=60*60;
    $obj->setCacheDir('cache/');


	if(!empty($params)){
		foreach ($params as $key => $value) {
			# code...
			$obj->$key=$value;
		}
	}
	return $obj;

}

function daddslashes($str){
	return (!get_magic_quotes_gpc())?addslashes($str):$str;
}

?>