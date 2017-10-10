<?php
	class indexController{
		function index(){
			VIEW::assign(array('title'=>'快乐的一天', 'author'=>'开心的一天','auth'=>'美好的一天'));
			VIEW::display('../tpl/test.html');
		}
	}
?>