<?php
class mysql{
//报错函数

function err($error){
    die("对不起，您的操作有误，错误代码为".$error);
}

//连接数据库
//$config=array($dbhost,$dbuser,$dbpsw,$dbname,$dbcharset)
function connect($config){
    extract($config);
    $con=mysql_connect($dbhost,$dbuser,$dbpsw);

    if(!$con){
        $this->err(mysql_error());
    }
    if(!mysql_select_db($dbname,$con)){
    	$this->err(mysql_error());
    }
    mysql_query("set names ".$dbcharset);
}

// $config=array('localhost','root','159753','info','utf-8');
// connect($config);

//执行sql语句
function query($sql){
	if(!($query=mysql_query($sql))){
		$this->err($sql."<br/>".mysql_error());
	}else{
		return $query;
	}
}

function findAll($query){
	while ($rs=mysql_fetch_array($query,MYSQL_ASSOC)) {
		# code...
		$list[]=$rs;
	}
	return isset($list)?$list:"";
}

function findOne($query){
	$rs=mysql_fetch_array($query,MYSQL_ASSOC);
	return $rs;
}

function findResult($query,$row=0,$filed=0){
	$rs=mysql_result($query, $row,$filed);
	return $rs;
}

function insert($table,$array){
    $keys=join(",",array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table}($keys) values({$vals})";
    $this->query($sql);
    return mysql_insert_id();
}

function update($table,$arr,$where=null){
	foreach ($arr as $key => $value) {
		# code...
		if($str==null){
			$sep="";
		}else{
			$sep=",";
		}
		$str.=$sep.$key."='".$val."'";
	}
	$sql="update {$table} set {$str}".($where==null?null:" where ".$where);
	$result=$this->query($sql);
	if($result){
		return mysql_affected_rows();
	}else{
		return false;
	}
}

function delete($table,$where=null){
	$where=$where==null?null:" where ".$where;
	$sql="delete from {$table} {$where}";
	$this->query($sql);
	return mysql_affected_rows();
}

}
?>