<!DOCTYPE html>
<?php 

$curuser=@$_COOKIE['curuser'];
if($curuser==""){
	
}else{
	header("location: index.php");
}

include("controller/func.php");
	//$fname=returnQueryValue("select Fullname from pro_users where usern='$curuser'","Fullname");
	
	$logourl=getParamValue("logourl");
	//echo $logourl;exit;
	$appname=getParamValue("appname");

?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page - <?php echo $appname; ?></title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	
		<style>
		
		body{
			
			 background: -moz-linear-gradient(left, rgba(60, 64, 143, 0.95) 0%, #022E63 78%);
  background: -webkit-linear-gradient(left, rgba(60, 64, 143, 0.95) 0%, #022E63 78%);
  background: linear-gradient(to right, rgba(60, 64, 143, 0.95) 0%, #022E63 78%);
		}
		
		</style>
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									
									<img src="<?php echo "img/$logourl"; ?>">
									
								</h1><br>
								<h4 id="id-company-text" style="color:white;">Login::</h4>
								
								
							
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box" style="border: 3px solid #022E63;">
									<div class="widget-body">
										<div class="widget-main">
											<h5 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Please Enter Your Login details
											</h5>
<span style="color:red;font-size:16px;font-weight:bold;" id="sperrorlog"></span>
											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username" id="txtuser" name="txtuser" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="Password" id="txtpword" name="txtpword" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline" style="display:none;">
															
														</label>

											<button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="login();" style="background-color:#022E63;">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
											</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix" style="background-color:#022E63;">
											<div>
												<a href="#" data-target="" class="forgot-password-link" style="color:#D9A300;">
													
													&nbsp;
												</a>
											</div>

											
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" id="txtemail" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
													
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->

								<div id="signup-box" class="signup-box widget-box no-border" style="border: 3px solid #022E63;">>
									<div class="widget-body">
										<div class="widget-main" id="signupcontent">
											<h5 class="header green lighter bigger">
												<i class="ace-icon fa fa-users blue"></i>
												New Member Registration
											</h5>

											<div class="space-6"></div>
											<p> Enter your details to begin: </p>

										
										</div>

										<div class="toolbar center" style="background-color:#022E63;">
											<a href="#" data-target="#login-box" class="back-to-login-link" style="color:#D9A300;">
												<i class="ace-icon fa fa-arrow-left"></i>
												Back to login
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
							
							
							</div><!-- /.position-relative -->

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div><br>
							<font style="color:white;"><center>&copy; Naijadailywork<br>nairatag@gmail.com</center></font>
						</div>
						
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="func.js"></script>
<script>

  </script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
		var currentTime = new Date()

		var tmonthw = currentTime.getMonth()+1;
		var tmonth = ('0' + (currentTime.getMonth()+1)).slice(-2);
		var tyear = currentTime.getFullYear()
		var tday = currentTime.getDate();
		//alert(parseInt(tday));
		
		function login(){
			
			var txtuser=Tvar("txtuser").value;
			var txtpword=Tvar("txtpword").value;
			if(txtuser==""){
				logError2("Supply your ID to login");
				return;
			}
			
			if(txtpword==""){
				logError2("Supply your password to login");
				return;
			}
			
			$.post("controller/userAPI.php", {act: 'login',txtuser:txtuser, txtpword:txtpword
			 },
						   function (data) {

							   if (data.length > 0) {
								   
								 //alert(data);
									if(data=="xxx"){
										
										logError2("::Invalid Login Details");
											return;
									}
									
									if(data=="xx1"){
										
											logError2("::Account has been deactivated. Contact Scheme Admin");
											return;
									}
									
									if(data=="1"){
										
										window.location="index.php";
											return;
									}
								
								  
							   }

							});
			
			//logError2
		}
		
		function sendpassword(){
			
			var txtemail=Tvar("txtemail").value;
			if(txtemail==""){ return; }
			
			$.post("controller/userAPI.php", {act: 'sendpassword',txtemail:txtemail},
						   function (data) {

							   if (data.length > 0) {
								 
								
								  
							   }

							});
							
		}
		
		  $("#txtduration").keypress(function (e) {
                   if (!String.fromCharCode(e.which).match(/[^A-Za-z_ ]/)) {
                       e.preventDefault();
                     
                   }
				
               });
			   
			     $("#txtregamount").keypress(function (e) {
					   if (!String.fromCharCode(e.which).match(/[^A-Za-z_ ]/)) {
						   e.preventDefault();
						 
					   }
			        });
		
		
		function logError(er){
			
			Tvar("sperror").innerHTML=er;
			Tvar("sperror2").innerHTML=er;
		}
		
		function logError2(er){
			
			Tvar("sperrorlog").innerHTML=er;
			//Tvar("sperrorlog2").innerHTML=er;
		}
		  
		   
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
				 
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
			
			function startCapture(){
}
		</script>
	</body>
</html>
