
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$folderid=$_GET['folderid'];
$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
$unitid=returnQueryValue("select unit from pro_folder where id=$folderid","unit");
$depit=returnQueryValue("select deptid from pro_dept_units where id=$unitid","deptid");
$compid=returnQueryValue("select companyid from pro_departments where id=$depit","companyid");
$folderpublic=returnQueryValue("select public from pro_folder where id=$folderid","public");
	
	//echo $memid;exit;
?>


			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="index.php">Home</a>
							</li>
							<li class="active">Permission</li>
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
								Access Control
									<a href="javascript:history.back();"><small>
									<i class="ace-icon fa fa-angle-double-left"></i>
									Back on step
								</small></a>
							</h1>
							<h3 class="row header smaller lighter blue">
							<span class="col-sm-7">
												<i class="ace-icon fa " ><img src="img/folder.png" style="width:60px;height:60px;"></i>
												<?php echo $foldername; ?>
											</span><!-- /.col -->
											</h3>
						</div><!-- /.page-header -->

						<div class="row">
						
							
						<div class="col-xs-12 col-sm-4">
											<div class="widget-box">
												<div class="widget-header">
													<h4 class="widget-title">Users</h4>

													
												</div>

												<div class="widget-body">
													<div class="widget-main">
														<div>
															

															<select id="cbousers" style="font-size:14px;height:300px;width:99%;" multiple>
															
															
															</select>
															
															
														</div><br>
<a href="javascript:history.back();"><button class="btn btn-blue"><i class="ace-icon fa fa-angle-double-left"></i> Back</button></a>
													</div>
												</div>
											</div>
										</div><!-- /.span -->
										
										
										<div class="col-xs-4 col-sm-4" style="width:100px;">
											<div >
												<div >
													
												</div>

												<div class="widget-body">
													<div class="widget-main">
													<br><br>
													<p>
														<button type="button" class="btn btn-white btn-inverse btn-bg" onclick="addDept();">>></button><br><br>
														<button type="button" class="btn btn-white btn-inverse btn-bg" onclick="removeSelected();"><<</button>
														
														</p>
													</div>
												</div>
											</div>
										</div><!-- /.span -->
										
										<div class="col-xs-12 col-sm-4">
											<div class="widget-box">
												<div class="widget-header">
													<h4 class="widget-title">Selected Users</h4>

													<div class="widget-toolbar">
														
													</div>
												</div>

												<div class="widget-body">
													<div class="widget-main">
														<div>
															
															<select id="cmbseldepartments" style="font-size:14px;height:300px;width:99%;" multiple onchange="getRoles();">
															
															
															</select>
															
														</div><br>
														<div id="divroles">
														
														</div>
														

														
													</div>
												</div>
											</div>
										</div><!-- /.span -->



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
	
			
			var fileobj;
	function upload_file(e) {
		e.preventDefault();
		fileobj = e.dataTransfer.files[0];
		ajax_file_upload(fileobj);
	}

	function file_explorer() {
		document.getElementById('selectfile').click();
		document.getElementById('selectfile').onchange = function() {
		    fileobj = document.getElementById('selectfile').files[0];
			ajax_file_upload(fileobj);
		};
	}

	function ajax_file_upload(file_obj) {
		if(file_obj != undefined) {
		    var form_data = new FormData();                  
		    form_data.append('file', file_obj);
			$.ajax({
				type: 'POST',
				url: 'upload.php',
				contentType: false,
				processData: false,
				data: form_data,
				success:function(response) {
					//alert(response);
					window.location='processfile.php?'+'id='+response;
					$('#selectfile').val('');
				}
			});
		}
	}
	
	//cmbdepartments
	var folderid="<?php echo $folderid; ?>";
	var cmcompany="<?php echo $compid; ?>";
	loaddeptcombo();
		function loaddeptcombo(){
				
					 $.post("controller/utility.php", {act: 'loadcanonicausers', folderid: folderid },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry2(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
			function loadcountry2(dt) {

                var dropdownList = document.getElementById("cbousers");
                clearlistbox(dropdownList);
              //  var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
              //  $(option).html("");
             //   $("#cmbdepartments").append(option);
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
                        $("#cbousers").append(option);
                    }
                }



            }
			//cmbseldepartments
			
			loadselecteddeptcombo();
			function loadselecteddeptcombo(){
				
					 $.post("controller/utility.php", {act: 'loadselectcanonicausers', folderid: folderid },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry3(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
				function loadcountry3(dt) {

                var dropdownList = document.getElementById("cmbseldepartments");
                clearlistbox(dropdownList);
               // var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                //$(option).html("");
               // $("#cmbseldepartments").append(option);
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
                        $("#cmbseldepartments").append(option);
                    }
                }



            }
			
			function addDept(){
				var cbousers = document.getElementById("cbousers").value;
				if(cbousers==""){return;}
				 $.post("controller/utility.php", {act: 'addusertofolder', folderid: folderid, cbousers:cbousers, cmcompany:cmcompany },
						   function (data) {

							   if (data.length > 0) {
								   // alert(data);
								   loadselecteddeptcombo()
								  
									//loadcountry3(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
				
			}
			
			function removeSelected(){
				var cmbseldepartments = document.getElementById("cmbseldepartments").value;
					//loadselecteddeptcombo()
				if(cmbseldepartments==""){return;}
				 $.post("controller/utility.php", {act: 'removeusertofolder', cmbseldepartments:cmbseldepartments, folderid:folderid },
						   function (data) {

							   if (data.length > 0) {
								   // alert(data);
								   loadselecteddeptcombo();
								  
									//loadcountry3(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
			function makeFolderPublic(){
				
					//var cmbseldepartments = document.getElementById("cmbseldepartments").value;
					//loadselecteddeptcombo()
				
				 $.post("controller/utility.php", {act: 'makefolderpublic', folderid:folderid },
						   function (data) {

							   if (data.length > 0) {
								   //alert (data);
								  // loadselecteddeptcombo();
								  window.location="index.php";
								 
							   }

							});
				
			}
			
			function continueRolesDefinition(){
				
				 $.post("controller/utility.php", {act: 'movetouserlevel', folderid:folderid },
						   function (data) {

							   if (data.length > 0) {
								   //alert (data);
								  // loadselecteddeptcombo();
								  if(data=="1"){
									window.location="permissions_2.php?folderid="+folderid;
								  }else{
									  msgError(data);
								  }
								 
							   }

							});
				
			}
			
			function getRoles(){
				var seluser = document.getElementById("cmbseldepartments").value;
				//alert(seluser);
				 $.post("controller/utility.php", {act: 'getroledetails', folderid:folderid, seluser: seluser },
						   function (data) {

							   if (data.length > 0) {
								   //alert (data);
								  // loadselecteddeptcombo();
								  //window.location="index.php";
								  document.getElementById("divroles").innerHTML="<b>Permissions</b><hr>"+data+"<br><br>";
								  document.getElementById("spbut").style.display="block";
								  
								 
							   }

							});
			}
			
			function applyPrivi(selcheck){
				
				//alert(selcheck);
				var nb=selcheck.split("_");
				var op=nb[0];
				fldid=nb[1];
				seluser=nb[2];
				//alert(op);
				
				var boolop=document.getElementById(selcheck).checked ;
				//alert(boolop);
				var opvalue="N";
				
				if(boolop==true){
					opvalue="Y"
					
				}
				
				 $.post("controller/utility.php", {act: 'saveuserfolderroles', folderid:fldid, seluser: seluser, op: op, opvalue: opvalue },
						   function (data) {

							   if (data.length > 0) {
								  // alert(data);
								  // loadselecteddeptcombo();
								  //window.location="index.php";
								  //document.getElementById("divroles").innerHTML="<b>Permissions</b><hr>"+data+"<br><br>";
								 // document.getElementById("spbut").style.display="block";
								  
								 
							   }

							});
				
			}
			  	
		</script>
	</body>
</html>
