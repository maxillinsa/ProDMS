<?php 

$id=$_GET['id'];
	include("controller/func.php");
	$dd = date('Y-m-d');
	$curuser=@$_COOKIE['curuser'];
	$res=mysql_query("delete from pro_workflow_def where id=$id");
	
	$taskname=returnQueryValue("select taskname from pro_workflow_def where id=$id","taskname");
	
	$op="Task : ".$taskname." deleted";
	$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
	header("location: workflow.php");

?>