<?php
$db_user="root";
$db_pass="";
$timezone="Asia/Shanghai";
try{
	$dsn='uri:file://D:\test\mood\dsn.txt';
	$username='root';
	$passwd='';
	$pdo=new PDO($dsn,$db_user,$db_pass);
}catch(PDOException $e){
	echo $e->getMessage();
}
header("Content-Type: text/html; charset=utf-8");
