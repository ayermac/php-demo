 <?php
require '../config.php';
require '../mysql.class.php';

if (empty($_POST['uname']) || empty($_POST['password'])) {
	header('location:index.html');
}
DB::connect();
$user = DB::$con->real_escape_string($_POST['uname']);
$pwd = DB::$con->real_escape_string($_POST['password']);

$sql_login = 'SELECT password FROM ' . ADMIN_TABLE_NAME . ' WHERE level=9 AND nickname = '. "'{$user}'" . ' LIMIT 1';
$insert_status = mysqli_query(DB::$con,$sql_login);
$password = mysqli_fetch_array($insert_status)[0];
DB::close();

if (md5($pwd) === $password) {
	//save to session
	session_start();
	$_SESSION['admin'] = true;
	header('location:admin.php');
} else {
	header('location:index.html');
}

/**end of file**/