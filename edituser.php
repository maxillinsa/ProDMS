
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$cid=$_GET['id'];

if(empty($cid)){
	header("location:users.php");
}

$unitid=returnQueryValue("select unitid from pro_users where usern='$curuser'","unitid");
//$ownerdept=returnQueryValue("select deptid from pro_users where id=$unitid","deptid");
						//	$compid=returnQueryValue("select compid from pro_users where id=$ownerid","compid");

	$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
	
	$ownerdept=returnQueryValue("select deptid from pro_users where id=$userid","deptid");
		$compid=returnQueryValue("select compid from pro_users where id=$userid","compid");
		
		$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
							$deptname=returnQueryValue("select name from pro_departments where id=$ownerdept","name");
							$unitname=returnQueryValue("select name from pro_dept_units where id=$unitid","name");
							
						
	
	//echo $memid;exit;
?>


			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Home</a>
							</li>
							<li class="active">Dashboard</li>
						</ul><!-- /.breadcrumb -->

						
					</div>

					<div class="page-content">
						<div class="ace-settings-container" id="ace-settings-container">
							<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-cog bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<div class="pull-left">
											<select id="skin-colorpicker" class="hide">
												<option data-skin="no-skin" value="#438EB9">#438EB9</option>
												<option data-skin="skin-1" value="#222A2D">#222A2D</option>
												<option data-skin="skin-2" value="#C6487E">#C6487E</option>
												<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
											</select>
										</div>
										<span>&nbsp; Choose Skin</span>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
										<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
										<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
										<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
										<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
										<label class="lbl" for="ace-settings-add-container">
											Inside
											<b>.container</b>
										</label>
									</div>
								</div><!-- /.pull-left -->

								<div class="pull-left width-50">
									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
										<label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
										<label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
									</div>

									<div class="ace-settings-item">
										<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
										<label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
									</div>
								</div><!-- /.pull-left -->
							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->

						<div class="page-header">
							<h1>
								User
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Setup
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
				
						<div class="row">
									<div class="col-xs-12">
										<div>
															
											

										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										
										<div class="col-xs-12 col-sm-6">
											<div class="widget-box">
												<div class="widget-header">
													<h4 class="widget-title">Edit User Account</h4>

													<span class="widget-toolbar">
													

													

														<a href="#" data-action="collapse">
															<i class="ace-icon fa fa-chevron-up"></i>
														</a>

														<a href="#" data-action="close">
															<i class="ace-icon fa fa-times"></i>
														</a>
													</span>
												</div>

												<div class="widget-body">
													<div class="widget-main">
													<?php 
													$rd=mysql_fetch_assoc(mysql_query("select * from pro_users where id=$cid"));
													$activey=$rd['active'];
													
													
													?>
													<div>
													<label for="form-field-select-1"><b>Username *</b></label>

														<input type="text" id="txtusername"  class="form-control" value="<?php echo $rd['usern']; ?>" disabled />
														
														</div>
														
														
														<div>
															<label for="form-field-select-1"><b>Fullname</b></label>

														<input type="text" id="txtfullname" class="form-control" value="<?php echo $rd['Fullname']; ?>" />
														
														</div>
												
														<div>
															<label for="form-field-select-1"><b>Department</b></label>
	
															<select class="chosen-select form-control" id="cbodept" data-placeholder="Choose a department..." onchange="loadunits();">
															<?php 
															echo "<option value='$ownerdept' selected>$deptname</option>";
															?>
															</select>
														
														</div>
														
														<div>
															<label for="form-field-select-1"><b>Unit</b></label>

															<select class="chosen-select form-control" id="cbounit" data-placeholder="Choose a unit..." >
															<?php 	echo "<option value='$unitid' selected>$unitname</option>"; ?>
															</select>
														
														</div>
														
														
														<div>
															<label for="form-field-select-1"><b>Password</b></label>

														<input type="password" id="txtpass" placeholder="Reset Password" class="form-control" value="" />
														
														</div>
														
														<div>
															<label for="form-field-select-1"><b>User Type</b></label>

														<select class="chosen-select form-control" id="cbousertype" data-placeholder="Choose a type...">
															
															<option value="user">user</option>
															<option value="admin">admin</option>
															
															<option value="reporting">reporting</option>
															<option value="superadmin">superadmin</option>
																
															</select>
														
														Active: <input type="checkbox" id="chkactive" checked>
														</div>
														
															
														<br>
															<button class="btn btn-primary" onclick="savedata();">
												<i class="ace-icon fa fa-check-square-o align-top bigger-125"></i>
												Save
											</button>
														
														
													</div>
														</div>
												</div>
											</div>
										</div><!-- /.span -->
								

									</div>
								</div>

								
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
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
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
				<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>
	<script src="assets/js/dropzone.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<script src="func.js"></script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
		
		</script>
		
		<script type="text/javascript">
		
		var cid="<?php echo $cid; ?>";
		var compid="<?php echo $compid; ?>";
		
		var unitid="<?php echo $unitid; ?>";
		var unitname="<?php echo $unitname; ?>";
		var ownerdept="<?php echo $ownerdept; ?>";
		var deptname="<?php echo $deptname; ?>";
		var activey="<?php echo $activey; ?>";
		
		
		
		
		function savedata(){
			
			
			//txtusername,txtfullname	,cbodept,cbounit,txtpass,cbousertype	
			
			
			var txtfullname=Tvar("txtfullname").value;
			var cbodept=Tvar("cbodept").value;
			var cbounit=Tvar("cbounit").value;
			var txtpass=Tvar("txtpass").value;
			var cbousertype=Tvar("cbousertype").value;
			
			if(txtusername==""){
				msgError("Username is required");return;
			}
			
			if(txtfullname==""){
				msgError("Fullname  is required");return;
			}
			var activey="";
			if(Tvar("chkactive").checked == true){
				activey="Y";
			}
			else{
				activey="N";
			}
			
			
			
			
			 $.post("controller/utility.php", {activey:activey,userid:cid, txtfullname: txtfullname, act: 'edituser', cbodept: cbodept,cbounit: cbounit, txtpass: txtpass, cbousertype: cbousertype },
						   function (data) {

							   if (data.length > 0) {
								   
								  // alert(data);
								   
								   if(data=="1"){
										window.location="users.php";
								   }
								   
								   if(data=="0"){
									   msgError("Could not update record");return;
								   }
								   
								   
								   
							   }

							});
			
		}
		
	
function loadCompanies(){
	
	//divres
	
	 $.post("controller/utility.php", {act: 'loadcompany' },
						   function (data) {

							   if (data.length > 0) {
								   
								  
									
								   Tvar("divres").innerHTML=data;
							   }

							});
}

	loaddeptcombo();
			function loaddeptcombo(){
				var cmcompany=compid;
				//selunit=cmcompany;
					 $.post("controller/utility.php", {act: 'loaddeptcmbbycompany', cmcompany: cmcompany },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry2(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
			function loadunits(){
				 var cbodept = document.getElementById("cbodept").value;
				// Tvar("divres").innerHTML="";
				  $.post("controller/utility.php", {act: 'loaddeptunit', dept: cbodept },
						   function (data) {

							   if (data.length > 0) {
								   
								 //  alert(data);
									// Tvar("divres").innerHTML=data;
									loadcountry3(data);
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				 
				
			}
			
			
			
			 function loadcountry2(dt) {

                var dropdownList = document.getElementById("cbodept");
                clearlistbox(dropdownList);
                var option = new Option(ownerdept, deptname);
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html(deptname);
                $("#cbodept").append(option);
                var n = dt.split(";");
                var j;
                for (var i = 0; i < n.length; i++) {
                    if (!n[i] == "") {
                        dt = n[i];
                        j = dt.split("|");
                        id = j[0];
                        //  var option = document.createElement("option");
                        //   var option = new Option(j[1], j[0]);
                        //alert(j[0])
                        var option = new Option(j[1], j[0]);
                        /// jquerify the DOM object 'o' so we can use the html method
                        $(option).html(j[1]);
                        $("#cbodept").append(option);
                    }
                }



            }
			
			
			
			 function loadcountry3(dt) {
//$unitid-$unitname
						//	$ownerdept-$deptname
                var dropdownList = document.getElementById("cbounit");
                clearlistbox(dropdownList);
                var option = new Option(unitid, unitname);
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html(unitname);
                $("#cbounit").append(option);
                var n = dt.split(";");
                var j;
                for (var i = 0; i < n.length; i++) {
                    if (!n[i] == "") {
                        dt = n[i];
                        j = dt.split("|");
                        id = j[0];
                        //  var option = document.createElement("option");
                        //   var option = new Option(j[1], j[0]);
                        //alert(j[0])
                        var option = new Option(j[1], j[0]);
                        /// jquerify the DOM object 'o' so we can use the html method
                        $(option).html(j[1]);
                        $("#cbounit").append(option);
                    }
                }



            }
			
			  	
		</script>
	</body>
</html>
