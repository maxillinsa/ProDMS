<!DOCTYPE html>
<?php 


?>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>CronosDoc Installation</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.min.css" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="../assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="../assets/js/html5shiv.min.js"></script>
		<script src="../assets/js/respond.min.js"></script>
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
								
								<h4 id="id-company-text" style="color:white;font-size:26px">Install CronoDoc</h4>
								
								
							
							</div>

							<div class="space-6"></div>

								<div id="signup-box1"  style="border: 3px solid #022E63;">
									<div class="widget-body">
										<div class="widget-main" id="signupcontent">
											<h5 class="header green lighter bigger">
												<i class="ace-icon fa blue"></i>
												<span style="font-size:26px;">Application Installation</font>
											</h5>

											<div class="space-6"></div>
											
											
											<?php 
											
											$phpvers="5.3.4";
											$this_version=phpversion();
											
											if (version_compare(PHP_VERSION, $phpvers) >= 0) {}else{
												
											
											?>
											
											<div class="alert alert-warning">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>
											<strong>Warning!</strong>

											<span style="font-size:9px;">Your version of PHP is higher than the version required. Please see Installation Instructions<br>
												Install on PHP Platform that supports mysql_query, mysql_fetch_assoc e.t.c</font>
											
										</div>
										
										<?php } ?>

											<form>
										<span style="color:red;font-size:16px;font-weight:bold;" id="sperror"></span><br>
												<fieldset>
													<label class="block clearfix">MySQL DB Host
														<span class="block input-icon input-icon-right">
													<input type="text" class="form-control" placeholder="localhost" id="txtdbhost" name="txtdbhost" value="localhost" />
															<i class="ace-icon fa "></i>
														</span>
													</label>
													
													
													
													<label class="block clearfix">MySQL Database Name
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Database Name" id="txtdbname" name="txtdbname" />
															<i class="ace-icon fa "></i>
														</span>
													</label>
														<label class="block clearfix">MySQL Database Username.
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" id="txtdbusername" name="txtdbusername" />
															<i class="ace-icon fa "></i>
														</span>
													</label>
													
													<label class="block clearfix">MySQL Database Password.
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" id="txtdbpass" name="txtdbpass" />
															<i class="ace-icon fa "></i>
														</span>
													</label>
											
<span style="color:red;font-size:16px;font-weight:bold;" id="sperror2"></span>
													<div class="space-24"></div>

													<div class="clearfix">
														<button type="reset" class="width-30 pull-left btn btn-sm">
															<i class="ace-icon fa fa-refresh"></i>
															<span class="bigger-110">Reset</span>
														</button>
														
														<span id="butpsan">

														<button type="button" class="width-65 pull-right btn btn-sm btn-primary" onclick="isntall();">
															<span class="bigger-110">Install</span>

															<i class="ace-icon fa fa-arrow-right icon-on-right"></i>
														</button>
														
														</span>
													</div>
												</fieldset>
											</form>
										</div>

										
									</div><!-- /.widget-body -->
								</div><!-- /.signup-box -->
								
								<div class="alert alert-block alert-success" style="display:none;" id="divsuccessful">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>

											<p>
												<strong>
													<i class="ace-icon fa fa-check"></i>
													Success!
												</strong>
												Application installed successfully
											</p>

											<p>
												<a href="../login.php"><button class="btn btn-sm btn-success">Click here to continue</button></a>
												
											</p>
										</div>
							
							
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
		<script src="../assets/js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="../assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script src="../func.js"></script>
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
			
			function isntall(){
				//txtdbhost,txtdbname,txtdbusername,txtdbpass
				var txtdbhost=Tvar("txtdbhost").value;
				var txtdbname=Tvar("txtdbname").value;
				var txtdbusername=Tvar("txtdbusername").value;
				var txtdbpass=Tvar("txtdbpass").value;
				//alert(txtdbhost);
				if(txtdbhost==""){
					logError("Please specify Database Server host address");return;
				}
				
				if(txtdbname==""){
					logError("Please specify your Database name");return;
				}
				
				if(txtdbusername==""){
					logError("Please specify your Database Username");return;
				}
				
				if(txtdbpass==""){
					//logError("Please specify your Database Password");return;
				}
				
				Tvar("butpsan").style.display="none";
				
				
				$.post("install.php", {txtdbhost:txtdbhost,txtdbname:txtdbname,txtdbusername:txtdbusername,txtdbpass:txtdbpass},
						   function (data) {

							   if (data.length > 0) {
								  if(data=="1"){
									 // alert(data);
									 Tvar("signup-box1").style.display="none";
									 Tvar("divsuccessful").style.display="block";
								  }
								  else{
									  logError(data);
									  Tvar("butpsan").style.display="block";
								  }
							   }

							});
				
			}
		</script>
	</body>
</html>
