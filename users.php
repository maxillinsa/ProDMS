
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];

	
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
							<li class="active">Settings</li>
						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
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
							<i class="ace-icon"><img src="img/users.png" style="width:50px;height:50px;"></i>
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
										<h3 class="header smaller lighter blue">Manage Users</h3>
										
										<div class="col-xs-6">

										<label for="form-field-select-3"><b>Select Company</b></label>

															
															<select class="chosen-select form-control" id="cmcompany" data-placeholder="Choose a Company..." onchange="loaddeptcombo();">
																
															</select>
															
															</div>
															
															<div class="col-xs-6">
															<label for="form-field-select-3"><b>Department</b></label>

															
															<select class="chosen-select form-control" id="cbodept" data-placeholder="Choose a department..." onchange="loadunits();">
																
															</select>
															
															</div>
															
															<div class="col-xs-6">
															<label for="form-field-select-3"><b>Workspace</b></label>

															
															<select class="chosen-select form-control" id="cbounit" data-placeholder="Choose a unit..." onchange="loadunittable();">
																
															</select>
															
															</div>
										
										
										<div class="col-xs-6"><br>
											<a href="javascript:addept();"><button class="btn btn-primary">
												<i class="ace-icon fa  fa-users align-top bigger-125"></i>
												Add New User
											</button></a><br><br>
</div>
										<!-- div.table-responsive -->

										<!-- div.dataTables_borderWrap -->
										
										<div id="divres">
											
										</div>
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

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
		
		</script>
		
		<script type="text/javascript">
		
		//loadCompanies()
	var selunit="";
function loadCompanies(){
	
	//divres
	var cmcompany=Tvar("cmcompany").value;
	//selcomp=cmcompany;
	Tvar("divres").innerHTML="";
	 $.post("controller/utility.php", {act: 'loaddepttable', cmcompany: cmcompany },
						   function (data) {

							   if (data.length > 0) {
								   
								  
									
								   Tvar("divres").innerHTML=data;
							   }

							});
}

loadDept();
				function loadDept(){
					
					 $.post("controller/utility.php", {act: 'loadcompanycmb' },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				}
				
				  function loadcountry(dt) {

                var dropdownList = document.getElementById("cmcompany");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cmcompany").append(option);
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
                        $("#cmcompany").append(option);
                    }
                }



            }
			
			function addept(){
				//newdepartment.php
				if(selunit==""){
					
					return;
				}
				window.location="newuser.php?unitid="+selunit;
			}
			
			function loaddeptcombo(){
				var cmcompany=Tvar("cmcompany").value;
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
				 Tvar("divres").innerHTML="";
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
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
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

                var dropdownList = document.getElementById("cbounit");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
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
			
			function loadunittable(){
				//divres
	var cbounit=Tvar("cbounit").value;
	selunit=cbounit;
	//selcomp=cmcompany;
	Tvar("divres").innerHTML="";
	 $.post("controller/utility.php", {act: 'loadusertable', cbounit: cbounit },
						   function (data) {

							   if (data.length > 0) {
								   
								  
									
								   Tvar("divres").innerHTML=data;
							   }

							});
				
			}
			
			  	
		</script>
	</body>
</html>
