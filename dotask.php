
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$deid=$_GET['id'];
$unitid=returnQueryValue("select unitid from pro_users where usern='$curuser'","unitid");
$deptid=returnQueryValue("select deptid from pro_dept_units where id=$unitid","deptid");

$fileid=$_GET['id'];
//$company=returnQueryValue("select name from dms_companies where id=$deid","name");

	//echo $deid;
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
							<i class="ace-icon"><img src="img/gear.png" style="width:50px;height:50px;"></i>	
								Add New Task
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									
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
													<h4 class="widget-title">Assign Task</h4>

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
													
													<div>
													<p>
													<?php 
														$taskexists=recNum("select * from pro_user_tasks where fileid=$fileid");
														if($taskexists>0){
															$lasttaskid=returnQueryValue("select max(id) as ido from pro_user_tasks where fileid=$fileid","ido");
															$taskid=returnQueryValue("select taskid from pro_user_tasks where id=$lasttaskid","taskid");
															$tast_status=returnQueryValue("select done from pro_user_tasks where id=$lasttaskid","done");
															$taskname=returnQueryValue("select taskname from pro_workflow_def where id=$taskid","taskname");
															if($tast_status=="Y"){
																$tast_status="Done";
															}
															else{
																$tast_status="Pending";
															}
															
															echo "<strong style='font-size:18px;'>Current Task: <u>".$taskname."</u></strong><br>";
															echo "<strong class='green'>Status: ".$tast_status."</strong><br><br>";
															
														}
													?>
													<label for="form-field-select-2"><b>Attach a Workflow Task</b></label>

															<select class="form-control" name="cbowork" id="cbowork">
														
															</select><br>
															
															<label for="form-field-select-2"><b>Assign to User</b></label>

															<select class="form-control" name="cbouser" id="cbouser" >
														
															</select>
													</p>
															<button class="btn btn-primary" onclick="savedata();">
												<i class="ace-icon fa fa-check-square-o align-top bigger-125"></i>
												Start
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
		
		var deid="<?php echo $deid; ?>";
		
		var deptid="<?php echo $deptid;  ?>";
		var fileid="<?php echo $fileid; ?>";
		
		//var $deptid
		
		function savedata(){
			
			
			//txttask,txtdesc,txtorder
			
			var cbowork=Tvar("cbowork").value;
			var cbouser=Tvar("cbouser").value;
			
		
			
			if(cbowork==""){
				msgError("Task is required");return;
			}
			
			if(cbouser==""){
				msgError("Please specify task User");return;
			}
			
			
			
			 $.post("controller/filesystem.php", {fileid: fileid,cbowork: cbowork,act:"assigntasktouser", cbouser: cbouser },
						   function (data) {

							   if (data.length > 0) {
								   
								 //alert(data);
								   
								   if(data=="1"){
									   apprise("Workflow started and task escalated to user");
									   Tvar("cbowork").value="";
									   Tvar("cbouser").value="";
										//window.location="startworkflow.php";
								   }
								   
								   if(data=="0"){
									   msgError("Could not insert record");return;
								   }
								   
								    if(data=="exists"){
									   msgError("Record already exists");return;
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

				loadUsers();
				loadTasks();
	
			function loadUsers(){
			
					 $.post("controller/utility.php", {act: 'loaduserdept', deptid: deptid },
						   function (data) {

							   if (data.length > 0) {
								   
							
									loadcountryUser(data)
									
							   }

							});
				
				
				
			}
			
			function loadTasks(){
				
					 $.post("controller/utility.php", {act: 'loadtaskcmb', deptid: deptid },
						   function (data) {

							   if (data.length > 0) {
								   
								
									loadcountryTask(data)
									
							   }

							});				
			}
			
			
			 function loadcountryTask(dt) {

                var dropdownList = document.getElementById("cbowork");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cbowork").append(option);
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
                        $("#cbowork").append(option);
                    }
                }



            }
			
			
			
			 function loadcountryUser(dt) {

                var dropdownList = document.getElementById("cbouser");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cbouser").append(option);
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
                        $("#cbouser").append(option);
                    }
                }



            }
			
			  	
		</script>
	</body>
</html>
