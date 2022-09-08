<?php 

	$act=$_POST['act'];
	include("func.php");
	$dd = date('Y-m-d H:i:s');
	$curuser=@$_COOKIE['curuser'];
	$compid=returnQueryValue("select compid  from pro_users where usern='$curuser'","compid");
	$unitid=returnQueryValue("select unitid from pro_users where usern='$curuser'","unitid");
	$deptid=returnQueryValue("select deptid from pro_users where usern='$curuser'","deptid");
	$usertype=returnQueryValue("select usertype from pro_users where usern='$curuser'","usertype");
	
	if($act=="loadmetadata"){
		//$cmunit=$_POST['cmunit'];
		$qry="SELECT * FROM pro_doc_schema_data where docid in (select docno from pro_documents where unit=$unitid) ORDER BY docid";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Document Number</th><th>Document Name</th><th>Data Field</th><th>Data Value</th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
						
					$ret=$ret."<td>".$rd['docid']."</td>";
					$docno=$rd['docid'];
				//	echo "select realname from pro_documents where docno='$docno'";
					$docname=returnQueryValue("select realname from pro_documents where docno='$docno'","realname");
					//echo $docname;
					$ret=$ret."<td>".$docname."</td>";
					$ret=$ret."<td>".$rd['dataname']."</td>";
					$ret=$ret."<td>".$rd['datavalue']."</td>";
					
					$cid=$rd['id'];
					
																				
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
	}
	
	if($act=="companyreport"){
		//$cmunit=$_POST['cmunit'];
		$qry="select * from dms_companies";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Company</th><th>Domain</th><th>Contact person</th><th>Contact Mobile</th><th>Email</th><th>Address</th><th>Status</th></tr></thead><tbody>";			
				
				
				
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
																				
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
	}
	
	
	if($act=="departmentsreport"){
		//act: 'loaddepttable', cmcompany: cmcompany
		//$cmcompany=$_POST['cmcompany'];
		
		
	if($usertype=="superadmin" || $usertype=="admin"){
		$qry="select * from pro_departments order by companyid asc";
	}
	else{
		$qry="select * from pro_departments where companyid=$compid order by companyid";
	}
		
	
		
		
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="<h4><b>Departments</b></h4>";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Company</th><th>Department</th><th>Short Code</th><th>Number of Workspace(s)</th></tr></thead><tbody>";			
				
				
				
				do{
					$cid=$rd['id'];
					$ret=$ret."<tr>";
					$companyid=$rd['companyid'];
						$compname=returnQueryValue("select name from dms_companies where id=$companyid","name");
					$ret=$ret."<td>".$compname."</td>";	
					$ret=$ret."<td>".$rd['name']."</td>";
					$ret=$ret."<td>".$rd['shtcode']."</td>";
					$wkspc=recNum("select * from pro_dept_units where deptid=$cid");
					$ret=$ret."<td>".$wkspc."</td>";
					
																	
						$ret=$ret."</tr>";															
																	
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
		
	}
	
	
	if($act=="unitsreport"){
		if($usertype=="superadmin" || $usertype=="admin"){
			$qry="select * from pro_dept_units order by deptid";
		}
		
		else{
			$qry="select * from pro_dept_units where deptid=$deptid";
		}
		
		
		
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Organization</th><th>Department</th><th>Workspace</th><th>Short Description</th><th>No. of Folder(s)</th><th>No. of Document(s)</th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
					$cid=$rd['id'];
					$deptx=$rd['deptid'];
					$compid=returnQueryValue("select companyid from pro_departments where id=$deptx","companyid");
					$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
					$deptname=returnQueryValue("select name from pro_departments where id=$deptx","name");
					$folderno=recNum("select * from pro_folder where unit=$cid");
					$docno=recNum("select * from pro_documents where unit=$cid");
					
					$ret=$ret."<td>".$compname."</td>";	
					$ret=$ret."<td>".$deptname."</td>";	
					$ret=$ret."<td>".$rd['name']."</td>";	
					$ret=$ret."<td>".$rd['shtcode']."</td>";
					$ret=$ret."<td>".$folderno."</td>";
					$ret=$ret."<td>".$docno."</td>";
					
					
																					
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	
	
	if($act=="folderreport"){
		if($usertype=="superadmin" || $usertype=="admin"){
			$qry="select * from pro_folder order by unit";
		}
		
		else{
			$qry="select * from pro_folder where unit=$unitid";
		}
		
		
		
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Organization</th><th>Department</th><th>Workspace</th><th>Folder</th><th>Public</th><th>No. of Document(s)</th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
					$cid=$rd['id'];
					$unitid=$rd['unit'];
					$deptx=returnQueryValue("select id from pro_dept_units where id=$unitid","id");
					$compid=returnQueryValue("select companyid from pro_departments where id=$deptx","companyid");
					$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
					$unitname=returnQueryValue("select name from pro_dept_units where id=$unitid","name");
					$deptname=returnQueryValue("select name from pro_departments where id=$deptx","name");
					$folderno=recNum("select * from pro_folder where unit=$cid");
					$docno=recNum("select * from pro_documents where folderid=$cid");
					
					$ret=$ret."<td>".$compname."</td>";	
					$ret=$ret."<td>".$deptname."</td>";	
					$ret=$ret."<td>".$unitname."</td>";
					$ret=$ret."<td>".$rd['name']."</td>";
					$ret=$ret."<td>".$rd['public']."</td>";
					$ret=$ret."<td>".$docno."</td>";
																			
						$ret=$ret."</tr>";															
						
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	
	if($act=="documentreport"){
		if($usertype=="superadmin" || $usertype=="admin"){
			$qry="select * from pro_documents order by folderid";
		}
		
		else{
			$qry="select * from pro_documents where unit=$unitid";
		}
		
		
		
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				$rd=mysql_fetch_assoc($res);
				
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Organization</th><th>Department</th><th>Workspace</th><th>Folder</th><th>Document Name</th><th>Document Type</th></tr></thead><tbody>";			
				
				
				
				do{
					$ret=$ret."<tr>";
					$cid=$rd['id'];
					$unitid=$rd['unit'];
					$deptx=returnQueryValue("select id from pro_dept_units where id=$unitid","id");
					$compid=returnQueryValue("select companyid from pro_departments where id=$deptx","companyid");
					$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
					$unitname=returnQueryValue("select name from pro_dept_units where id=$unitid","name");
					$deptname=returnQueryValue("select name from pro_departments where id=$deptx","name");
					$folderid=$rd['folderid'];
					$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
					$folderno=recNum("select * from pro_folder where unit=$cid");
					$docno=recNum("select * from pro_documents where folderid=$cid");
					
					
					$ret=$ret."<td>".$compname."</td>";	
					$ret=$ret."<td>".$deptname."</td>";	
					$ret=$ret."<td>".$unitname."</td>";
					$ret=$ret."<td>".$foldername."</td>";
					$ret=$ret."<td>".$rd['realname']."</td>";
					$ret=$ret."<td>".$rd['mimetype']."</td>";
					
					
					
																					
																				
						$ret=$ret."</tr>";															
																				
																			
																		
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;
			}
		
	}
	
	
	if($act=="usersreport"){
		//act: 'loaddepttable', cmcompany: cmcompany
		//$cmcompany=$_POST['cmcompany'];
		
		
	if($usertype=="superadmin" || $usertype=="admin"){
		$qry="select * from pro_users order by compid asc";
	}
	else{
		$qry="select * from pro_users where compid=$compid order by compid";
	}
		
	
		
		
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$fldpack="";
				$ret="";
				$rd=mysql_fetch_assoc($res);
				$ret="<table id='dynamic-table' class='table table-striped table-bordered table-hover'>";
				$ret=$ret."<thead><tr><th>Organization</th><th>Department</th><th>Workspace</th><th>Username</th><th>Fullname</th><th>Email</th><th>Folders Created</th><th>Documents Created</th><th>Active</th></tr></thead><tbody>";			
				
				
				
				do{
					$cid=$rd['id'];
					$ret=$ret."<tr>";
					$deptx=$rd['deptid'];
					$unitx=$rd['unitid'];
					$compid=returnQueryValue("select companyid from pro_departments where id=$deptx","companyid");
					$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
					$unitname=returnQueryValue("select name from pro_dept_units where id=$unitx","name");
					$deptname=returnQueryValue("select name from pro_departments where id=$deptx","name");
					
					$ret=$ret."<td>".$compname."</td>";	
					$ret=$ret."<td>".$deptname."</td>";
					$ret=$ret."<td>".$unitname."</td>";
					$ret=$ret."<td>".$rd['usern']."</td>";
					$ret=$ret."<td>".$rd['Fullname']."</td>";
					$ret=$ret."<td>".$rd['email']."</td>";
					$usr=$rd['usern'];
					$folderno=recNum("select * from pro_folder where createdby='$usr'");
					$ret=$ret."<td>".$folderno."</td>";
					$filesno=recNum("select * from pro_documents where userid=$cid");
					$ret=$ret."<td>".$filesno."</td>";
					$ret=$ret."<td>".$rd['active']."</td>";
					
																	
						$ret=$ret."</tr>";															
																	
                       
				}
				
				while($rd=mysql_fetch_assoc($res));	

				$ret=$ret."</tbody></table>";					
				echo $ret;	
				
			}
		
	}
	
	

?>