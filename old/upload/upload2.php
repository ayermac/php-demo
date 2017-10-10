<!DOCTYPE html>
<html>
<head>
<meta charset="utf8">
	<title></title>
</head>
<body>
<form method="post" action="doAction2.php" enctype="multipart/form-data">
	选择文件<input type="file" name="myFile1"/></br>
选择文件<input type="file" name="myFile[]"/></br>
选择文件<input type="file" name="myFile[]"/></br>
选择文件<input type="file" name="myFile[]" multiple="multiple" /></br>
	<input type="submit" value="提交">
</form>
</body>
</html>