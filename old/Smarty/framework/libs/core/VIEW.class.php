<?php
class VIEW{
	public static $view;

	public static function init($viewtype,$config){
		//$smarty = new Smarty();//实例化smarty
		self::$view=new $viewtype;
		self::$view->setCacheDir('cache/');
		self::$view->cachint=true;
		self::$view->cache_lifetime=60*60;

		foreach ($config as $key => $value) {
			# code...
			self::$view->$key=$value;
		}
	}

	public static function assign($data){
		foreach ($data as $key => $value) {
			# code...
			self::$view->assign($key,$value);
		}
	}

	public static function display($template){
		self::$view->display($template);
	}
}
?>