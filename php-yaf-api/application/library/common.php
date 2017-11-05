<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2017/11/4
 * Time: 17:43
 */
/**
 * 返回 json 对象数据
 * @param $errno
 * @param $errmsg
 * @param $data
 */
function json($errno, $errmsg, $data="") {
    header("content-type: text/json, char-set=utf-8");
    return json_encode(
        array(
            "errno" => $errno,
            "errmsg" => $errmsg,
            "data" => $data
        )
    );
}