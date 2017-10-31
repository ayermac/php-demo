<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/10/9
 * Time: 21:21
 */
require_once './Response.php';
require_once './file.php';
//$jsonArray = array(
//    'id' => 1,
//    'name' => 'jason'
//);
//Response::json(200, '数据返回成功', $jsonArray);

//$xmlArray = array(
//    'id' => 1,
//    'name' => 'jason',
//    'type' => array(4, 5, 6),
//    'test' => array('a', 'b', 'c' => array(123, 'test'))
//);
//Response::xmlEncode(200, 'success', $xmlArray);

$data = array(
    'id' => 1,
    'name' => 'jason',
    'type' => array(4, 5, 6),
    'test' => array('a', 'b', 'c' => array(123, 'test'))
);
//Response::send(200, 'success', $data);

$file = new File();
if ($file->cacheData('index_mk')) {
    echo 'success';
} else {
    echo 'error';
}