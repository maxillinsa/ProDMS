<?php 


	$act=$_POST['act'];
	include("func.php");
	$dd = date('Y-m-d');
	$intrate=returnQueryValue("select rate from tblintrate where '$dd' between datefrom and dateto","rate");
	if($act=="viewschedule"){
		$curuser=@$_COOKIE['curuser'];
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		$ret.="</th><th>Opening Balance</th><th>Withdrawal</th><th>Interest on Opening Balance</th><th>Contribution</th><th>";
		
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Interest on Contribution";
		$ret.="</th>";
		$ret.="<th class='hidden-480'>Closing Balance</th>";
		$ret.="<th class='hidden-480'>Comment</th>";
		$ret.="<th>Date</th>";
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		
		$curinvest=mysql_fetch_assoc(mysql_query("select * from tblcontributions where staffid='$curuser' and status='A'"));
		$contribid=$curinvest['id'];
		if($contribid==""){
			echo "You have no active investment";exit;
		}
		$qry="select * from tblallocation where staffid='$curuser' order by id asc";	
		//echo $qry;exit;
			$res=mysql_query($qry);
			$num=mysql_num_rows($res);
			if($num<1){
				echo "Investment allocation not done";exit;
			}
			$rd=mysql_fetch_assoc($res);
			do{
				$ret.="<tr>";
				
				$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".number_format($rd['openbalance'],2)."</td>";
				$ret.="<td>".number_format($rd['withdrawalamount'],2)."</td>";
				$ret.="<td>".number_format($rd['intopenbalance'],2)."</td>";
				$ret.="<td>".number_format($rd['contrib'],2)."</td>";
				$ret.="<td>".number_format($rd['intcontrib'],2)."</td>";
				$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				$ret.="<td>".number_format($clsBal,2)."</td>";
				$ret.="<td>".$rd['comment']."</td>";
				$ret.="<td>".$rd['investdate']."</td>";
				$ret.="</tr>";
			}
			while($rd=mysql_fetch_assoc($res));
				$ret.="</tbody></table>";							
												
				echo $ret;											
														
	}
	
	if($act=="viewstatementofaccountself"){
		$curuser=@$_COOKIE['curuser'];
		$staffid=$curuser;
		//echo $staffid;
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		$ret.="</th><th>Opening Balance</th><th>Interest on Opening Balance</th><th>Contribution</th><th>";
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Interest on Contribution";
		$ret.="</th>";
		$ret.="<th class='hidden-480'>Closing Balance</th>";
		
		$ret.="<th>Date</th>";
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		$qry="select distinct staffid from tblcontributions where payrollsource<>'OTHERS' and staffid='$staffid'";
	$res=mysql_query($qry);
$num=mysql_num_rows($res);

if($num>0){
	$rd=mysql_fetch_assoc($res);
	do{
		$staffid=$rd['staffid'];
		//$contribid=$staffid=$rd['contribid'];
		//echo $staffid."-".$contribid.
		
		$min_month=returnQueryValue("select min(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_month=returnQueryValue("select max(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$min_year=returnQueryValue("select min(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_year=returnQueryValue("select max(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		if(!empty($min_month)){
			$i=0;
		//	echo $staffid." min_month=".$min_month." max_month=".$max_month." min_year=".$min_year." max_year=".$max_year."<br>";
		$ClosingBalance=0;
			for ($xy = $min_year; $xy <= $max_year; $xy++) {
				for ($xm = $min_month; $xm <= $max_month; $xm++) {
					
						$rnm=mysql_num_rows(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy"));
					if($rnm>0){
						$i+=1;
						
					$rdo=mysql_fetch_assoc(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id ASC LIMIT 1"));
					//$openingBalance= $rdo['openbalance'];
					$openingBalance=$ClosingBalance;
					$contribamt=returnQueryValue("select sum(contrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					//$intcontribute=returnQueryValue("select sum(intcontrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
				//	echo $intcontribute;
				//getLastDayOfAMonth
				
				$ndate=sprintf("%02d", $xy)."-".sprintf("%02d", $xm)."-"."20";
				$lastday=getLastDayOfAMonth($ndate);
				$ddifa=$lastday+1-20;
				$intcontribute=$contribamt * $intrate/100 * $ddifa/365;
				echo$ddifa."<br>";
					$fid=$rdo['id'];
					$withamnt1=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$fid","withamnt");
					if($withamnt1==""){
						$withamnt1="0";
					}
					
					$rdo2=mysql_fetch_assoc(mysql_query("select (openbalance+intopenbalance)closingbalance,investdate,intopenbalance,contrib,id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id desc LIMIT 1"));
					
					$contribamt2=$rdo2['contrib'];
					$intopenbalance=$openingBalance * $intrate/100 * $ddifa/365;
					if((int)$openingBalance<1){
						$intopenbalance=0;
					}
					
					$sid=$rdo2['id'];
					$investdate=$rdo2['investdate'];
					$withexist2=returnQueryValue("select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like '%Withdrawal%'","id");
					//echo "select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like %Withdrawal%<br>";
					$fwithdrawal=0;
					if(!empty($withexist2)){
							$withamnt2=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$withexist2","withamnt");
						//echo $withexist2;
						if($withamnt2==""){
							$withamnt2="0";
						}
						$fwithdrawal=(int)$withamnt1+(int)$withamnt2;
					}
				
					$ret.="<tr>";
					//$max_id=returnQueryValue("select max(id)mnt from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","mnt");
					//$baldate=returnQueryValue("select investdate from tblallocation where staffid='$staffid' and id=$max_id and mnt=$xm and tyear=$xy","investdate");
				
				$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".number_format($openingBalance ,2)."</td>";
				$ret.="<td>".number_format($intopenbalance,2)."</td>";
				$ret.="<td>".number_format($contribamt,2)."</td>";
				if($i==1){
					//$tit=$ClosingBalance-$contribamt;
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}
				else{
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}
				//$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				$ClosingBalance= $openingBalance+$intopenbalance+$contribamt+$intcontribute;
				$ret.="<td>".number_format($ClosingBalance,2)."</td>";
				$ret.="<td>".$investdate."</td>";
				//$ret.="<td>".$rd['investdate']."</td>";
				$ret.="</tr>";
					
					//echo "$staffid Month:$xm - Opening balance $openingBalance - Contibution amt- $contribamt ClosingBalance: $ClosingBalance Withdrawal: $fwithdrawal <br>";
					//echo "$staffid Month:$xm - Closing balance $ClosingBalance - Contibution amt- $contribamt2 <br>";
				} 
				}
			} 
		}
		
		
	}
	while($rd=mysql_fetch_assoc($res));
	echo $ret;
}
else{
	
	echo "No data";
		
		
	}
		
	}
	
	
	if($act=="viewstatementofaccountself2"){
		$curuser=$_POST['staffid'];
		$staffid=$curuser;
		//echo $staffid;
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		
		$ret.="<th style='color:black;'>Opening Balance</th><th style='color:black;'>Interest on Opening Balance</th><th style='color:black;'>Contribution</th><th style='color:black;'>";
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Interest on Contribution";
		$ret.="</th>";
		$ret.="<th style='color:black;'>Closing Balance</th>";
		
		$ret.="<th style='color:black;'>Date</th>";
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		$qry="select distinct staffid from tblcontributions where payrollsource<>'OTHERS' and staffid='$staffid'";
	$res=mysql_query($qry);
$num=mysql_num_rows($res);

if($num>0){
	$rd=mysql_fetch_assoc($res);
	do{
		$staffid=$rd['staffid'];
		//$contribid=$staffid=$rd['contribid'];
		//echo $staffid."-".$contribid.
		
		$min_month=returnQueryValue("select min(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_month=returnQueryValue("select max(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$min_year=returnQueryValue("select min(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_year=returnQueryValue("select max(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		if(!empty($min_month)){
			$i=0;
		//	echo $staffid." min_month=".$min_month." max_month=".$max_month." min_year=".$min_year." max_year=".$max_year."<br>";
			for ($xy = $min_year; $xy <= $max_year; $xy++) {
				for ($xm = $min_month; $xm <= $max_month; $xm++) {
					$i+=1;
					
					$rdo=mysql_fetch_assoc(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id ASC LIMIT 1"));
					$openingBalance= $rdo['openbalance'];
					$contribamt=$rdo['contrib']; 
					$intcontribute=returnQueryValue("select sum(intcontrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
				//	echo $intcontribute;
					$fid=$rdo['id'];
					$withamnt1=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$fid","withamnt");
					if($withamnt1==""){
						$withamnt1="0";
					}
					
					$rdo2=mysql_fetch_assoc(mysql_query("select (openbalance+intopenbalance)closingbalance,investdate,intopenbalance,contrib,id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id desc LIMIT 1"));
					$ClosingBalance= $rdo2['closingbalance'];
					$contribamt2=$rdo2['contrib'];
					$intopenbalance=returnQueryValue("select sum(intopenbalance)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if((int)$openingBalance<1){
						$intopenbalance=0;
					}
					
					$sid=$rdo2['id'];
					$investdate=$rdo2['investdate'];
					$withexist2=returnQueryValue("select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like '%Withdrawal%'","id");
					//echo "select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like %Withdrawal%<br>";
					$fwithdrawal=0;
					if(!empty($withexist2)){
							$withamnt2=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$withexist2","withamnt");
						//echo $withexist2;
						if($withamnt2==""){
							$withamnt2="0";
						}
						$fwithdrawal=(int)$withamnt1+(int)$withamnt2;
					}
				
					$ret.="<tr>";
					//$max_id=returnQueryValue("select max(id)mnt from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","mnt");
					//$baldate=returnQueryValue("select investdate from tblallocation where staffid='$staffid' and id=$max_id and mnt=$xm and tyear=$xy","investdate");
				
			//	$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".number_format($openingBalance ,2)."</td>";
				$ret.="<td>".number_format($intopenbalance,2)."</td>";
				$ret.="<td>".number_format($contribamt,2)."</td>";
				if($i==1){
					$tit=$ClosingBalance-$contribamt;
					$ret.="<td>".number_format($tit,2)."</td>";
				}
				else{
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}
				//$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				$ret.="<td>".number_format($ClosingBalance,2)."</td>";
				$ret.="<td>".$investdate."</td>";
				//$ret.="<td>".$rd['investdate']."</td>";
				$ret.="</tr>";
					
					//echo "$staffid Month:$xm - Opening balance $openingBalance - Contibution amt- $contribamt ClosingBalance: $ClosingBalance Withdrawal: $fwithdrawal <br>";
					//echo "$staffid Month:$xm - Closing balance $ClosingBalance - Contibution amt- $contribamt2 <br>";
				} 
			} 
		}
		
		
	}
	while($rd=mysql_fetch_assoc($res));
	echo $ret;
}
else{
	
	echo "No data";
		
		
	}
		
	}
	
	if($act=="viewstatementofaccount"){
		$staffid=$_POST['txtstaffid'];
		//echo $staffid;
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		$ret.="</th><th>Opening Balance</th><th>Interest on Opening Balance</th><th>Contribution</th><th>";
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Interest on Contribution";
		$ret.="</th>";
		$ret.="<th class='hidden-480'>Closing Balance</th>";
		
		$ret.="<th>Date</th>";
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		$qry="select distinct staffid from tblcontributions where payrollsource<>'OTHERS' and staffid='$staffid'";
	$res=mysql_query($qry);
$num=mysql_num_rows($res);

if($num>0){
	$rd=mysql_fetch_assoc($res);
	do{
		$staffid=$rd['staffid'];
		//$contribid=$staffid=$rd['contribid'];
		//echo $staffid."-".$contribid.
		
		$min_month=returnQueryValue("select min(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_month=returnQueryValue("select max(mnt)mnt from tblallocation where staffid='$staffid'","mnt");
		$min_year=returnQueryValue("select min(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		$max_year=returnQueryValue("select max(tyear)mnt from tblallocation where staffid='$staffid'","mnt");
		if(!empty($min_month)){
			$i=0;
		//	echo $staffid." min_month=".$min_month." max_month=".$max_month." min_year=".$min_year." max_year=".$max_year."<br>";
			for ($xy = $min_year; $xy <= $max_year; $xy++) {
				for ($xm = $min_month; $xm <= $max_month; $xm++) {
					$i+=1;
					//echo "select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy";
					$rnm=mysql_num_rows(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy"));
					if($rnm>0){
					$rdo=mysql_fetch_assoc(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id ASC LIMIT 1"));
					$openingBalance= $rdo['openbalance'];
					$contribamt=$rdo['contrib']; 
					$intcontribute=returnQueryValue("select sum(intcontrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
				//	echo $intcontribute;
					$fid=$rdo['id'];
					$withamnt1=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$fid","withamnt");
					if($withamnt1==""){
						$withamnt1="0";
					}
					
					$rdo2=mysql_fetch_assoc(mysql_query("select (openbalance+intopenbalance)closingbalance,investdate,intopenbalance,contrib,id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id desc LIMIT 1"));
					$ClosingBalance= $rdo2['closingbalance'];
					$contribamt2=$rdo2['contrib'];
					$intopenbalance=returnQueryValue("select sum(intopenbalance)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if((int)$openingBalance<1){
						$intopenbalance=0;
					}
					//$trint=(int)$ClosingBalance-(int)$openingBalance
					$sid=$rdo2['id'];
					$investdate=$rdo2['investdate'];
					$withexist2=returnQueryValue("select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like '%Withdrawal%'","id");
					//echo "select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like %Withdrawal%<br>";
					$fwithdrawal=0;
					if(!empty($withexist2)){
							$withamnt2=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$withexist2","withamnt");
						//echo $withexist2;
						if($withamnt2==""){
							$withamnt2="0";
						}
						$fwithdrawal=(int)$withamnt1+(int)$withamnt2;
					}
				
					$ret.="<tr>";
					//$max_id=returnQueryValue("select max(id)mnt from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","mnt");
					//$baldate=returnQueryValue("select investdate from tblallocation where staffid='$staffid' and id=$max_id and mnt=$xm and tyear=$xy","investdate");
				
				$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".number_format($openingBalance ,2)."</td>";
				$ret.="<td>".number_format($intopenbalance,2)."</td>";
				
				
				$ret.="<td>".number_format($contribamt,2)."</td>";
				
				if($i==1){
					$tit=$ClosingBalance-$contribamt;
					$ret.="<td>".number_format($tit,2)."</td>";
				}
				else{
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}
				//$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				$ret.="<td>".number_format($ClosingBalance,2)."</td>";
				$ret.="<td>".$investdate."</td>";
				//$ret.="<td>".$rd['investdate']."</td>";
				$ret.="</tr>";
					}
					//echo "$staffid Month:$xm - Opening balance $openingBalance - Contibution amt- $contribamt ClosingBalance: $ClosingBalance Withdrawal: $fwithdrawal <br>";
					//echo "$staffid Month:$xm - Closing balance $ClosingBalance - Contibution amt- $contribamt2 <br>";
				} 
			} 
		}
		
		
	}
	while($rd=mysql_fetch_assoc($res));
	echo $ret;
}
else{
	
	echo "No data";
		
		
	}
	}
	
	if($act=="actuarialsummaryreport"){
		
		
		$txtstartmonth=$_POST['txtstartmonth'];
		$txtyear=$_POST['txtyear'];
		$mntname=getMonthNameFromNum($txtstartmonth);
		//echo $staffid;
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		//$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		//$ret.="</th><th>Staff Number</th><th>Name</th><th>Remarks</th><th>Opening Balance</th><th>Interest on Opening Balance</th><th>Contribution</th><th>";
		//$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		//$ret.="Interest on Contribution";
		//$ret.="</th>";
		//$ret.="<th>Partial/Full Withdrawal</th>";
		//$ret.="<th>Closing Balance @ $mntname $txtyear</th>";
		
	//	$ret.="<th>Date</th>";
	
		//$ret.="</tr></thead>";	
		$ret.="<tbody>";
		$qry="select distinct staffid from tblcontributions where payrollsource<>'OTHERS'";
	$res=mysql_query($qry);
$num=mysql_num_rows($res);
$openingBalance_2=0;
		$intopenbalance_2=0;
		$contribamt_2=0;
		$intcontribute_2=0;
		$withamnt1_2=0;
		$ClosingBalance_2=0;
if($num>0){
	$rd=mysql_fetch_assoc($res);
	do{
		$staffid=$rd['staffid'];
		//$contribid=$staffid=$rd['contribid'];
		//echo $staffid."-".$contribid.
		$staffname=returnQueryValue("SELECT CONCAT(surname,' ',firstname)namer FROM tblmembers where staffid='$staffid'","namer");
		$remark=returnQueryValue("select payrollsource from tblmembers where staffid='$staffid'","payrollsource");
		$min_month=returnQueryValue("select min(mnt)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$max_month=returnQueryValue("select max(mnt)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$min_year=returnQueryValue("select min(tyear)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$max_year=returnQueryValue("select max(tyear)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		
		if(!empty($min_month)){
			$i=0;
		//	echo $staffid." min_month=".$min_month." max_month=".$max_month." min_year=".$min_year." max_year=".$max_year."<br>";
			for ($xy = $min_year; $xy <= $max_year; $xy++) {
				for ($xm = $min_month; $xm <= $max_month; $xm++) {
					$i+=1;
					$rdo=mysql_fetch_assoc(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id ASC LIMIT 1"));
					$openingBalance= $rdo['openbalance'];
					$contribamt=$rdo['contrib']; 
					$intcontribute=returnQueryValue("select sum(intcontrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
				//	echo $intcontribute;
					$fid=$rdo['id'];
					$withamnt1=returnQueryValue("select sum(withdrawalamount)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if($withamnt1==""){
						$withamnt1="0";
					}
					
					$rdo2=mysql_fetch_assoc(mysql_query("select (openbalance+intopenbalance)closingbalance,investdate,intopenbalance,contrib,id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id desc LIMIT 1"));
					$ClosingBalance= $rdo2['closingbalance'];
					$contribamt2=$rdo2['contrib'];
					$intopenbalance=returnQueryValue("select sum(intopenbalance)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if((int)$openingBalance<1){
						$intopenbalance=0;
					}
					//$trint=(int)$ClosingBalance-(int)$openingBalance
					$sid=$rdo2['id'];
					$investdate=$rdo2['investdate'];
					$withexist2=returnQueryValue("select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like '%Withdrawal%'","id");
					//echo "select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like %Withdrawal%<br>";
					$fwithdrawal=0;
					if(!empty($withexist2)){
							$withamnt2=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$withexist2 and approved='Y'","withamnt");
						//echo $withexist2;
						if($withamnt2==""){
							$withamnt2="0";
						}
						$fwithdrawal=(int)$withamnt1+(int)$withamnt2;
					}
				
					//$ret.="<tr>";
					//$max_id=returnQueryValue("select max(id)mnt from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","mnt");
					//$baldate=returnQueryValue("select investdate from tblallocation where staffid='$staffid' and id=$max_id and mnt=$xm and tyear=$xy","investdate");
				
				//$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
			//	$ret.="<td>".$staffid."</td>";
				//$ret.="<td>".$staffname."</td>";
			//	$ret.="<td>".$remark."</td>";
				
				
				$openingBalance_2=$openingBalance_2+$openingBalance;
				//$ret.="<td>".number_format($openingBalance ,2)."</td>";
				//$ret.="<td>".number_format($intopenbalance,2)."</td>";
				$intopenbalance_2=$intopenbalance_2+$intopenbalance;
				$contribamt_2=$contribamt_2+$contribamt;
				//$ret.="<td>".number_format($contribamt,2)."</td>";
				if((int)$contribamt>0){
					$ddx=$xy."-".$xm."-20";
					$lastday =date("t", strtotime($ddx));
					$nminvdays=(int)$lastday -20;
					$intxn=$contribamt * $intrate/100 * $nminvdays/365;
					$intcontribute_2=$intcontribute_2+$intxn;
					//$ret.="<td>".number_format($intcontribute,2)."</td>";
				}else{
					//$ret.="<td>".number_format($intcontribute,2)."</td>";
					$intcontribute_2=$intcontribute_2+$intcontribute;
				}
				
				//$ret.="<td>".number_format($withamnt1,2)."</td>";
				$withamnt1_2=$withamnt1_2+$withamnt1;
				//$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				//$ret.="<td>".number_format($ClosingBalance,2)."</td>";
				$ClosingBalance_2=$ClosingBalance_2+$ClosingBalance;
			///	$ret.="<td>".$investdate."</td>";
				//$ret.="<td>".$rd['investdate']."</td>";
			//	$ret.="</tr>";
					
					//echo "$staffid Month:$xm - Opening balance $openingBalance - Contibution amt- $contribamt ClosingBalance: $ClosingBalance Withdrawal: $fwithdrawal <br>";
					//echo "$staffid Month:$xm - Closing balance $ClosingBalance - Contibution amt- $contribamt2 <br>";
				} 
			} 
		}
		
		
	}
	while($rd=mysql_fetch_assoc($res));
		//$txtstartmonth=$_POST['txtstartmonth'];
		//$txtyear=$_POST['txtyear'];
	$ddx="01/".$txtstartmonth."/".$txtyear;
					//$lastday =date("t", strtotime($ddx));
					//$nminvdays=(int)$lastday -20;
			$ret.="<tr>";
			$ret.="<td><b>Opening ".$ddx."</b></td><td>".number_format($openingBalance_2,2)."</td>";				
				$ret.="</tr>";	
				
				$ret.="<tr>";
			$ret.="<td><b>Exit</b></td><td>".number_format($withamnt1_2,2)."</td>";				
				$ret.="</tr>";
				
				$ret.="<tr>";
			$ret.="<td><b>New Contribution</b></td><td> ".number_format($contribamt_2,2)."</td>";				
				$ret.="</tr>";
				
				$intesiti=$intcontribute_2+$intopenbalance_2;
				
					$ret.="<tr>";
			$ret.="<td><b>Interest</b></td><td> ".number_format($intesiti,2)."</td>";				
				$ret.="</tr>";
				$totobalanci=$openingBalance_2-$withamnt1_2+$contribamt_2+$intesiti;
				
					$ret.="<tr>";
			$ret.="<td><b>Closing Balance</b></td><td>".number_format($ClosingBalance_2,2)."</td>";				
				$ret.="</tr>";
				
					$ret.="</tbody>";
						$ret.="</table>";
				
		
	echo $ret;
}
else{
	
	echo "No data";
		
		
	}
		
		
	}
	
	if($act=="actuarialreport"){
		//txtstartmonth: txtstartmonth, txtyear: txtyear
		$txtstartmonth=$_POST['txtstartmonth'];
		$txtyear=$_POST['txtyear'];
		$mntname=getMonthNameFromNum($txtstartmonth);
		//echo $staffid;
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		$ret.="</th><th>Staff Number</th><th>Name</th><th>Remarks</th><th>Opening Balance</th><th>Interest on Opening Balance</th><th>Contribution</th><th>";
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Interest on Contribution";
		$ret.="</th>";
		$ret.="<th>Partial/Full Withdrawal</th>";
		$ret.="<th>Closing Balance @ $mntname $txtyear</th>";
		
		$ret.="<th>Date</th>";
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		$qry="select distinct staffid from tblcontributions where payrollsource<>'OTHERS'";
	$res=mysql_query($qry);
$num=mysql_num_rows($res);

if($num>0){
	$rd=mysql_fetch_assoc($res);
	do{
		$staffid=$rd['staffid'];
		//$contribid=$staffid=$rd['contribid'];
		//echo $staffid."-".$contribid.
		$staffname=returnQueryValue("SELECT CONCAT(surname,' ',firstname)namer FROM tblmembers where staffid='$staffid'","namer");
		$remark=returnQueryValue("select payrollsource from tblmembers where staffid='$staffid'","payrollsource");
		$min_month=returnQueryValue("select min(mnt)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$max_month=returnQueryValue("select max(mnt)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$min_year=returnQueryValue("select min(tyear)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		$max_year=returnQueryValue("select max(tyear)mnt from tblallocation where staffid='$staffid' and mnt=$txtstartmonth and tyear=$txtyear","mnt");
		if(!empty($min_month)){
			$i=0;
		//	echo $staffid." min_month=".$min_month." max_month=".$max_month." min_year=".$min_year." max_year=".$max_year."<br>";
			for ($xy = $min_year; $xy <= $max_year; $xy++) {
				for ($xm = $min_month; $xm <= $max_month; $xm++) {
					$i+=1;
					$rdo=mysql_fetch_assoc(mysql_query("select * from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id ASC LIMIT 1"));
					$openingBalance= $rdo['openbalance'];
					$contribamt=$rdo['contrib']; 
					$intcontribute=returnQueryValue("select sum(intcontrib)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
				//	echo $intcontribute;
					$fid=$rdo['id'];
					$withamnt1=returnQueryValue("select sum(withdrawalamount)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if($withamnt1==""){
						$withamnt1="0";
					}
					
					$rdo2=mysql_fetch_assoc(mysql_query("select (openbalance+intopenbalance)closingbalance,investdate,intopenbalance,contrib,id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy ORDER BY id desc LIMIT 1"));
					$ClosingBalance= $rdo2['closingbalance'];
					$contribamt2=$rdo2['contrib'];
					$intopenbalance=returnQueryValue("select sum(intopenbalance)intcontriber from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","intcontriber");
					if((int)$openingBalance<1){
						$intopenbalance=0;
					}
					//$trint=(int)$ClosingBalance-(int)$openingBalance
					$sid=$rdo2['id'];
					$investdate=$rdo2['investdate'];
					$withexist2=returnQueryValue("select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like '%Withdrawal%'","id");
					//echo "select id from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy and comment like %Withdrawal%<br>";
					$fwithdrawal=0;
					if(!empty($withexist2)){
							$withamnt2=returnQueryValue("select sum(amount)withamnt from tblwithdrawal where allocid=$withexist2 and approved='Y'","withamnt");
						//echo $withexist2;
						if($withamnt2==""){
							$withamnt2="0";
						}
						$fwithdrawal=(int)$withamnt1+(int)$withamnt2;
					}
				
					$ret.="<tr>";
					//$max_id=returnQueryValue("select max(id)mnt from tblallocation where staffid='$staffid' and mnt=$xm and tyear=$xy","mnt");
					//$baldate=returnQueryValue("select investdate from tblallocation where staffid='$staffid' and id=$max_id and mnt=$xm and tyear=$xy","investdate");
				
				$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".$staffid."</td>";
				$ret.="<td>".$staffname."</td>";
				$ret.="<td>".$remark."</td>";
				
				
				
				$ret.="<td>".number_format($openingBalance ,2)."</td>";
				$ret.="<td>".number_format($intopenbalance,2)."</td>";
				
				
				$ret.="<td>".number_format($contribamt,2)."</td>";
				if((int)$contribamt>0){
					$ddx=$xy."-".$xm."-20";
					$lastday =date("t", strtotime($ddx));
					$nminvdays=(int)$lastday -20;
					$intcontribute=$contribamt * $intrate/100 * $nminvdays/365;
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}else{
					$ret.="<td>".number_format($intcontribute,2)."</td>";
				}
				
				$ret.="<td>".number_format($withamnt1,2)."</td>";
				
				//$clsBal=round($rd['openbalance']+$rd['intopenbalance']+$rd['contrib']+$rd['intcontrib'],2);
				$ret.="<td>".number_format($ClosingBalance,2)."</td>";
				$ret.="<td>".$investdate."</td>";
				//$ret.="<td>".$rd['investdate']."</td>";
				$ret.="</tr>";
					
					//echo "$staffid Month:$xm - Opening balance $openingBalance - Contibution amt- $contribamt ClosingBalance: $ClosingBalance Withdrawal: $fwithdrawal <br>";
					//echo "$staffid Month:$xm - Closing balance $ClosingBalance - Contibution amt- $contribamt2 <br>";
				} 
			} 
		}
		
		
	}
	while($rd=mysql_fetch_assoc($res));
	echo $ret;
}
else{
	
	echo "No data";
		
		
	}
		
	}
		
	if($act=="viewcontributions"){
		$curuser=@$_COOKIE['curuser'];
		$ret="";
		$ret.="<table id='dynamic-table' class='table table-striped table-bordered table-hover'><thead>";
		$ret.="<tr><th class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label>";
		$ret.="</th><th>Source</th><th>Reference #</th><th>Amount</th><th>";
		$ret.="<i class='ace-icon fa fa-clock-o bigger-110 hidden-480'></i>";
		$ret.="Payment Date";
		$ret.="</th>";
		$ret.="<th class='hidden-480'>Status</th>";
		
	
		$ret.="</tr></thead>";	
		$ret.="<tbody>";
		
		$curinvest=mysql_fetch_assoc(mysql_query("select * from tbldeposits where staffid='$curuser'"));
		
		$qry="select * from tbldeposits where staffid='$curuser'";	
		//echo $qry;exit;
			$res=mysql_query($qry);
			$num=mysql_num_rows($res);
			if($num<1){
				echo "You have no contribution at this time. Check back later";exit;
			}
			$rd=mysql_fetch_assoc($res);
			do{
				$ret.="<tr>";
				
				$ret.="<td class='center'><label class='pos-rel'><input type='checkbox' class='ace' /><span class='lbl'></span></label></td>";
				$ret.="<td>".$rd['source']."</td>";
				$ret.="<td>".$rd['refnum']."</td>";
				$ret.="<td>".number_format($rd['amount'],3)."</td>";
				$ret.="<td>".$rd['paymentdate']."</td>";
				$status=$rd['confirm'];
				if($status=="Y"){
					$ret.="<td>Invested</td>";
				}
				else{
					$ret.="<td>Unused</td>";
				}
				
				
				$ret.="</tr>";
			}
			while($rd=mysql_fetch_assoc($res));
				$ret.="</tbody></table>";							
												
				echo $ret;											
														
	}
	
	if($act=="loadchangerequestreport"){
		$txtdate=$_POST['txtdate'];
		$txtdate2=$_POST['txtdate2'];
		$txtdate=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate)));
		$txtdate2=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate2)));
		//$curuser=@$_COOKIE['curuser'];
					$qry="select * from tblchange where deleted='N' and ddate between '$txtdate' and '$txtdate2' order by id desc";
		//echo $qry;exit;
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
				$ret.="<th>Change Type</th>";
				$ret.="<th>Old Amount</th>";
				$ret.="<th>New Amount</th>";
				$ret.="<th>Month</th>";
				$ret.="<th>Year</th>";
				$ret.="<th>Request Date</th>";
				$ret.="<th>Approved</th>";
				$ret.="<th>Date Approved</th>";
				
				$ret.="<th></th></tr></thead><tbody>";
				
			do{
				//$sid=$rd['staffid'];
				$sidnom=$rd['id'];
				//$curTask=returnQueryValue("select * from tbltasks where staffid='$sid' and status='A'","task");
				$ret.="<tr>";
				$ret.="<td>".$rd['changetype']."</td>";
				$ret.="<td>".$rd['oldcontribute']."</td>";
				
				$ret.="<td>".$rd['newcontribute']."</td>";
				
				$ret.="<td>".$rd['mnt']."</td>";
				
					$ret.="<td>".$rd['yr']."</td>";
					$ret.="<td>".$rd['ddate']."</td>";
					$ret.="<td>".$rd['approved']."</td>";
					$ret.="<td>".$rd['dateapproved']."</td>";
					
				$ret.="<td>			<span class='vbar'></span><a href='javascript:deleteChange(\"$sidnom\")' class='red'><i class='ace-icon fa fa-times bigger-180'></i></a><span class='vbar'></span></div></td>";
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
	
	if($act=="loadchangewithdrawalreport"){
		$txtdate=$_POST['txtdate'];
		$txtdate2=$_POST['txtdate2'];
		$txtdate=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate)));
		$txtdate2=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate2)));
				$qry="select * from tblwithdrawal where ddate between '$txtdate' and '$txtdate2' order by id desc";
		//echo $qry;exit;
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
				
				$ret.="<th>Type</th>";
				$ret.="<th>Amount</th>";
				$ret.="<th>Reason</th>";
				$ret.="<th>Bank</th>";
				$ret.="<th>Account Name</th>";
				$ret.="<th>Account Number</th>";
				$ret.="<th>Request Date</th>";
				$ret.="<th>Approved</th>";
				$ret.="<th>Date Approved</th>";
				$ret.="<th>Approved By</th>";
				$ret.="<th></th></tr></thead><tbody>";
				
			do{
				$sid=$rd['staffid'];
				$sidnom=$rd['id'];
				$surname=returnQueryValue("select surname from tblmembers where staffid='$sid'","surname");
				$firstname=returnQueryValue("select firstname from tblmembers where staffid='$sid'","firstname");
				$approvestaff=$rd['approvedby'];
				$staffname=returnQueryValue("SELECT CONCAT(surname,' ',firstname)namer FROM tblmembers where staffid='$approvestaff'","namer");
				$ret.="<tr>";
				$ret.="<td>".$rd['wtype']."</td>";
				$ret.="<td>".$rd['amount']."</td>";
				$ret.="<td>".$rd['reason']."</td>";
				$ret.="<td>".$rd['bank']."</td>";
				$ret.="<td>".$rd['accname']."</td>";
					$ret.="<td>".$rd['ddate']."</td>";
					$ret.="<td>".$rd['approved']."</td>";
				$ret.="<td>".$rd['accnum']."</td>";
				$ret.="<td>".$rd['dateapproved']."</td>";
				$ret.="<td>".$staffname."</td>";
				//$ret.="<td>".$sid."</td>";
				
				
				
				
				//$ret.="<td><div class='pull-right action-buttons'><a href='javascript:approve(\"$sidnom\");' class='blue'><i class='ace-icon fa fa-check bigger-180'></i></a>
				//<span class='vbar'></span><a href='javascript:deletepayment(\"$sidnom\")' class='red'><i class='ace-icon fa fa-times bigger-180'></i></a><span class='vbar'></span></div></td>";
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
	
	if($act=="loaddepositreport"){
		$txtdate=$_POST['txtdate'];
		$txtdate2=$_POST['txtdate2'];
		$txtdate=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate)));
		$txtdate2=date('Y-m-d', strtotime(str_replace('/', '-', $txtdate2)));
		$qry="select * from tbldeposits where paymentdate between '$txtdate' and '$txtdate2' and deleted='N' order by id desc";
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
				$ret.="<th>Bank</th>";
				$ret.="<th>Ref No#</th>";
				$ret.="<th>Amount</th>";
				$ret.="<th>Payment Date</th>";
				
				$ret.="<th>Confirmed</th>";
				$ret.="<th>Rejected</th>";
				$ret.="</tr></thead><tbody>";
				
			do{
				//$sid=$rd['staffid'];
				$sidnom=$rd['id'];
				//$curTask=returnQueryValue("select * from tbltasks where staffid='$sid' and status='A'","task");
				$ret.="<tr>";
				$ret.="<td>".$rd['source']."</td>";
				$ret.="<td>".$rd['refnum']."</td>";
				$ret.="<td><b class='green'>".number_format($rd['amount'],2)."</b></td>";
				$ret.="<td>".$rd['paymentdate']."</td>";
				
				
				$ret.="<td><span class='label label-danger arrowed'><b>".$rd['confirm']."</b></span></td>";
				$ret.="<td><span class='label label-danger arrowed'><b>".$rd['rejected']."</b></span></td>";
				
	
				//$ret.="<td><div class='pull-right action-buttons'>
				//<span class='vbar'></span><a href='javascript:deletepayment(\"$sidnom\")' class='red'><i class='ace-icon fa fa-times bigger-180'></i></a><span class='vbar'></span></div></td>";
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