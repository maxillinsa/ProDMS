<?php 
$curuser=@$_COOKIE['curuser'];
	if(empty($curuser)){
		
	//	header("location:login.php");
		
		echo "<script type='text/javascript'>window.location.href = 'login.php';</script>";
        exit();
	}
	
	include("controller/func.php");
	$fname=returnQueryValue("select Fullname from pro_users where usern='$curuser'","Fullname");
	
	$usertype=returnQueryValue("select usertype from pro_users where usern='$curuser'","usertype");
		//echo $usertype;exit;
	$logourl=getParamValue("logourl");
	//echo $logourl;exit;
	$appname=getParamValue("appname");
	

?>

<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $appname; ?></title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="shortcut icon" href="favicon.png" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="tools/dist/themes/default/style.min.css" />
		
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
	<link rel="stylesheet" href="assets/css/chosen.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<link rel="stylesheet" href="assets/css/dropzone.min.css" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
		<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->
<link rel="stylesheet" href="assets/css/apprise.css" />
		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>
			<link rel="stylesheet" href="assets/css/jquery-ui.css.css" />
<script type="text/javascript" src="assets/js/apprise-1.5.full.js"></script>

    
		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<style>
		#drop_file_zone {
	    background-color: #EEE; 
	    border: #999 2px dashed;
	    width: 600px; 
	    height: 200px;
	    padding: 8px;
	    font-size: 18px;
	}
	#drag_upload_file {
		width:80%;
		margin:0 auto;
	}
	#drag_upload_file p {
		text-align: center;
	}
	#drag_upload_file #selectfile {
		display: none;
	}
	
	.explorer_folder{
		
		margin-left:10px;
		margin-bottom:5px;
		padding:10px;
		height:140px;
		width:150px; 
		border: #999 1px solid;
		border-radius:5px;
		display:inline-table;
	}
	
	.explorer_folder:hover{
		
		margin-left:10px;
		margin-bottom:5px;
		padding:10px;
		height:140px;
		width:150px; 
		border: #999 2px solid;
		border-radius:5px;
		display:inline-table;
		 background-color: #EEE;
	}
		</style>
		<script src="func.js"></script>
	</head>

	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default          ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							&nbsp;<img src="img/<?php echo $logourl; ?>"  style="width:160px;height:30px;">
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						

						<li class="dropdown-modal" style="background-color:#022E63;">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="background-color:#022E63;">
								<img class="nav-user-photo" src="assets/images/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>Welcome,</small>
									<?php 
									//echo strlen($uname);
									//$uname=preg_replace('/\s+/', '', $uname);
								echo $fname;
									?>
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li style="display:none;">
									<a href="#">
										<i class="ace-icon fa fa-cog"></i>
										Settings
									</a>
								</li>

								<li>
									<a href="changepassword.php">
										<i class="ace-icon fa fa-user"></i>
										Change Password
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="logout.php">
										<i class="ace-icon fa fa-power-off"></i>
										Logout
									</a>
								</li>
</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				

				<ul class="nav nav-list">
					<li class="active">
						<a href="index.php">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> Documents </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="newjob.php">
									<i class="menu-icon fa fa-caret-right"></i>
									New Document
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="dropoff.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Drop-Off
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="managefiles.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Search
								</a>

								<b class="arrow"></b>
							</li>

						
						</ul>
					</li>
					
					
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text"> Operations </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						
							<li class="">
								<a href="managefiles.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Discuss
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="explore_company.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Manage Folders
								</a>

								<b class="arrow"></b>
							</li>
							
							
							<li class="">
								<a href="managefiles.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Explore Files
								</a>

								<b class="arrow"></b>
							</li>
					
						
						
							
						</ul>
</li>

<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Workflow </span>

							<span class="badge badge-primary">2</span><b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="startworkflow.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Start Workflow
								</a>

								<b class="arrow"></b>
							</li>
							
								<li class="">
								<a href="mytickets.php">
									<i class="menu-icon fa fa-caret-right"></i>
									My Tickets
								</a>

								<b class="arrow"></b>
							</li>
							
							

						</ul>
					</li>
<?php 
	if($usertype=="superadmin" || $usertype=="admin"){
?>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cogs"></i>
							<span class="menu-text">
								Settings
							</span>

							<span class="badge badge-primary">7</span><b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
						<?php if ($usertype=="superadmin"){ ?>
						
							<li class="">
								<a href="companies.php">
									<i class="menu-icon fa fa-caret-right"></i>

									Organizations
									
								</a>

								<b class="arrow"></b>

							
							</li>
							
							<li class="">
								<a href="departments.php">
									<i class="menu-icon fa fa-caret-right"></i>

									Departments
									
								</a>

								<b class="arrow"></b>

							
							</li>

						
							<li class="">
								<a href="units.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Workspaces
								</a>

								<b class="arrow"></b>
							</li>
						<?php } ?>
							
								<li class="">
								<a href="workflow.php">
									<i class="menu-icon fa fa-caret-right"></i>
									WorkFlow Tasks
								</a>

								<b class="arrow"></b>
							</li>
							
								
							
							<li class="">
								<a href="metadata.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Metadata Definition
								</a>

								<b class="arrow"></b>
							</li>
							
							

							
								<li class="">
								<a href="users.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Users
								</a>

								<b class="arrow"></b>
						
							
								<?php if($usertype=="superadmin"){ ?>
							
							<li class="">
								<a href="settings.php">
									<i class="menu-icon fa fa-caret-right"></i>
									General App Settings
								</a>

								<b class="arrow"></b>
							</li>
							
								<?php } ?>
							
							

							
							

						
						</ul>
</li>
	<?php } ?>
					

				

				<?php if($usertype=="superadmin"){ ?>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Audit Log </span>

							<span class="badge badge-primary">1</span><b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="usertrail.php">
									<i class="menu-icon fa fa-caret-right"></i>
									View Trail (User)
								</a>

								<b class="arrow"></b>
							</li>
							
					

						</ul>
					</li>
				<?php } ?>
					
					<li class="">
					
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file-o"></i>

							<span class="menu-text">
								Report

								<span class="badge badge-primary">7</span>
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							
							<li class="">
								<a href="metadatareport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Metadata Report
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="companyreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Organization Listing
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="departmentsreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Departments Listing
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="unitsreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Workspaces Listing
								</a>

								<b class="arrow"></b>
							</li>
							
								<li class="">
								<a href="foldersreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Folders Listing
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="documentsreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Documents Listing
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="">
								<a href="usersreport.php">
									<i class="menu-icon fa fa-caret-right"></i>
									Users Listing
								</a>

								<b class="arrow"></b>
							</li>
						
						
						
						
						
						
						</ul>
</li>
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>
				
