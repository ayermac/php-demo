<?php
session_start();
if (!$_SESSION['admin']) {
	return false;
}

require '../config.php';
require '../mysql.class.php';

$id = $_POST['id'];
$reply = $_POST['reply'];
 DB::connect();
//!(empty($id) || empty($reply)) <=> (!empty($id) && !empty($reply))
if (!(empty($id) || empty($reply))) {
	$id = DB::$con->real_escape_string($id);
	$reply = DB::$con->real_escape_string($reply);
	$time = date('Y-m-d H:i:s',time());
	$reply_sql = 'UPDATE ' . GB_TABLE_NAME . ' SET reply = "' . $reply . '", replytime = "' . $time .'" WHERE id = ' . $id;
	$reply_status = mysqli_query(DB::$con,$reply_sql);
	DB::close();
	if ($reply_status) {
		echo '{"error":0, "msg":"reply success"}';
	} else {
		echo '{"error":1, "msg":"reply error"}';
	}
} else {
	echo '{"error":1, "msg":"id or reply not null"}';
}
