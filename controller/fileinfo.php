
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$fileid=$_GET['id'];

	//echo $id;exit;
	//echo $memid;exit;
?>


			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						
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
								Process Upload
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									File &amp; Process
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
							<?php 
							//$fileid
							include("controller/filehandler.php");
							$rd=mysql_fetch_assoc(mysql_query("select * from pro_documents where id=$fileid"));
							$fname=$rd['name'];
							$realname=$rd['realname'];
							$ext=$rd['ext'];
							$usefilename="vault/".$fname;
							//echo getFileSize($usefilename);exit;
							$filesize=formatBytes(getFileSize($usefilename));
							$fileMime=getFileMimeType($usefilename);
							$dateCreated=$rd['date_created'];
							$fileImage="img/".get_file_image($usefilename);
							?>
							</div><!-- /.col -->
							
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="clearfix">
									<div class="pull-left alert alert-success no-margin alert-dismissable">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-umbrella bigger-120 blue"></i>
										Move file to the right destination. Trash file if not needed.
									</div>

									
								</div>

								<div class="hr dotted"></div>

								<div>
									<div id="user-profile-1" class="user-profile row">
										<div class="col-xs-12 col-sm-3 center">
											<div>
												<span class="profile-picture">
													<img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo $fileImage; ?>" />
												</span>

												<div class="space-4"></div>

												<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
													<div class="inline position-relative">
														<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
															
															
															<span class="white"><?php echo $realname; ?></span>
														</a>

														<ul class="align-left dropdown-menu dropdown-caret dropdown-lighter">
															<li class="dropdown-header"> Action </li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-trash-o green"></i>
&nbsp;
																	<span class="green">Trash</span>
																</a>
															</li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-share red"></i>
&nbsp;
																	<span class="red">Share</span>
																</a>
															</li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-lock grey"></i>
&nbsp;
																	<span class="grey">Lock</span>
																</a>
															</li>
														</ul>
													</div>
												</div>
											</div>

											<div class="space-6"></div>

											<div class="profile-contact-info">
												

												<div class="space-6"></div>

												<div class="profile-social-links align-center">
													<a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
														<i class="middle ace-icon fa fa-facebook-square fa-2x blue"></i>
													</a>

													<a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
														<i class="middle ace-icon fa fa-twitter-square fa-2x light-blue"></i>
													</a>

													<a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
														<i class="middle ace-icon fa fa-pinterest-square fa-2x red"></i>
													</a>
												</div>
											</div>

											<div class="hr hr12 dotted"></div>

											

											<div class="hr hr16 dotted"></div>
										</div>

										<div class="col-xs-12 col-sm-9">
											<div class="center">
												

												
												<button class="btn btn-app btn-danger btn-sm">
											<i class="ace-icon fa fa-trash-o bigger-200"></i>
											Delete
										</button>

												<button class="btn btn-app btn-pink btn-sm">
											<i class="ace-icon fa fa-share bigger-200"></i>
											Share
										</button>

										<button class="btn btn-app btn-inverse btn-sm">
											<i class="ace-icon fa fa-lock bigger-200"></i>
											Lock
										</button>
											</div>

											<div class="space-12"></div>

											<div class="profile-user-info profile-user-info-striped">
												<div class="profile-info-row">
													<div class="profile-info-name"> Document Name </div>

													<div class="profile-info-value">
														<span class="editable" id="username"><?php echo $realname; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Document File Size </div>

													<div class="profile-info-value">
														<span class="editable" id="username"><?php echo $filesize; ?></span>
														
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Extention </div>

													<div class="profile-info-value">
														<span class="editable" id="age"><?php echo $ext; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Mime Type </div>

													<div class="profile-info-value">
														<span class="editable" id="signup"><?php echo $fileMime; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Date Uploaded </div>

													<div class="profile-info-value">
														<span class="editable" id="login"><?php echo $dateCreated; ?></span>
													</div>
												</div>

												<div class="profile-info-row">
													<div class="profile-info-name"> Document Icon </div>

													<div class="profile-info-value">
														<span class="editable" id="about"><?php echo "<img src='".$fileImage."' width='50' height='50' >"; ?></span>
													</div>
												</div>
												<div class="profile-info-row">
													<div class="profile-info-name">  </div>

													<div class="profile-info-value">
													
														<div class="col-sm-10">
										<div class="tabbable">
											<ul class="nav nav-tabs" id="myTab">
												<li class="active">
													<a data-toggle="tab" href="#home">
														<i class="green ace-icon fa fa-bookmark bigger-120"></i>
														Tag Document
													</a>
												</li>

												<li>
													<a data-toggle="tab" href="#messages">
														Document Metadata
														<span class="badge badge-danger">*</span>
													</a>
												</li>
												
													<li>
													
													<a data-toggle="tab" href="#escallate">
													<i class="green ace-icon fa fa-external-link bigger-120"></i>
														Workflow
														
														
													</a>
												</li>

												
											</ul>

											<div class="tab-content">
												<div id="home" class="tab-pane fade in active">
													<p><div>
															<label for="form-field-select-1"><b>Document Record ID</b></label>

														<input type="text" id="txtfileid" placeholder="Unique Identifier no. (Optional)" class="form-control" />
														
														</div>

														
														<div>
															<label for="form-field-select-2"><b>Department</b></label>

															<select class="form-control" name="cmdept" id="cmdept" onchange="loadUnit();">
														
															</select>
														</div>

														

														<div>
															<label for="form-field-select-3"><b>Unit</b></label>

															<br />
															<select class="chosen-select form-control" id="cmunit" data-placeholder="Choose a unit..." onchange="loadschema1();">
																
															</select>
														</div>
														
														<div>
															<label for="form-field-select-3"><b>Folder</b></label>

															<br />
															<select class="chosen-select form-control" id="cmfolder" data-placeholder="Choose a folder..."  onchange="loadschema();">
																
															</select>
														</div>
														
														</p>
												</div>

												<div id="messages" class="tab-pane fade">
													<p><div id="fileschemadetails">
															
															
															</div></p>
												</div>
												
												<div id="escallate" class="tab-pane fade in active">
													<p>
													Escalation here
													</p>
												</div>

												
											</div>
										</div>
									</div><!-- /.col -->

														
								<!-- /.span -->
								

														
													</div>
												</div>
											</div>

										<div id="fileschemadetailsbuttons">
															<br>
															<button class="btn btn-primary" onclick="saveFile();">Archive File</button>&nbsp;&nbsp;
															
															<button class="btn btn-danger">Discard File</button>
															</div>
										
										</div>
										</div>
									</div>
								</div>

							
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					
					
						
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
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		

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
					alert(response);
					$('#selectfile').val('');
				}
			});
		}
	}
	
	loadDept();
				function loadDept(){
					
					 $.post("controller/utility.php", {act: 'loaddept' },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				}
				
				  function loadcountry(dt) {

                var dropdownList = document.getElementById("cmdept");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cmdept").append(option);
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
                        $("#cmdept").append(option);
                    }
                }



            }
			
			function loadUnit(){
				var dept = document.getElementById("cmdept").value;
				//alert(dept);
				 $.post("controller/utility.php", {act: 'loaddeptunit', dept: dept },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry2(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
			
			 function loadcountry2(dt) {

                var dropdownList = document.getElementById("cmunit");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cmunit").append(option);
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
                        $("#cmunit").append(option);
                    }
                }



            }
			var fieldos="";
			
			function loadschema1(){
				var cmunit = document.getElementById("cmunit").value;
				loadFolder(cmunit);
				
			}
			
			function loadschema(){
				var cmfolder = document.getElementById("cmfolder").value;
				document.getElementById("fileschemadetails").innerHTML="";
				 $.post("controller/utility.php", {act: 'loadschemabyunit', cmfolder: cmfolder },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
								   var nb=data.split("|");
									document.getElementById("fileschemadetails").innerHTML=nb[0];
									fieldos=nb[1];
									//alert(fieldos);
									//loadFolder(cmunit);
							   }

							});
				
			}
			
			//cmfolder
			
			function loadFolder(unitid){
					 $.post("controller/utility.php", {act: 'loadfoldercmb', unitid: unitid },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									loadcountry3(data)
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
				
			}
			
			
			
			 function loadcountry3(dt) {

                var dropdownList = document.getElementById("cmfolder");
                clearlistbox(dropdownList);
                var option = new Option("", "");
                /// jquerify the DOM object 'o' so we can use the html method
                $(option).html("");
                $("#cmfolder").append(option);
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
                        $("#cmfolder").append(option);
                    }
                }



            }
			
			var fileid="<?php echo $fileid; ?>";
			
			function saveFile(){
				
				//alert(fieldos);
				//txtfileid,cmdept,cmunit,cmfolder
				var txtfileid = document.getElementById("txtfileid").value;
				var cmdept = document.getElementById("cmdept").value;
				var cmunit = document.getElementById("cmunit").value;
				var cmfolder = document.getElementById("cmfolder").value;
				
				if(txtfileid==""){
					msgError("Please specify Document Number");return;
				}
				
				if(cmdept==""){
					msgError("Destination department is required");return;
				}
				
				if(cmunit==""){
					msgError("Unit is required");return;
				}
				
				if(cmfolder==""){
					msgError("Folder is required");return;
				}
				
				
				
				if(fieldos==""){
					
					 $.post("controller/filesystem.php", {act: 'createfile', txtfileid: txtfileid,cmdept:cmdept,cmunit:cmunit,cmfolder:cmfolder, fileid: fileid },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									
									
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
					
					
				}
				
				else{
					
					var nb=fieldos.split(",");
					var fieldx;
					var packeddata="";
					for (var i = 0; i < nb.length; i++) {
					   //alert(nb[i]);
					   if(nb[i]==""){}else{
						   packeddata=packeddata+nb[i]+"="+document.getElementById(nb[i]).value+";";
						   
					   }
					   
					}
				//	alert(packeddata);
					
					 $.post("controller/filesystem.php", {act: 'createfilewithdata', txtfileid: txtfileid,cmdept:cmdept,cmunit:cmunit,cmfolder:cmfolder, packeddata:packeddata, fileid: fileid },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									
									window.location="explorer_folder.php?id="+cmfolder;
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
						
					}
				
			}
			
			
			
			  	
		</script>
	</body>
</html>
