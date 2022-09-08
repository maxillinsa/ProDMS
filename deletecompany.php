<?php 

$id=$_GET['id'];
	include("controller/func.php");
	$dd = date('Y-m-d');
	$curuser=@$_COOKIE['curuser'];
	$res=mysql_query("update dms_companies set status='N' where id=$id");
	header("location: companies.php");

?>