<?php 


	$act=$_POST['act'];
	include("func.php");
	$dd = date('Y-m-d H:i:s');
	$curuser=@$_COOKIE['curuser'];
	$compid=returnQueryValue("select compid  from pro_users where usern='$curuser'","compid");
	
	if($act=="loaddept"){
	
		$qry="select * from pro_departments where companyid=$compid and deleted='N' order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
	}
	//act: 'loaddeptcmbbycompany', cmcompany: cmcompany 
	if($act=="loaddeptcmbbycompany"){
		$cmcompany=$_POST['cmcompany'];
		$qry="select * from pro_departments where companyid=$cmcompany and deleted='N' order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	//act: 'viewuseractvities', cmcompany: cmcompany
	
	if($act=="viewuseractvities"){
		$cmcompany=$_POST['cmcompany'];
		$qry="select * from pro_log where userid=$cmcompany order by id asc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Users</b></h4>";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>SN</th><th>Action</th><th>Object</th><th>Date/Time</th></tr></thead><tbody>";			
				
				$i=1;
				
				do{
					$objtext="";
					$ret=$ret."<tr>";
						//$head=@$rd['head'];
						$ret=$ret."<td>".$i."</td>";
					$ret=$ret."<td>".$rd['comment']."</td>";	
					$fileid=$rd['fileid'];
					$folderid=$rd['folderid'];
					if($fileid>0){
						$docno=returnQueryValue("select docno from pro_documents where id=$fileid","docno");
						$objtext=returnQueryValue("select realname from pro_documents where id=$fileid","realname")." <b>$docno</b>";
						
					}
					if($folderid>0){
						$objtext=returnQueryValue("select name from pro_folder where id=$folderid","name")."/";
					}
					$ret=$ret."<td>".$objtext."</td>";
					$ret=$ret."<td>".$rd['ddate']."</td>";
					
																				
																				
						$ret=$ret."</tr>";	
										
								$i=$i+1;												
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
	}
	
	
	if($act=="loadusersall"){
		
		$qry="select * from pro_users where compid=$compid order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					    $deptid=$rd['deptid'];
						$deptname=returnQueryValue("select name from pro_departments where id=$deptid","name");
						$prodname=$rd['Fullname'];
							$id=$rd['id'];
								echo $id."|".$prodname."@".$deptname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	if($act=="loaduserdept"){
		$deptid=$_POST['deptid'];
		
		
		$qry="select * from pro_users where deptid=$deptid order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['Fullname'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	if($act=="loadtaskcmb"){
		$deptid=$_POST['deptid'];
		
		$qry="select * from pro_workflow_def where deptid=$deptid order by task_order asc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['taskname'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	
	
	if($act=="loadselecteddeptcmb"){
		//act: 'loadselecteddeptcmb', folderid: folderid
		$folderid=$_POST['folderid'];
		$qry="select * from pro_perm_folder_dept where folderid=$folderid and deleted='N' order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					$deptid=$rd['deptid'];
						$prodname=returnQueryValue("select name from pro_departments where id=$deptid","name");
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
	}
	
	
	
	if($act=="movetouserlevel"){
		$folderid=$_POST['folderid'];
		$nm=recNum("select * from pro_perm_folder_dept where folderid=$folderid and deleted='N'");
		if($nm>0){
			echo "1";exit;
		}else{
			echo "Add a department to this folder to begin with";
		}
		
		
		
	}
	
	if($act=="adddepttofolder"){
		$folderid=$_POST['folderid'];
		$cmbdepartments=$_POST['cmbdepartments'];
		$cmcompany=$_POST['cmcompany'];
		$nm=recNum("select * from pro_perm_folder_dept where folderid=$folderid and deptid=$cmbdepartments and deleted='N'");
		if($nm>0){
			echo "1";exit;
		}
		
		$res_public=mysql_query("update pro_folder set public='N' where id=$folderid");
		
		$res=mysql_query("insert into pro_perm_folder_dept(folderid,deptid,cid) values ($folderid,$cmbdepartments,$cmcompany)");
		
		$department=returnQueryValue("select name from pro_departments where id=$cmbdepartments","name");
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		
		$op="Added $department to folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);

		echo "1";
		
	}
	
	
	if($act=="addusertofolder"){
		$folderid=$_POST['folderid'];
		$cbousers=$_POST['cbousers'];
		$cmcompany=$_POST['cmcompany'];
		$deptid=returnQueryValue("select deptid from pro_users where id=$cbousers","deptid");
		$nm=recNum("select * from pro_perm_folder_dept_users where folderid=$folderid and deptid=$deptid and userid=$cbousers");
		if($nm>0){
			echo "1";exit;
		}
		
		$res=mysql_query("insert into pro_perm_folder_dept_users (folderid,userid,deptid) values ($folderid,$cbousers,$deptid)");
		echo "1";
		
		$Fullname=returnQueryValue("select Fullname from pro_users where id=$cbousers","Fullname");
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Added $Fullname to folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
		
	}
	
	if($act=="editmetadatafield"){
	
	
		$indexkey=$_POST['indexkey'];
		$txtsize=$_POST['txtsize'];
		$txtfieldname=$_POST['txtfieldname'];
		$cbodatatype=$_POST['cbodatatype'];
		$cid=$_POST['cid'];
		
		$res=mysql_query("update pro_schema_fields set fieldname='$txtfieldname',datatype='$cbodatatype',datasize=$txtsize,indexkey='$indexkey' where id=$cid");
		$op="Edited metadata field for $txtfieldname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
		echo "1";
	
	}
	
	if($act=="edituser"){
		//:cid, txtfullname: txtfullname, act: 'edituser', cbodept: cbodept,cbounit: cbounit, txtpass: txtpass, cbousertype: cbousertype
		$userid=$_POST['userid'];
		$txtfullname=$_POST['txtfullname'];
		$cbodept=$_POST['cbodept'];
		//echo $cbodept;exit;
		$cbounit=$_POST['cbounit'];
		$txtpass=$_POST['txtpass'];
		
		$cbousertype=$_POST['cbousertype'];
		$activey=$_POST['activey'];
		if($txtpass==""){
			$res=mysql_query("update pro_users set Fullname='$txtfullname',deptid=$cbodept, unitid=$cbounit,usertype='$cbousertype',active='$activey' where id=$userid");
		}
		else{
			$txtpass=sha1($txtpass);
		$res=mysql_query("update pro_users set Fullname='$txtfullname',pword='$txtpass',deptid=$cbodept, unitid=$cbounit,usertype='$cbousertype',active='$activey' where id=$userid");
		}
		
		$op="Edited user account for $txtfullname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
		
		echo "1";
		
	}
	
	
	
	if($act=="loadcompanycmb"){
			$qry="select * from dms_companies where status='Y'";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	if($act=="loadcanonicausers"){
		
		//act: 'loadcanonicausers', folderid: folderid
		$folderid=$_POST['folderid'];
		
		$qry="select * from pro_perm_folder_dept where deleted='N' and folderid=$folderid";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				
				$rd=mysql_fetch_assoc($res);
				
				do{
					
					$deptid=$rd['deptid'];
					//echo $deptid;
					$deptname=returnQueryValue("select name from pro_departments where id=$deptid","name");
					$qr="select * from pro_users where deptid=$deptid";
					$rs=mysql_query($qr);
					$nmuser=mysql_num_rows($rs);
					if($nmuser>0){
						//echo "here";
						$rduser=mysql_fetch_assoc($rs);
						do{
							$fullname=$rduser['Fullname'];
							$usid=$rduser['id'];
							$namepack=$fullname."@".$deptname;
							echo $usid."|".$namepack.";";
							
						}
						while($rduser=mysql_fetch_assoc($rs));
					}
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
		
	}
	
	//loadselectcanonicausers
	
	if($act=="loadselectcanonicausers"){
		
		//act: 'loadcanonicausers', folderid: folderid
		$folderid=$_POST['folderid'];
		$qry="select * from pro_perm_folder_dept_users where deleted='N' and folderid=$folderid";
		$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$rd=mysql_fetch_assoc($res);
				do{
					$usid=$rd['userid'];
					$deptid=$rd['deptid'];
					$user_fullname=returnQueryValue("select Fullname from pro_users where id=$usid","Fullname");
					$deptname=returnQueryValue("select name from pro_departments where id=$deptid","name");
					$namepack=$user_fullname."@".$deptname;
							echo $usid."|".$namepack.";";
					
				}
				while($rd=mysql_fetch_assoc($res));	
				
			}
		
	}
	
	if($act=="removedepttofolder"){
		//act: 'removedepttofolder', cmbseldepartments:cmbseldepartments
		$cmbseldepartments=$_POST['cmbseldepartments'];
		$folderid=$_POST['folderid'];
		//pro_perm_folder_dept_users
		$res_users=mysql_query("delete from pro_perm_folder_dept_users where deptid=$cmbseldepartments and folderid=$folderid");
		$res_users=mysql_query("delete from pro_perm_folder_dept_users_roles where deptid=$cmbseldepartments and folderid=$folderid");
		
		$res=mysql_query("update pro_perm_folder_dept set deleted='Y' where id=$cmbseldepartments and folderid=$folderid");
		
		$department=returnQueryValue("select name from pro_departments where id=$cmbseldepartments","name");
		
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Removed $department from folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
		
		echo "1";
	}
	

	if($act=="removeusertofolder"){
		$userid=$_POST['cmbseldepartments'];
		$folderid=$_POST['folderid'];
		
		$res_users=mysql_query("delete from pro_perm_folder_dept_users_roles where userid=$userid and folderid=$folderid");
		$res_users=mysql_query("delete from pro_perm_folder_dept_users where userid=$userid and folderid=$folderid");
		
		
		$Fullname=returnQueryValue("select Fullname from pro_users where id=$userid","Fullname");
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Removed $Fullname from folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
		echo "1";
	}
	
	if($act=="makefolderpublic"){
		$folderid=$_POST['folderid'];
		$res=mysql_query("update pro_folder set public='Y' where id=$folderid");
		
	
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Made folder $foldername public";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
		echo "1";

	
	}
	
	if($act=="saveuserfolderroles"){
		//echo "here";exit;
		$folderid=$_POST['folderid'];
		$seluser=$_POST['seluser'];
		$op=$_POST['op'];
		$opvalue=$_POST['opvalue'];
		$deptid=returnQueryValue("select deptid from pro_perm_folder_dept_users where userid=$seluser and folderid=$folderid","deptid");
		
		$nm=recNum("select * from pro_perm_folder_dept_users_roles where deptid=$deptid and userid=$seluser and folderid=$folderid");
		//echo "update pro_perm_folder_dept_users_roles set $op='$opvalue' where deptid=$deptid and userid=$seluser and folderid=$folderid";exit;
	//	echo $nm;exit;
		if($nm>0){
			//echo "Here";exit;
			
			$qry="update pro_perm_folder_dept_users_roles set $op='$opvalue' where deptid=$deptid and userid=$seluser and folderid=$folderid";
			$res=mysql_query($qry);
			
		}
		else{
			$qry="insert into pro_perm_folder_dept_users_roles ($op,deptid,userid,folderid) values('$opvalue',$deptid,$seluser,$folderid)";
			$res=mysql_query($qry);
		}
		
		$Fullname=returnQueryValue("select Fullname from pro_users where id=$seluser","Fullname");
		$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
		$op="Updated $op access to $opvalue on folder $foldername";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,$folderid,0);
		
		echo "1";
	}
	
	
	
	
	if($act=="getroledetails"){
		$folderid=$_POST['folderid'];
		$seluser=$_POST['seluser'];
		$rn=recNum("select * from pro_perm_folder_dept_users_roles where userid=$seluser and folderid=$folderid");
		if($rn>0){
			$canshare=returnQueryValue("select canshare from pro_perm_folder_dept_users_roles where userid=$seluser and folderid=$folderid","canshare");
			$candelete=returnQueryValue("select candelete from pro_perm_folder_dept_users_roles where userid=$seluser and folderid=$folderid","candelete");
			$canread=returnQueryValue("select canread from pro_perm_folder_dept_users_roles where userid=$seluser and folderid=$folderid","canread");
			$canwrite=returnQueryValue("select canwrite from pro_perm_folder_dept_users_roles where userid=$seluser and folderid=$folderid","canwrite");
			//echo "ysy";
			//echo $canshare.$candelete.$canread.$canwrite;
			$pack="";
			
			$canshareid="canshare_".$folderid."_".$seluser;
			if($canshare=="Y"){
				$pack=$pack."<input type='checkbox' name='$canshareid' id='$canshareid' value='Share' onclick='applyPrivi(\"$canshareid\");' checked> Share&nbsp;&nbsp;";
			}
			else{
				$pack=$pack."<input type='checkbox' name='$canshareid' id='$canshareid' onclick='applyPrivi(\"$canshareid\");' value='Share'> Share&nbsp;&nbsp;";
				
			}
			
			$candeleteid="candelete_".$folderid."_".$seluser;
			if($candelete=="Y"){
				$pack=$pack."<input type='checkbox' name='$candeleteid' id='$candeleteid' onclick='applyPrivi(\"$candeleteid\");' value='Delete' checked> Delete&nbsp;&nbsp;";
			}
			else{
				$pack=$pack."<input type='checkbox' name='$candeleteid' id='$candeleteid' onclick='applyPrivi(\"$candeleteid\");' value='Delete'> Delete&nbsp;&nbsp;";
				
			}
			
			$canreadid="canread_".$folderid."_".$seluser;
			if($canread=="Y"){
				$pack=$pack."<input type='checkbox' name='$canreadid' id='$canreadid' value='Read' onclick='applyPrivi(\"$canreadid\");' checked> Read&nbsp;&nbsp;";
			}
			else{
				$pack=$pack."<input type='checkbox' name='$canreadid' id='$canreadid' onclick='applyPrivi(\"$canreadid\");' value='Read'> Read&nbsp;&nbsp;";
				
			}
			
			$canwriteid="canwrite_".$folderid."_".$seluser;
			if($canwrite=="Y"){
				$pack=$pack."<input type='checkbox' name='$canwriteid' id='$canwriteid' value='Write' onclick='applyPrivi(\"$canwriteid\");' checked> Write&nbsp;&nbsp;";
			}
			else{
				$pack=$pack."<input type='checkbox' name='$canwriteid' id='$canwriteid' onclick='applyPrivi(\"$canwriteid\");' value='Write'>Write&nbsp;&nbsp;";
				
			}
			
			
		}else{
			$pack="";
			$canshareid="canshare_".$folderid."_".$seluser;
			$pack=$pack."<input type='checkbox' name='$canshareid' id='$canshareid' value='Share' onclick='applyPrivi(\"$canshareid\");'> Share&nbsp;&nbsp;";
			
			$candeleteid="candelete_".$folderid."_".$seluser;
			$pack=$pack."<input type='checkbox' name='$candeleteid' id='$candeleteid' value='Delete' onclick='applyPrivi(\"$candeleteid\");'> Delete&nbsp;&nbsp;";
			
			$canreadid="canread_".$folderid."_".$seluser;
			$pack=$pack."<input type='checkbox' name='$canreadid' id='$canreadid' value='Read' onclick='applyPrivi(\"$canreadid\");'> Read&nbsp;&nbsp;";
			
			$canwriteid="canwrite_".$folderid."_".$seluser;
			$pack=$pack."<input type='checkbox' name='$canwriteid' id='$canwriteid' value='Write' onclick='applyPrivi(\"$canwriteid\");'> Write&nbsp;&nbsp;";
			
			
			
			
		}
		echo $pack;
		
	}
	
	
	
	if($act=="loaddeptunit"){
		$dept=$_POST['dept'];
		$qry="select * from pro_dept_units where deptid=$dept order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
	}
	
	//act: 'loadschemacbo', unitid: unitid 
	
	if($act=="loadschemacbo"){
		$unitid=$_POST['unitid'];
		//echo $unitid;exit;
		$deptid=returnQueryValue("select deptid from pro_dept_units where id=$unitid","deptid");
		$compid=returnQueryValue("select companyid from pro_departments where id=$deptid","companyid");
		
		//echo $compid;exit;
		$qry="select * from pro_schema where compid=$compid order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				//echo "here";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
		
	}
	
	
	
		if($act=="loadfoldercmb"){
		$unitid=$_POST['unitid'];
		$qry="select * from pro_folder where unit=$unitid order by id desc";
		//echo $qry;exit;
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				do{
					$parentfolder=$rd['parentfolder'];
					if($parentfolder>0){
						
						
						$prodname=returnQueryValue("select name from pro_folder where id=$parentfolder","name");
						$foldr="../".$prodname."/".$rd['name'];
							$id=$rd['id'];
								echo $id."|".$foldr.";";
						
					}else{
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo $id."|".$prodname.";";
					}
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}
	}
	
	if($act=="loadschemabyunit"){
		$cmunit=$_POST['cmfolder'];
		
		if($cmunit==""){
			
			echo "";exit;
		}
		
		if($cmunit=="0"){
			
			echo "";exit;
		}
		
		$schemaid=returnQueryValue("select schemaid from pro_folder where id=$cmunit","schemaid");
		if($schemaid==""){
			echo "";exit;
		}
		$qry="select * from pro_schema_fields where schemaid=$schemaid order by id asc";
		//echo $qry;
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Schema Details</b></h4>";
				$rd=mysql_fetch_assoc($res);
				
				do{
					$fld="";
						$fieldname=$rd['fieldname'];
						$datatype=$rd['datatype'];
						$datasize=$rd['datasize'];
						$fid="fld-".$rd['id'];
						$fldpack=$fldpack.",".$fid;
						if($datatype=="varcharo"){
							$fld="<div><label for='form-field-select-1'><b>$fieldname</b></label>";
							$fld=$fld."<input type='text' id='$fid' class='form-control' maxlength='$datasize' size='$datasize'/></div>";
											
						}
						
						if($datatype=="numbero"){
							$fld="<div><label for='form-field-select-1'><b>$fieldname</b></label>";
							$fld=$fld."<input type='number' id='$fid' class='form-control' maxlength='$datasize' size='$datasize'/></div>";
											
						}
						
						if($datatype=="dateo"){
							$fld="<div><label for='form-field-select-1'><b>$fieldname</b></label>";
							$fld=$fld."<input type='date' id='$fid' class='form-control' maxlength='$datasize' size='$datasize'/></div>";
											
						}
						
						
						
						
						$ret=$ret.$fld;
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				echo $ret."|".$fldpack;				
				
			}
	}
	
	if($act=="loadusertable"){
		
		$cbounit=$_POST['cbounit'];
		
			if($cbounit==""){
			
			echo "-";exit;
		}
		
		if($cbounit=="0"){
			
			echo "-";exit;
		}
	
		
		$qry="select * from pro_users where unitid=$cbounit and active='Y' order by id asc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Users</b></h4>";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Fullname</th><th>Username</th><th>Email</th><th>User Type</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					if($rd['usern']=="SYS"){}else{
					$ret=$ret."<tr>";
						//$head=@$rd['head'];
					$ret=$ret."<td>".$rd['Fullname']."</td>";	
					$ret=$ret."<td>".$rd['usern']."</td>";
					$ret=$ret."<td>".$rd['email']."</td>";
					$ret=$ret."<td>".$rd['usertype']."</td>";
					
					$cid=$rd['id'];
					
					$ret=$ret."<td><a href='edituser.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'>
					<i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a>&nbsp;&nbsp;
					<a href='deletedepartment.php?id=$cid' class='tooltip-error' data-rel='tooltip' title='Delete'><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'>
					</span></a></li></td>";																	
																				
						$ret=$ret."</tr>";	
					}						
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
		
		
	}
	
	if($act=="loaddepttable"){
		//act: 'loaddepttable', cmcompany: cmcompany
		$cmcompany=$_POST['cmcompany'];
		
			if($cmcompany==""){
			
			echo "-";exit;
		}
		
		if($cmcompany=="0"){
			
			echo "-";exit;
		}
	
		
		$qry="select * from pro_departments where companyid=$cmcompany and deleted='N' order by id asc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Departments</b></h4>";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Department</th><th>Short Code</th><th>Head</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						$head=@$rd['head'];
					$ret=$ret."<td>".$rd['name']."</td>";	
					$ret=$ret."<td>".$rd['shtcode']."</td>";
					$ret=$ret."<td>".$head."</td>";
					
					$cid=$rd['id'];
					
					$ret=$ret."<td><a href='editdepartment.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'>
					<i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a>&nbsp;&nbsp;
					<a href='deletedepartment.php?id=$cid' class='tooltip-error' data-rel='tooltip' title='Delete'><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'>
					</span></a></li></td>";																	
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
		
	}

	
	if($act=="savemetadata"){
		
		$txtmetaname=$_POST['txtmetaname'];
		$txtdescription=$_POST['txtdescription'];
		$cid=$_POST['cid'];
		
		$rnm=recNum("select * from pro_schema where name='$txtmetaname' and compid=$cid");
		if($rnm>0){
			
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into pro_schema(name,description,compid) values ('$txtmetaname','$txtdescription',$cid)");
		
		if($res){
			
			
		$op="Created Metadata $txtmetaname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
	}
	
	if($act=="savecompany"){
		
		$txtcontactaddress=$_POST['txtcontactaddress'];
		$txtcompany=$_POST['txtcompany'];
		$txtdomain=$_POST['txtdomain'];
		$txtmobile=$_POST['txtmobile'];
		$txtemail=$_POST['txtemail'];
		$txtcontactperson=$_POST['txtcontactperson'];
		$rnm=recNum("select * from dms_companies where name='$txtcompany'");
		if($rnm>0){
			
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into dms_companies(name,website,mobile,email,contact_person,address,date_created) values ('$txtcompany','$txtdomain','$txtmobile','$txtemail','$txtcontactperson','$txtcontactaddress','$dd')");
		
		if($res){
			$op="Created Company $txtcompany";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
	}
	
	if($act=="savedept"){
		//txtdept: txtdept,txtshortcode: txtshortcode,act:"savedept", cid: cid
		$txtdept=$_POST['txtdept'];
		$txtshortcode=$_POST['txtshortcode'];
		$cid=$_POST['cid'];
		
		$rnm=recNum("select * from pro_departments where name='$txtdept' and companyid=$cid");
		if($rnm>0){
			
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into pro_departments(name,companyid,shtcode) values ('$txtdept',$cid,'$txtshortcode')");
		
		if($res){
			
			$op="Created Department $txtdept";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	if($act=="createuser"){
		//unitid: unitid,txtfname: txtfname, act: 'createuser', txtusername: txtusername,txtemail: txtemail, txtpass: txtpass, cbousertype: cbousertype
		$unitid=$_POST['unitid'];
		$txtfname=$_POST['txtfname'];
		$txtusername=$_POST['txtusername'];
		$txtemail=$_POST['txtemail'];
		$txtpass=$_POST['txtpass'];
		$cbousertype=$_POST['cbousertype'];
		$txtpass=sha1($txtpass);
		
		$deptid=returnQueryValue("select deptid from pro_dept_units where id=$unitid","deptid");
		$compid=returnQueryValue("select companyid from pro_departments where id=$deptid","companyid");
		$rnm=recNum("select * from pro_users where usern='$txtusername'");
		if($rnm>0){
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into pro_users(Fullname,usern, pword,deptid,unitid,email,compid,usertype) values ('$txtfname','$txtusername','$txtpass',$deptid,$unitid,'$txtemail',$compid,'$cbousertype')");
		
		if($res){
			
			$op="Created User $txtfname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	if($act=="saveunit"){
		//txtunit: txtunit,txtshortcode: txtshortcode,act:"saveunit", deid: deid
		$txtunit=$_POST['txtunit'];
		$txtshortcode=$_POST['txtshortcode'];
		$deid=$_POST['deid'];
		
		$rnm=recNum("select * from pro_dept_units where name='$txtunit' and deptid=$deid");
		if($rnm>0){
			
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into pro_dept_units(name,shtcode,deptid) values ('$txtunit','$txtshortcode',$deid)");
		
		if($res){
			
			$op="Created unit $txtunit";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	if($act=="editcompany"){
		
		//editcompany
		$cid=$_POST['cid'];
		$txtcontactaddress=$_POST['txtcontactaddress'];
		$txtcompany=$_POST['txtcompany'];
		$txtdomain=$_POST['txtdomain'];
		$txtmobile=$_POST['txtmobile'];
		$txtemail=$_POST['txtemail'];
		$txtcontactperson=$_POST['txtcontactperson'];
		$rnm=recNum("select * from dms_companies where name='$txtcompany'");
		
		
		$res=mysql_query("update dms_companies set name='$txtcompany',website='$txtdomain',mobile='$txtmobile',email='$txtemail',contact_person='$txtcontactperson',address='$txtcontactaddress' where id=$cid");
		
		if($res){
			$op="Edited Company $txtcompany";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
	}
	
	if($act=="editdept"){
		//txtdept: txtdept,txtshortcode: txtshortcode,act:"editdept", deid: deid
		$txtdept=$_POST['txtdept'];
		$txtshortcode=$_POST['txtshortcode'];
		$deid=$_POST['deid'];
		
		$res=mysql_query("update pro_departments set name='$txtdept',shtcode='$txtshortcode' where id=$deid");
		if($res){
			
				$op="Edited Department $txtdept";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	//txtunit: txtunit,txtshortcode: txtshortcode,act:"editunit", uid: dei
	
	if($act=="editunit"){
		//txtdept: txtdept,txtshortcode: txtshortcode,act:"editdept", deid: deid
		$txtunit=$_POST['txtunit'];
		$txtshortcode=$_POST['txtshortcode'];
		$deid=$_POST['uid'];
		
		$res=mysql_query("update pro_dept_units set name='$txtunit',shtcode='$txtshortcode' where id=$deid");
		if($res){
			
			$op="Edited Unit $txtunit";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	//txtsize:txtsize,txtfieldname: txtfieldname, act: 'savemetadatafield', cbodatatype: cbodatatype,schemaid:schemaid
	
	if($act=="savemetadatafield"){
		//txtdept: txtdept,txtshortcode: txtshortcode,act:"editdept", deid: deid
		$txtsize=$_POST['txtsize'];
		$txtfieldname=$_POST['txtfieldname'];
		$cbodatatype=$_POST['cbodatatype'];
		$schemaid=$_POST['schemaid'];
		$indexkey=$_POST['indexkey'];
		$curuser=@$_COOKIE['curuser'];
		
		$rnm=recNum("select * from pro_schema_fields where fieldname='$txtfieldname' and schemaid=$schemaid");
		if($rnm>0){
			
			echo "exists";exit;
		}
		
		$res=mysql_query("Insert into pro_schema_fields(fieldname,schemaid,datatype,datasize,indexkey,createdby) values('$txtfieldname',$schemaid,'$cbodatatype',$txtsize,'$indexkey','$curuser')");
		if($res){
			
			$op="Created datafield $txtfieldname";
		$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$loga=AudLog($userid,$op,0,0);
			
			echo "1";
		}
		else{
			echo "0";
		}
		
		
	}
	
	//act: 'getuserfullname', userid: userid
	if($act=="getuserfullname"){
		$userid=$_POST['userid'];
		echo returnQueryValue("select Fullname from pro_users where id=$userid","Fullname");
		
	}
	
	if($act=="loadcomment"){
		$fileid=$_POST['fileid'];
		$qry="select * from pro_file_discuss where fileid=$fileid order by id desc";
		$res=mysql_query($qry);
		$nm=mysql_num_rows($res);
		if($nm>0){
			$htm="";
			$rd=mysql_fetch_assoc($res);
			do{
				$comment=$rd['comment'];
				$userid=$rd['userid'];
				$htm=$htm."<div class='timeline-items'>";
				$htm=$htm."<div class='timeline-item clearfix'>";
				$htm=$htm."<div class='widget-box transparent'>";
				$htm=$htm."<div class='widget-header widget-header-small'>";
				$name=returnQueryValue("select Fullname from pro_users where id=$userid","Fullname");
				$htm=$htm."<h5 class='widget-title smaller'><a href='#' class='blue'>$name</a>";
				$htm=$htm."<span class='grey'>&nbsp;Wrote</span></h5><span class='widget-toolbar no-border'><i class='ace-icon fa fa-clock-o bigger-110'></i>";
				$htm=$htm.$rd['ddate'];
				$htm=$htm."</span><span class='widget-toolbar'><a href='#' data-action='reload'><i class='ace-icon fa fa-refresh'></i></a>";
				$htm=$htm."<a href='#' data-action='collapse'><i class='ace-icon fa fa-chevron-up'></i></a></span></div>";
				$htm=$htm."<div class='widget-body'><div class='widget-main'>".$comment."<div class='widget-toolbox clearfix'>";
				$htm=$htm."<div class='pull-right action-buttons'><a href='javascript:reply(\"$userid\");'><i class='ace-icon fa  fa-exchange red bigger-125'></i> Reply</a>";
				
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				$htm=$htm."</div>";
				
			}
			while($rd=mysql_fetch_assoc($res));
			echo $htm;
			
		}
		else{
			echo "Nothing for now. Please say something!";
		}
	}										
		
	
	if($act=="comment"){
		//act: 'comment', fileid: fileid, txtcomment: txtcomment
		$fileid=$_POST['fileid'];
		$txtcomment=safe_html($_POST['txtcomment']);
		$curuser=@$_COOKIE['curuser'];
		$commenter=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$nm=mysql_num_rows(mysql_query("select * from pro_file_discuss where fileid=$fileid and comment='$txtcomment' and userid=$commenter"));
		if($nm>0){
			echo "1";exit;
		}
		
		$res=mysql_query("insert into pro_file_discuss(fileid,comment,userid,ddate) values ($fileid,'$txtcomment',$commenter,'$dd')");
		if($res){
			
			echo "1";
		}
		else{
			echo "0";
		}
		
	}
	
	//mime_supported:mime_supported,smtp_password: smtp_password,smtp_username:smtp_username;smtp_port:smtp_port,
	//smtp_host:smtp_host,act: 'savesettings', baseurl: baseurl,logourl: logourl, 
	//docrecnolabel: docrecnolabel, dropoffurl: dropoffurl, appname:appname },
	
	if($act=="savesettings"){
		
		$mime_supported=$_POST['mime_supported'];
		$smtp_password=$_POST['smtp_password'];
		$smtp_username=$_POST['smtp_username'];
		$smtp_port=$_POST['smtp_port'];
		$smtp_host=$_POST['smtp_host'];
		$baseurl=$_POST['baseurl'];
		$logourl=$_POST['logourl'];
		$docrecnolabel=$_POST['docrecnolabel'];
		$dropoffurl=addslashes($_POST['dropoffurl']);
		$appname=$_POST['appname'];
		$max_document_size=$_POST['max_document_size'];
		
		$mime=saveParamValue("mime_supported",$mime_supported);
		$smtp_pass=saveParamValue("smtp_password",$smtp_password);
		$smtp_usern=saveParamValue("smtp_username",$smtp_username);
		$smtp_por=saveParamValue("smtp_port",$smtp_port);
		$smtp_h=saveParamValue("smtp_host",$smtp_host);
		
		$baseur=saveParamValue("baseurl",$baseurl);
		$logour=saveParamValue("logourl",$logourl);
		$docrecnolabe=saveParamValue("docrecnolabel",$docrecnolabel);
		$dropoffur=saveParamValue("dropoffurl",$dropoffurl);
		$appnam=saveParamValue("appname",$appname);
		
		$max_document_siz=saveParamValue("max_document_size",$max_document_size);
		
		echo "1";
		
		
		
	}
	//txttitle: txttitle, act: 'sendmail', txtbody: txtbody, fileid: fileid
	
	if($act=="sendmail"){
		//act: 'comment', fileid: fileid, txtcomment: txtcomment
		$txttitle=$_POST['txttitle'];
		$txtbody=safe_html($_POST['txtbody']);
		$fileid=$_POST['fileid'];
		$txtemail=$_POST['txtemail'];
		$smtp_username=getParamValue("smtp_username");
		include("filehandler.php");
		$rd=mysql_fetch_assoc(mysql_query("select * from pro_documents where id=$fileid"));
							$fname=$rd['name'];
							$realname=$rd['realname'];
							$ext=$rd['ext'];
							$docid=$rd['docno'];
							$usefilename="../vault/".$fname;
							//echo getFileSize($usefilename);exit;
							$filesize=formatBytes(getFileSize($usefilename));
							$fileMime=getFileMimeType($usefilename);
							$dateCreated=$rd['date_created'];
							$fileImage="img/".get_file_image($usefilename);
							
						echo sendFile($txtemail, $txttitle, $txtbody, $smtp_username,$usefilename,$fname);
							
		
		
	}
	
	
	
	if($act=="savetaskdept"){
		//act: 'comment', fileid: fileid, txtcomment: txtcomment
		$txttask=$_POST['txttask'];
		$txtdesc=safe_html($_POST['txtdesc']);
		$txtorder=$_POST['txtorder'];
		$deid=$_POST['deid'];
		$curuser=@$_COOKIE['curuser'];
		$commenter=returnQueryValue("select id from pro_users where usern='$curuser'","id");
		$nm=mysql_num_rows(mysql_query("select * from pro_workflow_def where taskname='$txttask' and deptid=$deid"));
		if($nm>0){
			echo "exists";exit;
		}
		
		$nm2=mysql_num_rows(mysql_query("select * from pro_workflow_def where task_order=$txtorder and deptid=$deid"));
		if($nm2>0){
			echo "exists";exit;
		}
		
		$res=mysql_query("insert into pro_workflow_def(taskname,task_description,task_order,deptid) values ('$txttask','$txtdesc',$txtorder,$deid)");
		if($res){
			
			echo "1";
		}
		else{
			echo "0";
		}
		
	}
	
	
	
	if($act=="loadunits"){
		//act: 'loadunits', cbodept: cbodept
		$cbodept=$_POST['cbodept'];
		//echo $cbodept;exit;
		if($cbodept==""){
			echo "";exit;
		}
		
		if($cbodept=="0"){
			echo "";exit;
		}
		$qry="select * from pro_dept_units where deptid=$cbodept and deleted='N'";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<br><br><table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Workspace</th><th>Short Description</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['name']."</td>";	
					$ret=$ret."<td>".$rd['shtcode']."</td>";
					
					$cid=$rd['id'];
					$stat=$rd['deleted'];
				
					$ret=$ret."<td><a href='editunit.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'>
					<i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a>&nbsp;&nbsp;
					<a href='deletecompany.php?id=$cid' class='tooltip-error' data-rel='tooltip' title='Delete'><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'>
					</span></a></li></td>";																	
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	if($act=="loadmetadata"){
		$cmcompany=$_POST['cmcompany'];
		
		$qry="select * from pro_schema where compid=$cmcompany";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Metadata Name</th><th>Description</th><th>Metadata Fields</th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['name']."</td>";	
					$ret=$ret."<td>".$rd['description']."</td>";
					
					$cid=$rd['id'];
					
					$ret=$ret."<td><a href='metadatafields.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Capture metadata fields'><span class='green'>
					<i class='ace-icon fa bigger-120'><img src='img/metadata.png' style='width:60xp;height:50px;'></i></span></a>&nbsp;&nbsp;
					
					</li></td>";																	
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	//act: 'loadmetadatafields', cmcompany: cmcompany
	
	if($act=="loadmetadatafields"){
		$mid=$_POST['mid'];
		
		$qry="select * from pro_schema_fields where schemaid=$mid";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Field Name</th><th>Data Type</th><th>Data Size</th><th>Index Field</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['fieldname']."</td>";	
					$datatype=$rd['datatype'];
					if($datatype=="varcharo"){
						$datatype="varchar";
					}
					
					if($datatype=="numbero"){
						$datatype="Number";
					}
					
					if($datatype=="dateo"){
						$datatype="Date";
					}
					
					$ret=$ret."<td>".$datatype."</td>";
					$ret=$ret."<td>".$rd['datasize']."</td>";
					$indexkey=$rd['indexkey'];
					
					if($indexkey=="Y"){
						$ret=$ret."<td>"."<center><img src='img/indexkey.png' style='width:30px;height:30px;'></center>"."</td>";
					}
					else{
						$ret=$ret."<td></td>";
					}
					
					
					$cid=$rd['id'];
					
					$ret=$ret."<td><a href='editmetadatafield.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'>
					<i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a>&nbsp;</li></td>";	
					
																						
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	if($act=="loadcompany"){
		//$cmunit=$_POST['cmunit'];
		$qry="select * from dms_companies";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Company</th><th>Domain</th><th>Contact person</th><th>Contact Mobile</th><th>Email</th><th>Address</th><th>Status</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['name']."</td>";	
					$ret=$ret."<td>".$rd['website']."</td>";
					$ret=$ret."<td>".$rd['contact_person']."</td>";
					$ret=$ret."<td>".$rd['mobile']."</td>";
					$ret=$ret."<td>".$rd['email']."</td>";
					$ret=$ret."<td>".$rd['address']."</td>";
					$cid=$rd['id'];
					$stat=$rd['status'];
					if($stat=="Y"){
						$ret=$ret."<td><span class='label label-sm label-success'>Active</span></td>";
					}else{
						
						$ret=$ret."<td><span class='label label-sm label-warning'>Inactive</span></td>";
					}
					$ret=$ret."<td><a href='editcompany.php?id=$cid' class='tooltip-success' data-rel='tooltip' title='Edit'><span class='green'>
					<i class='ace-icon fa fa-pencil-square-o bigger-120'></i></span></a>&nbsp;&nbsp;
					<a href='deletecompany.php?id=$cid' class='tooltip-error' data-rel='tooltip' title='Delete'><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'>
					</span></a></li></td>";																	
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
	}
	
	
	if($act=="loadtasktable"){
		//act: 'loadtasktable', cbodept: cbodept
		$cbodept=$_POST['cbodept'];
		$qry="select * from pro_workflow_def where deptid=$cbodept order by task_order asc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Task Name</th><th>Description</th><th>Order</th><th></th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['taskname']."</td>";	
					$ret=$ret."<td>".$rd['task_description']."</td>";
					$ret=$ret."<td>".$rd['task_order']."</td>";
					
					$cid=$rd['id'];
					
					$ret=$ret."<td>&nbsp;&nbsp;
					<a href='deletetask.php?id=$cid' class='tooltip-error' data-rel='tooltip' title='Delete'><span class='red'><i class='ace-icon fa fa-trash-o bigger-120'>
					</span></a></li></td>";																	
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
	}



?>