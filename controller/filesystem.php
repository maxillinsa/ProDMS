<?php 


	$act=@$_POST['act'];
	include("func.php");
	include("filehandler.php");
	include("PDFOCR.php");
	
	$dd = date('Y-m-d H:i:s');
	$curuser=@$_COOKIE['curuser'];
	$compid=returnQueryValue("select compid  from pro_users where usern='$curuser'","compid");
	$baseURL=getParamValue("baseurl");
	
	//echo getFilePermission(1,1,"canwrite");exit;
	//getFilePermission($fileid,$usernid,$operation)
	
	if($act=="createfolderinuint"){
		
		$unitid=$_POST['unitid'];
		$cboschema=$_POST['cboschema'];
		$txtfolderinput=$_POST['txtfolderinput'];
		$rnm=recNum("select * from pro_folder where name='$txtfolderinput' and unit=$unitid");
		if($rnm>0){
			echo "exists";exit;
			
		}
		
		$res=mysql_query("insert into pro_folder(name,datecreated,unit,createdby,parentfolder,schemaid) values('$txtfolderinput','$dd',$unitid,'$curuser',0,$cboschema)");
		if($res){
			$folderid=returnQueryValue("select id from pro_folder where name='$txtfolderinput' and unit=$unitid","id");
		$op="Created Folder $txtfolderinput";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
			echo "1";
		}
		else{
			echo "0";
		}
		
	
			
	}
	
	//unitid: unitid,act:"createfolder", txtfolderinput: txtfolderinput, cboschema: cboschema, parentfolder: parentfolder
	
	if($act=="createfolder"){
		$unitid=$_POST['unitid'];
		$cboschema=$_POST['cboschema'];
		$txtfolderinput=$_POST['txtfolderinput'];
		$parentfolder=$_POST['parentfolder'];
		$rnm=recNum("select * from pro_folder where name='$txtfolderinput' and unit=$unitid");
		if($rnm>0){
			echo "exists";exit;
			
		}
		//echo "insert into pro_folder(name,datecreated,,createdby,parentfolder,schemaid) values('$txtfolderinput','$dd',$unitid,'$curuser',$parentfolder,$cboschema)";
		
		$res=mysql_query("insert into pro_folder(name,datecreated,unit,createdby,parentfolder,schemaid) values('$txtfolderinput','$dd',$unitid,'$curuser',$parentfolder,$cboschema)");
		if($res){
				$folderid=returnQueryValue("select id from pro_folder where name='$txtfolderinput' and unit=$unitid","id");
		$op="Created Folder $txtfolderinput";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
			echo "1";
			
		}
		else{
			echo "0";
		}
	
			
	}
	
	//act: 'renamefolder' , txtfolder: txtfolder,folderid:folderid
	
	if($act=="renamefolder"){
		$txtfolder=$_POST['txtfolder'];
		$folderid=$_POST['folderid'];
		//$txtfolderinput=$_POST['txtfolderinput'];
		//$parentfolder=$_POST['parentfolder'];
		
		
		$res=mysql_query("update pro_folder set name='$txtfolder' where id=$folderid");
		if($res){
			
			$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Renamed Folder $foldername to $txtfolder";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
			echo "1";
		}
		else{
			echo "0";
		}
	
			
	}
	
	if($act=="getfilepermission"){
		$cid=$_POST['cid'];
		$curuser=@$_COOKIE['curuser'];
		$viewerid=returnQueryValue("select id from pro_users where usern='$curuser'","id");	
		//echo $viewerid;exit;
		$canview=getFilePermission($cid,$viewerid,"canread");
		echo $canview;
		
	}
	
	//act: 'deletefileapi', fid: fid
	
	if($act=="deletefileapi"){
		$fid=$_POST['fid'];
		$curuser=@$_COOKIE['curuser'];
		$viewerid=returnQueryValue("select id from pro_users where usern='$curuser'","id");	
		//echo $viewerid;exit;
		$canview=getFilePermission($fid,$viewerid,"candelete");
		//echo $canview;
		if($canview=="Y"){
			
			$filename=returnQueryValue("select name from pro_documents where id=$fid","name");	
		$realname=returnQueryValue("select realname from pro_documents where id=$fid","realname");
		$filename="vault/".$filename;
		$docno=returnQueryValue("select docno from pro_documents where id=$fid","docno");
		$res=mysql_query("delete from pro_documents where id=$fid");
		$res=mysql_query("delete from pro_doc_schema_data where docid='$docno'");
		
		//$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Deleted file $realname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,$fid);
		
		@unlink($filename);
		echo "1";
		}
		else{
			echo "ACCESSDENIED";
		}
		
	}
	
	//act: 'deletefolderapi', fid: fid
	if($act=="deletefolderapi"){
		$fid=$_POST['fid'];
		$curuser=@$_COOKIE['curuser'];
		$viewerid=returnQueryValue("select id from pro_users where usern='$curuser'","id");	
		$canview=getFolderPermission($fid,$viewerid,"candelete");
		if($canview=="Y"){
			
			$qry="select * from pro_folder where parentfolder=$fid";
			//echo $qry;exit;
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$rd=mysql_fetch_assoc($res);
				do{
					//$folderid,$dilex=deletefile($fileid);
					$fldop=deleteFolderContent($rd['id']);
				}
				while($rd=mysql_fetch_assoc($res));
				
				$foldername=returnQueryValue("select name from pro_folder where id=$fid","name");
		
		$op="Deleted folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$fid,0);
		
				$rs=mysql_query("delete from pro_folder where id=$fid");
				echo "1";
				
			}
			else{
				//$res=mysql_query($qry);
				$qrx="select * from pro_documents where folderid=$fid";
				//echo $qrx;exit;
				$resx=mysql_query($qrx);
				$nmx=mysql_num_rows($resx);
				if($nmx>0){
					$rdx=mysql_fetch_assoc($resx);
					do{
						$fileid=$rdx['id'];
						$dilex=deletefile($fileid);
					}
					while($rdx=mysql_fetch_assoc($resx));
					$rs=mysql_query("delete from pro_folder where id=$fid");
					echo "1";
					
				}
				else{
					$rs=mysql_query("delete from pro_folder where id=$fid");
					echo "1";
				}
				
			}
			
		}else{
			echo "ACCESSDENIED";
		}
	}
	
	if($act=="deletefile"){
		$fid=$_POST['fid'];
		
		//echo $fid;
		$filename=returnQueryValue("select name from pro_documents where id=$fid","name");	
		$realname=returnQueryValue("select realname from pro_documents where id=$fid","realname");
		$filename="vault/".$filename;
		$docno=returnQueryValue("select docno from pro_documents where id=$fid","docno");
		$res=mysql_query("delete from pro_documents where id=$fid");
		$res=mysql_query("delete from pro_doc_schema_data where docid='$docno'");
		
		$op="Deleted file $filename";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,$fid);
		
		@unlink($filename);
		echo "1";
		
	}
	
	if($act=="getfilepermissionWithOp"){
		$cid=$_POST['cid'];
		$curuser=@$_COOKIE['curuser'];
		$op=@$_COOKIE['op'];
		$viewerid=returnQueryValue("select id from pro_users where usern='$curuser'","id");	
		//echo $viewerid;exit;
		$canview=getFilePermission($cid,$viewerid,$op);
		echo $canview;
		
	}
	
	//act: 'searchfile',txtsearch:txtsearch 
		if($act=="searchfile"){
			$txtsearch=$_POST['txtsearch'];
			$cbolimit=$_POST['cbolimit'];
			if($cbolimit=="All"){
				$qry="select * from pro_folder where name like '%$txtsearch%'";
			}else{
				
				$qry="select * from pro_folder where name like '%$txtsearch%' limit 0,$cbolimit";
			}
			
			//echo $qry;exit;
			
			$res=mysql_query($qry);
			$num=mysql_num_rows($res);
			if($num>0){
				$rd=mysql_fetch_assoc($res);
				do{
					$folderid=$rd['id'];
					$parentfolder=returnQueryValue("select parentfolder from pro_folder where id=$folderid","parentfolder");
				if($parentfolder>0){
					$foldername=returnQueryValue("select name from pro_folder where id=$parentfolder","name");
					echo "<img src='img/folder.png' style='width:30px;height:30px;'><a href='explorer_folder.php?id=$folderid'> /".$foldername."/".$rd['name']."... </a><br>";
					
				}else{				
					echo "<img src='img/folder.png' style='width:30px;height:30px;'> <a href='explorer_folder.php?id=$folderid'>".$rd['name']."...</a> <br>";
				}
					
				}
				while($rd=mysql_fetch_assoc($res));
			}
			else{
				echo " ";
			}
			
			//Search inside files too
			if($cbolimit=="All"){
				$qry1="select * from pro_documents where realname like '%$txtsearch%' or docno like '%$txtsearch%'";
			}
			else{
				$qry1="select * from pro_documents where realname like '%$txtsearch%' or docno like '%$txtsearch%' limit 0,$cbolimit";
			}
			
			//echo $qry1;
			$res1=mysql_query($qry1);
			$num1=mysql_num_rows($res1);
			
			if($num1>0){
				$rd1=mysql_fetch_assoc($res1);
				do{
					//echo "here";
					$folderid=$rd1['id'];
					$parentfolder=$rd1['folderid'];
					$filename="vault/".$rd1['name'];
					$docno=$rd1['docno'];
					$imgo="../img/".get_file_image($filename);
					//echo $rd1['name'];
					//echo $imgo;
				if($parentfolder>0){
					$foldername=returnQueryValue("select name from pro_folder where id=$parentfolder","name");
					
					echo "<img src='img/$imgo' style='width:30px;height:30px;'><a href='fileinfo.php?id=$folderid'> /".$foldername."/".$rd1['realname']."--$docno... </a><br>";
					
				}else{				
					echo "<img src='img/$imgo' style='width:30px;height:30px;'> <a href='fileinfo.php?id=$folderid'>".$rd1['realname']."--$docno... </a><br>";
				}
					
				}
				while($rd1=mysql_fetch_assoc($res1));
			}
			else{
				echo " ";
			}
			
		
		}
	
	//act: 'createfile', txtfileid: txtfileid,cmdept:cmdept,cmunit:cmunit,cmfolder:cmfolder
	
	if($act=="assigntasktouser"){
		//$taskres=registerTask($cbowork,$cbouser,$userid,$taskfileid);
		//fileid: fileid,cbowork: cbowork,act:"savetaskdept", cbouser: cbouser
		$fileid=$_POST['fileid'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$taskres=registerTask($cbowork,$cbouser,$userid,$fileid);
		echo "1";
		
	}
	
	if($act=="assigntasktouserflow"){
		//fileid: fileid,cbowork: cbowork,act:"assigntasktouserflow", cbouser: cbouser, txtnote: txtnote, taskid: taskid
		$fileid=$_POST['fileid'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		$txtnote=$_POST['txtnote'];
		$taskid=$_POST['taskid'];
		$res=mysql_query("update pro_user_tasks set done='Y', donecomment='$txtnote' where id=$taskid");
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		
		
		$taskres=registerTask($cbowork,$cbouser,$userid,$fileid);
		echo "1";
		
	}
	
	if($act=="loadmytickets"){
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$qry="select * from pro_user_tasks where userid=$userid";
		
		$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Tickets</b></h4>";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Document Name</th><th>Task Name</th><th>Status</th><th>Assigned By</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$taskid=$rd['taskid'];
					$fileid=$rd['fileid'];
					$assignedby=$rd['assignedby'];
					$assigner=returnQueryValue("select Fullname from pro_users where id=$assignedby","Fullname");
					$taskname=returnQueryValue("select taskname from pro_workflow_def where id=$taskid","taskname");
					$filename=returnQueryValue("select realname from pro_documents where id=$fileid","realname");
					$fileImage="img/".get_file_image($filename);
					$tast_status=$rd['done'];
					$stao=$tast_status;
					if($tast_status=="Y"){
									$tast_status="Done";
															}
															else{
							$tast_status="Pending";
						}
					
					$ret=$ret."<tr>";
						//$head=@$rd['head'];
					$ret=$ret."<td><img src='$fileImage' style='height:20px;width:20px;'>".$filename."</td>";	
					$ret=$ret."<td><b>".$taskname."</b></td>";
					$ret=$ret."<td>".$tast_status."</td>";
					$ret=$ret."<td>".$assigner."</td>";
					
					$cid=$rd['id'];
					if($stao=="Y"){
						$ret=$ret."<td></td>";
					}else{
					$ret=$ret."<td><a href='dotask2.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Open Ticket'><span class='green'>
					<i class='ace-icon fa fa-folder-open-o bigger-150'></i></span></a>&nbsp;&nbsp;
					</li></td>";	
					}					
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
	}
	
		if($act=="editfileapi"){
		$txtfileid=$_POST['txtfileid'];
		$fileid=$_POST['fileid'];
		$cmdept=$_POST['cmdept'];
		$cmunit=$_POST['cmunit'];
		$cmfolder=$_POST['cmfolder'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		
		
		$rd=mysql_fetch_assoc(mysql_query("select * from pro_instage where id=$fileid"));
		
		$physicalloc="../instage/".$rd['name'];
		$mimetype=getFileMimeType($physicalloc);
		$plainext=".".get_extension($rd['realname']);
		$ext=get_extension($rd['realname']);
		$fnamer=$rd['name'];
		$plainname=str_replace($plainext,"",$rd['realname']);
		$realname=$rd['realname'];
		$date_created=$rd['date_created'];
		$createdby=$rd['usern'];
		$userid=returnQueryValue("select id from pro_users where usern='$createdby'","id");
		
		$rnm=recNum("select * from pro_documents where docno='$txtfileid'");
		$vs=0;
		$taskfileid=0;
		$res2=mysql_query("update pro_documents set folderid=$cmfolder,unit=$cmunit where id=$fileid");
			
			echo "1";
		
		
	
	}
	
	
	
	if($act=="editfilewithdataapi"){
		$txtfileid=$_POST['txtfileid'];
		$fileid=$_POST['fileid'];
		$cmdept=$_POST['cmdept'];
		$cmunit=$_POST['cmunit'];
		$cmfolder=$_POST['cmfolder'];
		$packeddata=$_POST['packeddata'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		//echo $packeddata;exit;
		
		$rd=mysql_fetch_assoc(mysql_query("select * from pro_instage where id=$fileid"));
		
		$physicalloc="../instage/".$rd['name'];
		//echo $physicalloc;exit;
		
		$mimetype=getFileMimeType($physicalloc);
		$plainext=".".get_extension($rd['name']);
		$ext=get_extension($rd['name']);
		$fnamer=$rd['name'];
		$plainname=str_replace($plainext,"",$rd['realname']);
		//echo $plainname;exit;
		$realname=$rd['realname'];
		$date_created=$rd['date_created'];
		$createdby=$rd['usern'];
		$userid=returnQueryValue("select id from pro_users where usern='$createdby'","id");
		$taskfileid=0;
		$rnm=recNum("select * from pro_documents where docno='$txtfileid'");
		$vs=0;
		$res2=mysql_query("update pro_documents set folderid=$cmfolder,unit=$cmunit where id=$fileid");
			$exp=explode(";",$packeddata);
			foreach ($exp as $v) {
							//echo "Current value of \$a: $v.\n";
							if($v==""){}else{
								$vara= $v;
							$bvara=explode("=",$vara);
							$fieldid=str_replace("fld-","",$bvara[0]);
							//echo $bvara[1];exit;
							$fieldvalue=$bvara[1];
							//echo $fieldvalue;exit;
							$fieldname=returnQueryValue("select fieldname from pro_schema_fields where id=$fieldid","fieldname");
							
							$res=mysql_query("insert into pro_doc_schema_data(dataname,datavalue,docid) value('$fieldname','$fieldvalue','$txtfileid')");

								
							}
														
							
					}
					
					
					echo "1";
	
			
	}
	
	
	
	
	if($act=="createfile"){
		$txtfileid=$_POST['txtfileid'];
		$fileid=$_POST['fileid'];
		$cmdept=$_POST['cmdept'];
		$cmunit=$_POST['cmunit'];
		$cmfolder=$_POST['cmfolder'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		
		
		$rd=mysql_fetch_assoc(mysql_query("select * from pro_instage where id=$fileid"));
		
		$physicalloc="../instage/".$rd['name'];
		$mimetype=getFileMimeType($physicalloc);
		$plainext=".".get_extension($rd['realname']);
		$ext=get_extension($rd['realname']);
		$fnamer=$rd['name'];
		$plainname=str_replace($plainext,"",$rd['realname']);
		$realname=$rd['realname'];
		$date_created=$rd['date_created'];
		$createdby=$rd['usern'];
		$userid=returnQueryValue("select id from pro_users where usern='$createdby'","id");
		
		$rnm=recNum("select * from pro_documents where docno='$txtfileid'");
		$vs=0;
		$taskfileid=0;
		if($rnm>0){
			//echo "exists";exit;
			
			if($rnm==1){
				$oldfid=returnQueryValue("select id from pro_documents where docno='$txtfileid'","id");
				$vs=$rnm+1;
			$newfilename=$plainname.".".$ext;
			$foldername=$txtfileid;
			//Create a folder for it
			$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
			$res=mysql_query("Insert into pro_folder(name,datecreated,unit,createdby,schemaid,parentfolder) values('$foldername','$dd',$cmunit,'SYS',$schemaid,$cmfolder)");
			$newfolderid=returnQueryValue("select max(id) as ido from pro_folder where unit=$cmunit","ido");
			$txtfileid=$txtfileid;
			$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
			values ('$fnamer','$txtfileid','$newfilename',$userid,'$dd',$newfolderid,'$ext','$mimetype',$vs,$cmunit)");
			
			$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$newfolderid and realname='$newfilename' and userid=$userid","id");
			
			
			//move first file to the new folder
			$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
			$nextfilename="../vault/".$fnamer;
				
			}else{
				$vs=$rnm+1;
				$newfilename=$plainname.".".$ext;
			$foldername=$txtfileid;
			//Create a folder for it
			$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
			//$res=mysql_query("Insert into pro_folder(name,datecreated,unit,createdby,schemaid,parentfolder) values('$foldername','$dd',$cmunit,'SYS',$schemaid,$cmfolder)");
			
			$newfolderid=returnQueryValue("select id from pro_folder where unit=$cmunit and name='$txtfileid'","id");
			$txtfileid=$txtfileid;
			$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
			values ('$fnamer','$txtfileid','$newfilename',$userid,'$dd',$newfolderid,'$ext','$mimetype',$vs,$cmunit)");
			
			$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$newfolderid and realname='$newfilename' and userid=$userid","id");
			
			$nextfilename="../vault/".$fnamer;
			//move first file to the new folder
			//$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
				
			}
			
				$filx=copy($physicalloc,$nextfilename);
				 if(!$filx)
				 {
					//var_dump($filx);
					//echo "Falied";
					 unlink($physicalloc);
				 }
				 else
				 {
					// echo "copied $file into $newfile\n";
				 }
				
				
			
		}
		else{
			
			$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
			$newfilename=$plainname.".".$ext;
		
			$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
			values ('$fnamer','$txtfileid','$newfilename',$userid,'$dd',$cmfolder,'$ext','$mimetype',1,$cmunit)");
			
			$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$newfolderid and realname='$newfilename' and userid=$userid","id");
			
			$nextfilename="../vault/".$fnamer;
			//move first file to the new folder
			//$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
				
			}
			
				$filx=copy($physicalloc,$nextfilename);
				 if(!$filx)
				 {
					//var_dump($filx);
					//echo "Falied";
					 unlink($physicalloc);
				 }
				 else
				 {
					// echo "copied $file into $newfile\n";
				 }
				
		 if($cbowork==""){}else{
						if($cbouser==""){}else{
							$taskres=registerTask($cbowork,$cbouser,$userid,$taskfileid);
						}
				 }
				 
				 echo "1";
		
		
	
	}
	
			
	
	if($act=="createfilewithdata"){
		$txtfileid=$_POST['txtfileid'];
		$fileid=$_POST['fileid'];
		$cmdept=$_POST['cmdept'];
		$cmunit=$_POST['cmunit'];
		$cmfolder=$_POST['cmfolder'];
		$packeddata=$_POST['packeddata'];
		$cbowork=$_POST['cbowork'];
		$cbouser=$_POST['cbouser'];
		//echo $packeddata;exit;
		
		$rd=mysql_fetch_assoc(mysql_query("select * from pro_instage where id=$fileid"));
		
		$physicalloc="../instage/".$rd['name'];
		//echo $physicalloc;exit;
		
		$mimetype=getFileMimeType($physicalloc);
		$plainext=".".get_extension($rd['name']);
		$ext=get_extension($rd['name']);
		$fnamer=$rd['name'];
		$plainname=str_replace($plainext,"",$rd['realname']);
		//echo $plainname;exit;
		$realname=$rd['realname'];
		$date_created=$rd['date_created'];
		$createdby=$rd['usern'];
		$userid=returnQueryValue("select id from pro_users where usern='$createdby'","id");
		$taskfileid=0;
		$rnm=recNum("select * from pro_documents where docno='$txtfileid'");
		$vs=0;
		if($rnm>0){
			//echo "exists";exit;
			
			
			
			if($rnm==1){
				
					$oldfid=returnQueryValue("select id from pro_documents where docno='$txtfileid'","id");
					$vs=$rnm+1;
				$newfilename=$plainname.".".$ext;
				$foldername=$txtfileid;
				//Create a folder for it
				$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
				$res=mysql_query("Insert into pro_folder(name,datecreated,unit,createdby,schemaid,parentfolder) values('$foldername','$dd',$cmunit,'SYS',$schemaid,$cmfolder)");
				$newfolderid=returnQueryValue("select max(id) as ido from pro_folder where unit=$cmunit","ido");
				$txtfileid=$txtfileid;
				$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
				values ('$fnamer','$txtfileid','$newfilename',$userid,'$dd',$newfolderid,'$ext','$mimetype',$vs,$cmunit)");
				$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$newfolderid and realname='$newfilename' and userid=$userid","id");
				//move first file to the new folder
				$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
				$nextfilename="../vault/".$fnamer;
				
				
				
			}
			
			else{
				//echo "ooo".$rnm;exit;
					$vs=$rnm+1;
					//echo "Here";exit;
					$newfilename=$plainname.".".$ext;
				$foldername=$txtfileid;
				//Create a folder for it
				$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
				//$res=mysql_query("Insert into pro_folder(name,datecreated,unit,createdby,schemaid,parentfolder) values('$foldername','$dd',$cmunit,'SYS',$schemaid,$cmfolder)");
				
				$newfolderid=returnQueryValue("select id from pro_folder where unit=$cmunit and name='$txtfileid'","id");
				//echo $newfolderid;exit;
				//$txtfileid=$plainname;
				$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
				values ('$fnamer','$txtfileid','$newfilename',$userid,'$dd',$newfolderid,'$ext','$mimetype',$vs,$cmunit)");
				$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$newfolderid and realname='$newfilename' and userid=$userid","id");
				$nextfilename="../vault/".$fnamer;
				//move first file to the new folder
				//$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
				
			}
			//echo $physicalloc;exit;
			//move_uploaded_file($physicalloc,  $nextfilename);
			$filx=copy($physicalloc,$nextfilename);
				 if(!$filx)
				 {
					//var_dump($filx);
					//echo "Falied";
					unlink($physicalloc);
				 }
				 else
				 {
					// echo "copied $file into $newfile\n";
				 }
				 
			}
		
		else{
			
			$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmfolder","schemaid");
			$newfilename=$plainname.".".$ext;
		
			$res2=mysql_query("insert into pro_documents(name, docno, realname,userid,date_created,folderid,ext,mimetype,version,unit)
			values ('$fnamer','$txtfileid','$realname',$userid,'$dd',$cmfolder,'$ext','$mimetype',1,$cmunit)");
			$taskfileid=returnQueryValue("select id from pro_documents where unit=$cmunit and folderid=$cmfolder and realname='$realname' and userid=$userid","id");
			$nextfilename="../vault/".$fnamer;
			//move first file to the new folder
			//$res3=mysql_query("update pro_documents set folderid=$newfolderid where id=$oldfid");
				
			}
			//copy($physicalloc,$nextfilename);
			//move_uploaded_file($physicalloc,  $nextfilename);
		$filx=copy($physicalloc,$nextfilename);
				 if(!$filx)
				 {
					//var_dump($filx);
					//echo "Falied";
					unlink($physicalloc);
				 }
				 else
				 {
					// echo "copied $file into $newfile\n";
				 }
				 
				 
		
		$exp=explode(";",$packeddata);
			foreach ($exp as $v) {
							//echo "Current value of \$a: $v.\n";
							if($v==""){}else{
								$vara= $v;
							$bvara=explode("=",$vara);
							$fieldid=str_replace("fld-","",$bvara[0]);
							//echo $bvara[1];exit;
							$fieldvalue=$bvara[1];
							//echo $fieldvalue;exit;
							$fieldname=returnQueryValue("select fieldname from pro_schema_fields where id=$fieldid","fieldname");
							
							$res=mysql_query("insert into pro_doc_schema_data(dataname,datavalue,docid) value('$fieldname','$fieldvalue','$txtfileid')");

								
							}
														
							
					}
					
					 if($cbowork==""){}else{
						if($cbouser==""){}else{
							$taskres=registerTask($cbowork,$cbouser,$userid,$taskfileid);
						}
				 }
					
					echo "1";
	
			
	}
	
	if($act=="getindexdatainstage"){
		//fileid: fileid,cmfolder:cmfolder,act: 'getindexdatainstage'
		$fieldos=$_POST['fieldos'];
		$fileid=$_POST['fileid'];
		$cmfolder=$_POST['cmfolder'];
		//,fld-1,fld-2,fld-3
		$filename="../instage/".returnQueryValue("select name from pro_instage where id=$fileid","name");
		$scannedtext =  pdf2text($filename);
		$stringresult =sanitize_text($scannedtext);
		//echo $stringresult;exit;
		//echo $scannedtext;exit;
		
		$exp=explode(",",$fieldos);
		$indexexists="N";
		$dto="";
		foreach ($exp as $v) {
			if($v==""){}else{
				//echo $v;
				$fieldsplit=explode("-",$v);
				$fieldid=$fieldsplit[1];
				$indexexists=isIndexField($fieldid);
				if($indexexists=="Y"){
					//echo $indexexists;
					$indexname=returnQueryValue("select fieldname from pro_schema_fields where id=$fieldid","fieldname");
					//echo $indexname;
					//echo $stringresult;
					$indexexists=containsWord($stringresult,$indexname);
					//$indexexists= containsWord("hey you there","you");
					//echo $indexexists;
					if($indexexists==true){
						//echo "exists";
						$datax=explode($indexname,$stringresult);
						//echo $datax[1];
						$dt=explode(" ",$datax[1]);
						if(trim($dt[0])==":"){
							$dto=$dto.$indexname.": <b>".$dt[1]."<b><br>";
							//echo $dto;
						}
						else{
								if(trim($dt[0])=="="){
									$dto=$dto.$indexname.": <b>".$dt[1]."</b><br>";
									//echo $dto;
								}
								else{
									$dto=$dto.$indexname.": <b>".$dt[0]."</b><br>";
									//echo $dto;
								}
							
							
						}
						echo $dto;
					}else{
						echo "xxx";
						
					}
				
				
				
				
				
				}
			}
		}
		
		
	}
	
	function sanitize_text($str){
		
		$stringresult = trim(preg_replace('/\s\s+/', ' ', $str));
		//$stringresult = iconv("UTF-8","UTF-8//IGNORE",$stringresult);
		$stringresult = str_replace("\n", '', $stringresult);
		$stringresult = converToPlain( $stringresult);
		return $stringresult;
			}
			
		function converToPlain($text){
			$text = preg_replace('"{\*?\\\\.+(;})|\\s?\\\[A-Za-z0-9]+|\\s?{\\s?\\\[A-Za-z0-9‹]+\\s?|\\s?}\\s?"', '', $text);
			return $text;
		}

	
	function isIndexField($fieldid){
		$qry="select indexkey from pro_schema_fields where id=$fieldid";
		return returnQueryValue($qry,"indexkey");
	}
	
	
	
	function containsWord($str, $word)
{
    return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
}
	
	function get_extension($file) {
 $extension = end(explode(".", $file));
 return $extension ? $extension : false;
}

function deletefile($fileid){
	
	
						$filename=returnQueryValue("select name from pro_documents where id=$fileid","name");	
						$realname=returnQueryValue("select realname from pro_documents where id=$fileid","realname");
						$filename="vault/".$filename;
						$docno=returnQueryValue("select docno from pro_documents where id=$fileid","docno");
						$res=mysql_query("delete from pro_documents where id=$fileid");
						$res=mysql_query("delete from pro_doc_schema_data where docid='$docno'");
						@unlink($filename);
}

function deleteFolderContent($folderid){
	$qrx="select * from pro_documents where folderid=$folderid";
				$resx=mysql_query($qrx);
				$nmx=mysql_num_rows($resx);
				if($nmx>0){
					$rdx=mysql_fetch_assoc($resx);
					do{
						$fileid=$rdx['id'];
						$dilex=deletefile($fileid);
					}
					while($rdx=mysql_fetch_assoc($resx));
					$rs=mysql_query("delete from pro_folder where id=$folderid");
					//echo "1";
				}
	
}

function registerTask($cbowork,$cbouser,$userid,$taskfileid){
	
	$nm=recNum("select * from pro_user_tasks where fileid=$taskfileid and userid=$cbouser and taskid=$taskfileid");
	if($nm>0){}else{
		$res=mysql_query("Insert into pro_user_tasks (taskid,userid, fileid,assignedby) values($cbowork,$cbouser,$taskfileid,$userid)");
	}
}
	
?>