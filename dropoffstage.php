<?php

ini_set('max_file_uploads', '1000');

	include("controller/func.php");
$dd = date('Y-m-d H:i:s');
	$curuser=@$_COOKIE['curuser'];

if (!file_exists('instage')) {
	mkdir('instage', 0777);
}

$dropoffurl=getParamValue("dropoffurl");
$fname=$dropoffurl."/".$_GET['filename'];



$realname=$_GET['filename'];
$ext=get_extension($realname);
$fileNm1=md5($_SERVER['REMOTE_ADDR'].rand()).".".$ext;
move_uploaded_file($fname, 'instage/' . $fileNm1);

$filx=copy($fname,'instage/' . $fileNm1);
				 if(!$filx)
				 {
					//var_dump($filx);
					//echo "Falied";
					 @unlink($fname);
				 }
				 else
				 {
					// echo "copied $file into $newfile\n";
				 }



$res=mysql_query("insert into pro_instage(name,usern,ext,realname,date_created) values('$fileNm1','$curuser','$ext','$realname','$dd')"); 
$ido=returnQueryValue("select max(id) as ido from pro_instage","ido");



header("location: processfile.php?id=".$ido);


function get_extension($file) {
 $extension = end(explode(".", $file));
 return $extension ? $extension : false;
}
?>