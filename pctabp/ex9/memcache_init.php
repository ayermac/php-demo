<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/24
 * Time: 21:12
 */
/**
 * PHP Memcache 基础使用
 */
$mc = new Memcache();
$mc->connect('127.0.0.1', 11211);

// 存储数据
$mc->set('key', 'value', 0, 10);
// 获取数据
$val = $mc->get('key');
var_dump($val);

// 删除数据
$mc->delete('key');
// 强制刷新全部缓存，即清空 Memcached 服务器
$mc->flush();
// 断开与 Memcached 服务器的连接
$mc->close();

