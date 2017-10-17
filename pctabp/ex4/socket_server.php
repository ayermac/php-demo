<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/17
 * Time: 21:15
 */
$host = "192.168.0.5";
$port = 12345;
set_time_limit(0);

// 创建 socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// 非阻塞模式
socket_set_block($socket) or die("socket_set_block() 失败的原因是:" . socket_strerror(socket_last_error()) . "/n");

// 绑定 socket 到指定地址和端口
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

// 开始监听连接
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

// 接收连接请求并调用另一个子 socket 处理客户端——服务器间的信息
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

// 读取客户端输入
$input = socket_read($spawn, 1024) or die("Could not read input\n");

// 清除输入字符串中首尾空格
$input = trim($input);

// 反转客户端输入数据，返回服务端
$output = strrev($input) . "\n";
socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");

// 关闭 sockets
socket_close($spawn);
socket_close($socket);