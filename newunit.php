
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$deid=$_GET['deid'];
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
							<li class="active">Organization</li>
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
								Add Workspace
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
													<h4 class="widget-title">Create Workspace</h4>

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
													<label for="form-field-select-1"><b>Unit *</b></label>

														<input type="text" id="txtunit" placeholder="" class="form-control" />
														
														</div>
														
														
														<div>
															<label for="form-field-select-1"><b>Short Code *</b></label>

														<input type="text" id="txtshortcode" placeholder="Short Description e.g FC for Finance" class="form-control" />
														
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
		
		var deid="<?php echo $deid; ?>";
		
		function savedata(){
			
			
			//txtdept,txtshortcode
			
			var txtunit=Tvar("txtunit").value;
			var txtshortcode=Tvar("txtshortcode").value;
		
			
			if(txtunit==""){
				msgError("Department Name is required");return;
			}
			
			if(txtshortcode==""){
				msgError("Department short code is required");return;
			}
			
			 $.post("controller/utility.php", {txtunit: txtunit,txtshortcode: txtshortcode,act:"saveunit", deid: deid  },
						   function (data) {

							   if (data.length > 0) {
								   
								   
								   
								   if(data=="1"){
										window.location="units.php";
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
			
			  	
		</script>
	</body>
</html>
