<?php

//ini_set('max_file_uploads', '1000');


	include("controller/func.php");
$dd = date('Y-m-d H:i:s');
	$curuser=@$_COOKIE['curuser'];

if (!file_exists('instage')) {
	mkdir('instage', 0777);
}

$size=$_FILES['file']['size'];
$max_document_size=getParamValue("max_document_size");
//echo $size;exit;

if($size>$max_document_size){
	echo "1g";exit;
}


$realname=$_FILES['file']['name'];
$ext=@get_extension($_FILES['file']['name']);
$fileNm1=md5($_SERVER['REMOTE_ADDR'].rand()).".".$ext;
move_uploaded_file($_FILES['file']['tmp_name'], 'instage/' . $fileNm1);

//echo "File uploaded successfully.";

$res=mysql_query("insert into pro_instage(name,usern,ext,realname,date_created) values('$fileNm1','$curuser','$ext','$realname','$dd')"); 
$ido=returnQueryValue("select max(id) as ido from pro_instage","ido");
echo $ido;

function get_extension($file) {
 $extension = end(explode(".", $file));
 return $extension ? $extension : false;
}
?>