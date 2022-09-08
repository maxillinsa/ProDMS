<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$appdbsettingsfile="app.config";
$app_db_settings=@file_get_contents($appdbsettingsfile);
if($app_db_settings){
	
}else{
	$appdbsettingsfile="../app.config";
	$app_db_settings=@file_get_contents($appdbsettingsfile);
}

if($app_db_settings==""){
	echo "<span style='color:red;font-size:20px;'>Application not properly installed<br>Copy the Install folder into the root directory, read the install guide and reinstall</span>";
	exit;
}

$pack=$extension = explode(",", $app_db_settings);
//echo $pack[0]."<br>". $pack[1];exit;
//host=localhost,db=dmsdb,username=root,password=
$hostline=explode("=", $pack[0]);
$hostname_mycon=$hostline[1];

$dbline=explode("=", $pack[1]);
$database_mycon=$dbline[1];

$userline=explode("=", $pack[2]);
$username_mycon=$userline[1];

$passline=explode("=", $pack[3]);
$password_mycon=$passline[1];

//echo $database_mycon;exit;

if($hostname_mycon=="" || $database_mycon=="" || $username_mycon==""){
	echo "<span style='color:red;font-size:20px;'>Application not properly installed<br>Copy the Install folder into the root directory, read the install guide and reinstall</span>";
	exit;
}


$mycon = mysql_pconnect($hostname_mycon, $username_mycon, $password_mycon) or trigger_error(mysql_error(),E_USER_ERROR); 

//echo $mycon;exit;

$db=mysql_select_db($database_mycon);

//var_dump ($db);
?>