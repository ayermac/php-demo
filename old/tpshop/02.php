<?php
ob_start();
$week="星期六";
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h2>实现静态化1</h2>
<h2>实现静态化2</h2>
<h2>实现静态化3</h2>
<h2>实现静态化4<?php echo $week;?></h2>
<?php
$cont=ob_get_contents();
file_put_contents('./02.shtml',$cont);
ob_flush();
?>
<h2>实现静态化5</h2>
<h2>实现静态化6</h2>
<h2>实现静态化7</h2>
<h2>实现静态化8</h2>
</body>
</html>