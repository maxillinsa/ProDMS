<?php 
$skey = "thisisthepartwheregbegestart"; // you can change it
      //setcookie("bas65Ght", "");
	  //include("Encryption.php");
	//  echo getMonthNameFromNum(3);
	$current_month_num=date("m");
	$current_month_fullname=date("F");
	$current_day_num=date("d");
	$current_year=date("Y");
	
	//echo sha1("hello");
	
	  	include("safe_html.php");
	include("mycon.php");
	
	

require 'PHPMailer-master/PHPMailerAutoload.php';

//$dtr=sendFile("segun1.akinyemy@gmail.com", "Mailing file", "This is a test file", "segun@gmail.com","../instage/1e981db51b923aafe1d7ce450b993c71.xlsx","dataiwe.xlsx");

	//var_dump( $dtr);
	


	
	function recNum($sql){
		
		$res=@mysql_query($sql);
		
		$nm=@mysql_num_rows($res);
		//var_dump($nm);
		return $nm;
	}
	
	function executeStatement($sql){
		
		$res=mysql_query($sql);
		
		return $res;
	}
	
	function returnQueryValue($sql,$fld){
		
		$res=@mysql_query($sql);
		$nm=@mysql_fetch_assoc($res);
		return $nm[$fld];
	}
	

	
	
	

function sendSMS($tel,$msg){
	
	
	$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{ \"from\":\"InfoSMS\", \"to\":\"$tel\", \"text\":\"$msg\" }",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  return "Error #:" . $err;
} else {
  return $response;
}
	
}
	
function sendFile($to, $subject, $message, $from,$fileURL,$fakefilename) {
	
$smtp_host=getParamValue("smtp_host");
	$smtp_port=getParamValue("smtp_port");
	$smtp_username=getParamValue("smtp_username");
	$smtp_password=getParamValue("smtp_password");
	
	

$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = $smtp_host;
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = $smtp_port;

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->addStringAttachment(file_get_contents($fileURL), $fakefilename);
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = $smtp_username;
//Password to use for SMTP authentication
$mail->Password = $smtp_password;
//Set who the message is to be sent from
$mail->setFrom($from, 'ProEDMS');
//Set an alternative reply-to address
$mail->addReplyTo($from, 'Do not reply');
//Set who the message is to be sent to
$mail->addAddress($to, 'User');
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($message);
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    return "Mailer Error: " . $mail->ErrorInfo."<br><a href='javascript:history.back();'>Click here to continue.</a>";
} else {
    return "<img src='../img/sent.png'> Message sent!"."<br><a href='javascript:history.back();'>Click here to continue.</a>";
}

}

function getMonthNameFromNum($num){
	
	switch ($num) {
    case 1:
        return "January";
        break;
    case 2:
        return "February";
        break;
    case 3:
        return "March";
        break;
		
	 case 4:
        return "April";
        break;
	  case 5:
        return "May";
        break;
	 case 6:
        return "June";
        break;
		
	  case 7:
        return "July";
        break;
		
	  case 8:
        return "August";
        break;
		
	  case 9:
        return "September";
        break;
		
	case 10:
        return "October";
        break;

		  case 11:
        return "November";
        break;
		
		  case 12:
        return "December";
        break;
		
    default:
        return "January";
	}
	
}

function getMonthNoFromName($mntName){
	$mnt=strtolower($mntName);
	switch ($mnt) {
    case "january":
        return 1;
        break;
    case "february":
        return 2;
        break;
    case "march":
        return 3;
        break;
		
	 case "april":
        return 4;
        break;
	  case "may":
        return 5;
        break;
	 case "june":
        return 6;
        break;
		
	  case "july":
        return 7;
        break;
		
	  case "august":
        return 8;
        break;
		
	  case "september":
        return 9;
        break;
		
	case "october":
        return 10;
        break;

		  case "november":
        return 11;
        break;
		
		  case "december":
        return 12;
        break;
		
    default:
        return 1;
	}
}

function getLastDayOfAMonth($ddate){
	
	$a_date =$ddate;
return date("t", strtotime($a_date));
}

function getParamValue($paramname){
	
	return returnQueryValue("select paramvalue from params where paramname='$paramname'","paramvalue");
}

function saveParamValue($paramname,$paramvalue){
	$res=mysql_query("update params set paramvalue='$paramvalue' where paramname='$paramname'");
	return "1";
	
}

function AudLog($userid,$op,$folderid,$fileid){
	$dd = date('Y-m-d H:i:s');
	$res=mysql_query("insert into pro_log(comment,userid,ddate,fileid,folderid) values('$op',$userid,'$dd',$fileid,$folderid)");
	return 1;
	
}


?>