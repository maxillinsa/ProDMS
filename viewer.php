<?php 

include("controller/func.php");
	include("controller/filehandler.php");
	
	$id=$_GET['id'];
	$curuser=@$_COOKIE['curuser'];
		$viewerid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
	
	$canview=getFolderPermission($id,$viewerid,"canread");
	if($canview=="N"){
		echo "<font style='color:red;font-size:15px;'>'Read' Access Denied.<br>Contact System Administrator<br><br><a href='javascript:history.back();'>Go Back</a></font>";exit;
	}
	
	$filename=returnQueryValue("select name from pro_documents where id=$id","name");	
	$realname=returnQueryValue("select realname from pro_documents where id=$id","realname");
	$filename="vault/".$filename;
	//echo $filename;exit;
	$mime=get_mime_type($filename);
	//echo $mime;exit;
	
	
	$op="Opened file $realname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,$id);
		//echo $loga;exit;
	
//$dfile=DownloadFile($filename,$realname);



//header('Content-disposition: inline');
//header('Content-type: $mime'); // not sure if this is the correct MIME type
//readfile($filename);
//exit;

function DownloadFile($file,$realname) { // $file = include path 
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: inline; filename='.basename($realname));
            header('content-Transfer-Encoding:binary');
			header('Accept-Ranges:bytes');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            //readfile($file);
			echo file_get_contents($file);
            exit;
			
			
			        }

    }


?>


<iframe src="<?php echo $filename; ?>" style="width:100%;height:900px;margin:0px;" > </iframe>

