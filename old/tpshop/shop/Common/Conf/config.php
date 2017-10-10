<?php
return array(
	//'配置项'=>'配置值'

	//默认分组设置
	'DEFAULT_MODULE'=>'Home',
	'MODULE_ALLOW_LIST'=> array('Admin','Home'),
	//Smarty模板引擎切换
	'TMPL_ENGINE_TYPE'      =>  'Smarty',
	//为Smarty配置
	// 'TMPL_ENGINE_CONFIG'=>array(
 //        'left_delimiter'=>"<@",
 //        'right_delimiter'=>"@>"
	// 	)
    'SHOW_PAGE_TRACE'=>true,
	/* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'shop077',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '159753',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sw_',    // 数据库表前缀
    'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8

    'TMPL_ACTION_SUCCESS' => 'Public:success'
);