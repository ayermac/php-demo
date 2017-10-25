<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/24
 * Time: 21:12
 */
/**
 * Redis 基础使用
 */
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

// 设置 Redis 字符串数据
$result = $redis->set('key', 'value');
// 获取 Redis 字符串数据
$result = $redis->get('key');
var_dump($result); // value

// 删除指定的键
$redis->delete('key');

