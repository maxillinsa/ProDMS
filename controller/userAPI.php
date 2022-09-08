<?php 


	$act=$_POST['act'];
	include("func.php");
	$dd = date('Y-m-d');
	if($act=="register"){
		//act: 'register', txtregstaffid:txtregstaffid,txtregemail:txtregemail,txtfirstname:txtfirstname,txtsurname:txtsurname,
	//txtregamount:txtregamount,txtstartmonth:txtstartmonth,txtyear:txtyear,txtduration:txtduration,txtregpass:txtregpass,txtregphone:txtregphone
		$txtregstaffid=$_POST['txtregstaffid'];
		$txtregemail=$_POST['txtregemail'];
		$txtfirstname=$_POST['txtfirstname'];
		$txtsurname=$_POST['txtsurname'];
		$txtregamount=$_POST['txtregamount'];
		$txtstartmonth=$_POST['txtstartmonth'];
		$txtyear=$_POST['txtyear'];
		$txtduration=$_POST['txtduration'];
		$txtregpass=$_POST['txtregpass'];
		$txtregphone=$_POST['txtregphone'];
		$txtregpass=sha1($txtregpass);
		$cbopoption=$_POST['cbopoption'];
		
		if($cbopoption=="OTHERS"){
			$lastrecordid=returnQueryValue("select max(id)ido from tblmembers ","ido");
			$didstaff=(int)$lastrecordid+1;
			$txtregstaffid="FVX/".$didstaff;
		}
		
		$recnum=recNum("select * from tblmembers where staffid='$txtregstaffid'");
		if($recnum>0){
			
			echo "xxx";
			exit;
		}
		
		
		$qry="Insert into tblmembers(staffid,firstname,surname,email,dedamount,dedmonth,dedyear,planduration,pword,telephone,ddate,payrollsource)
		values ('$txtregstaffid','$txtfirstname','$txtsurname','$txtregemail',$txtregamount,$txtstartmonth,$txtyear,$txtduration,'$txtregpass','$txtregphone','$dd','$cbopoption')";
	//	echo $qry;exit;
		$res=mysql_query($qry);
		
		$qryx="insert into tbadmin (memid,department,usern,pword,usertype) values(0,'','$txtregstaffid','$txtregpass','O')" ;
		$resx=mysql_query($qryx);
		
		$qry2=mysql_query("insert into tbltasks(task,staffid) values('Start Deduction','$txtregstaffid')");
		//select usern from tbadmin where department='HR'
		$adminuseremail=returnQueryValue("select email from tbadmin where department='HR' and company='$cbopoption'","email");
		
		if(!empty($adminuseremail)){
			$subject="FBNInvex New member Registration";
		$msg="<p>Dear HR,</p><p>$txtfirstname $txtsurname has applied to join FBNI Staff Savings Scheme</p><p>Effect Payroll deduction and approve on FBNInvex</p>
		<a href='fbnlife-sv10/FBNInvex'>Click here to approve transaction</a>";
				$from="noreply@fbninsurance.com";
				//$mail=sendmail($adminuseremail, $subject, $msg, $from)
				
				$subject="Welcome to FBNInvex scheme";
				$msg="<p>Dear $txtfirstname $txtsurname,<br> Welcome FBNI Staff Savings Scheme</p><p>Wait while HR Effect Payroll deduction and approve your request</p>
		<a href='fbnlife-sv10/FBNInvex'>Click here to login to your account</a>";
				//sendmail
				
				//$mail=sendmail($txtregemail, $subject, $msg, $from)
		}
		

		echo "1";
	}
	
	if($act=="login"){
		
		//txtuser:txtuser, txtpword:txtpword
		
		$txtuser=trim($_POST['txtuser']);
		$txtpword=$_POST['txtpword'];
		$txtpword=sha1($txtpword);
	//	echo "select * from tbadmin where usern='$txtuser' and pword='$txtpword'";exit;
		$recnum=recNum("select * from pro_users where usern='$txtuser' and pword='$txtpword'");
		//echo $recnum;exit;
		if($recnum>0){
			$status=returnQueryValue("select active from pro_users where usern='$txtuser' and pword='$txtpword'","active");
			if($status=="N"){
				echo "xx1";exit;
			}
			else{
			$sk=setcookie("curuser", $txtuser, time() + (86400 * 30), "/");
			
			echo "1";
			}
			
		}else{
			echo "xxx";
		}
		
		
		
	}
	
	if($act=="editpassword"){
		
		$txtoldpass=$_POST['txtoldpass'];
		
		
		$txtoldpass=$_POST['txtoldpass'];
		$txtnewpass=$_POST['txtpass'];
		$txtoldpass=sha1($txtoldpass);
		$txtnewpass=sha1($txtnewpass);
		$curuser=@$_COOKIE['curuser'];
		$recnum=recNum("select * from pro_users where usern='$curuser' and pword='$txtoldpass'");
		if($recnum<1){
			echo "notexist";
			exit;
		}
		$res=mysql_query("update pro_users set pword='$txtnewpass' where usern='$curuser'");
		echo "1";
		
	}
	
	
	 //$.post("controller/utility.php", { act: 'editpassword', txtoldpass: txtoldpass,txtpass: txtpass },
	
	if($act=="logout"){
		unset($_COOKIE['curuser']);
    setcookie('curuser', '', time() - 3600, '/'); // empty value and old timestamp
	echo "1";
	}
	
	if($act=="addportaladmin"){
		//act: 'addportaladmin', txtusername: txtusername, txtpass: txtpass,txtsection: txtsection, txtmember: txtmember
		$txtusername=$_POST['txtusername'];
		$txtpass=$_POST['txtpass'];
		$txtemail=$_POST['txtemail'];
		$txtpass=sha1($txtpass);
		$txtsection=$_POST['txtsection'];
		$txtmember=$_POST['txtmember'];
		$cbopoption=$_POST['cbopoption'];
		$recnum=recNum("select * from tbadmin where usern='$txtusername'");
		if($recnum>0){
			echo "xxx";exit;
		}
		if($txtmember==""){}else{
			$recnummem=recNum("select * from tbadmin where memid=$txtmember");
			if($recnummem>0){
				echo "xxx";exit;
			}
			
		}
		if($txtmember==""){
			$txtmember="0";
		}
		$qry="insert into tbadmin (memid,department,usern,pword,usertype,email,company) values($txtmember,'$txtsection','$txtusername','$txtpass','A','$txtemail','$cbopoption')" ;
		//echo $qry;exit;
		$res=mysql_query($qry);
		echo "1";
		
		
		
	}
	
	//act: 'changepass', txtoldpass: txtoldpass, txtnewpass: txtnewpass
	
	if($act=="changepass"){
		$txtoldpass=$_POST['txtoldpass'];
		$txtnewpass=$_POST['txtnewpass'];
		$txtoldpass=sha1($txtoldpass);
		$txtnewpass=sha1($txtnewpass);
		$curuser=@$_COOKIE['curuser'];
		$recnum=recNum("select * from tbadmin where usern='$curuser' and pword='$txtoldpass'");
		if($recnum<1){
			echo "notexist";
			exit;
		}
		$res=mysql_query("update tbadmin set pword='$txtnewpass',passreset='Y' where usern='$curuser'");
		echo "1";
		
	}
	
	if($act=="sendpassword"){
	$txtemail=$_POST['txtemail'];
	
	}
	
	// 'sendpassword',txtemail:txtemail
	
	if($act=="loadadminaccount"){
		$qry="select * from tbadmin WHERE department<>'' order by id desc";
		//echo $qry;
		$res=mysql_query($qry);
		//var_dump($res);
		$num=mysql_num_rows($res);
		
		$ret="";
		$rd=mysql_fetch_assoc($res);
		//var_dump($rd);
		//echo $num;
		if($num>0){
			
			$ret.="<table class='table table-bordered table-striped'>";
				$ret.="<thead class='thin-border-bottom'>";
				$ret.="<thead class='thin-border-bottom'><tr>";
				$ret.="<th>Username</th>";
				$ret.="<th>Passowrd</th>";
				$ret.="<th>Function</th>";
				$ret.="<th>Investment Member Account</th>";
				
				
				$ret.="<th>Action</th></tr></thead><tbody>";
				
			do{
				//$sid=$rd['staffid'];
				$sidnom=$rd['id'];
				//$curTask=returnQueryValue("select * from tbltasks where staffid='$sid' and status='A'","task");
				$ret.="<tr>";
				$ret.="<td>".$rd['usern']."</td>";
				$ret.="<td>*********</td>";
				$ret.="<td>".$rd['department']."</td>";
				$memid=$rd['memid'];
				$memname="";
				if((int)$memid>0){
					$rdmem=mysql_fetch_array(mysql_query("select * from tblmembers where id=$memid"));
					$memname=$rdmem['firstname']." ".$rdmem['surname'];
				}
				$ret.="<td>".$memname."</td>";
				//$ret.="<td>".$rd['telephone']."</td>";
				
				$isadmin=recNum("select * from tbadmin where memid=$sidnom");
				$ret.="<td><a href='javascript:approve(\"$sidnom\");' class='blue'><span class='label label-danger arrowed'><b>Edit</b></span></a></td>";
			//	if($isadmin>0){
				//	$ret.="<td>Admin <a href='javascript:approve(\"$sidnom\");' class='blue'><span class='label label-danger arrowed'><b>Downgrade</b></span></a></td>";
				//}else{
			//		$ret.="<td>User <a href='javascript:approve(\"$sidnom\");' class='blue'><span class='label label-success arrowed'><b>Make Admin</b></span></a></td>";
			//	}
				
						$ret.="</tr>";
															
				
			}
			while($rd=mysql_fetch_assoc($res));
			$ret.="</tbody>";
			$ret.="</table>";
			echo $ret;
		}
		else{
			
			echo "No record yet";
		}
	}



?>