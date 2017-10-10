<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/6/29
 * Time: 14:22
 */
require_once "../include.php";
$act=$_REQUEST['act'];
$id=$_REQUEST['id'];

if($act=="userlogout"){
    userlogout();
}