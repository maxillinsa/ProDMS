
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$fileid=$_GET['id'];

							include("controller/filehandler.php");
							$rd=mysql_fetch_assoc(mysql_query("select * from pro_documents where id=$fileid"));
							$fname=$rd['name'];
							$realname=$rd['realname'];
							$ext=$rd['ext'];
							$docid=$rd['docno'];
							$usefilename="vault/".$fname;
							//echo getFileSize($usefilename);exit;
							$filesize=formatBytes(getFileSize($usefilename));
							$fileMime=getFileMimeType($usefilename);
							$dateCreated=$rd['date_created'];
							$fileImage="img/".get_file_image($usefilename);
							$folderid=$rd['folderid'];
							$foldername=returnQueryValue("select name from pro_folder where id=$folderid","name");
							$ownerid=$rd['userid'];
							$ownerunit=returnQueryValue("select unitid from pro_users where id=$ownerid","unitid");
							$ownerdept=returnQueryValue("select deptid from pro_users where id=$ownerid","deptid");
							$compid=returnQueryValue("select compid from pro_users where id=$ownerid","compid");
							
							$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
							$deptname=returnQueryValue("select name from pro_departments where id=$ownerdept","name");
							$unitname=returnQueryValue("select name from pro_dept_units where id=$ownerunit","name");
							$ownername=returnQueryValue("select Fullname from pro_users where id=$ownerid","Fullname");
							$ownername=$compname."/".$deptname."/".$unitname."/".$ownername;
							
							$docrecnolabel=getParamValue("docrecnolabel");
							$allowedlist=getParamValue("mime_supported");

	
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
							<li class="active"></li>
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
								Replace File
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Upload replacement
								</small>
							</h1>
						</div><!-- /.page-header -->
							<div>
												<center><span class="profile-picture">
													<img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?php echo $fileImage; ?>" style="height:100px;width:100px;" />
												</span>

												<div class="space-4"></div>

												<div>
													<div class="inline position-relative">
														<a href="fileinfo.php?id=<?php echo $fileid; ?>" target="_blank">
															
															
															<span> <?php echo $realname." - <b>".$docid."</b>"; ?></span>
														</a>

													</div>
												</div>
												</center>
												
											</div>
											

						<div class="row">
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
							
								
								

								<div class="row">
									<div class="space-6"></div>

									<div class="col-sm-7 infobox-container">
										
									

									

										<div class="space-6"></div>
										


					<div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
	<div id="drag_upload_file">
	<span class="bigger-120 bolder"><i class="ace-icon fa fa-caret-right red"></i> Replace with</span> a new file
				<span class="smaller-80 grey">(or click on "Select file")</span> <br />
				<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>
		
		<p><input type="button" value="Select File" onclick="file_explorer();"></p>
		<input type="file" id="selectfile">
		<input type="hidden" id="fileid" name="fileid" value="<?php echo $fileid; ?>">
	</div>
</div>
										
									</div>
									
								
									
									

									<div class="vspace-12-sm"></div>

								</div><!-- /.row -->

							</div><!-- /.col -->
						
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
	var fileid="<?php echo $fileid; ?>";
	var allowedlist="<?php echo $allowedlist; ?>";
			
			var fileobj;
	function upload_file(e) {
		e.preventDefault();
		fileobj = e.dataTransfer.files[0];
		ajax_file_upload(fileobj);
	}

	function file_explorer() {
		document.getElementById('selectfile').click();
		document.getElementById('selectfile').onchange = function() {
			////////////
			var fullPath = document.getElementById('selectfile').value;
			if(allowedlist==""){}else{
				if (fullPath) {
					var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
					var filename = fullPath.substring(startIndex);
					if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
						filename = filename.substring(1);
					}
					
					fileextention= filename.split('.')[1];
					if (allowedlist.indexOf(fileextention) !=-1) {
							//alert("exist");
							//foundLinks++;
					}
					else{
						
						msgError("File Extention not support<br>Contact your system administrator");
						return;
						
					}
					
					//alert(fileextention);return;
				}
			}
		//////////////
		
		    fileobj = document.getElementById('selectfile').files[0];
			ajax_file_upload(fileobj);
		};
	}

	function ajax_file_upload(file_obj) {
		document.getElementById("drop_file_zone").innerHTML="<b>Uploading...<b>";
		if(file_obj != undefined) {
		    var form_data = new FormData();                  
		    form_data.append('file', file_obj);
			$.ajax({
				type: 'POST',
				url: 'upload2.php?fileid='+fileid,
				contentType: false,
				processData: false,
				data: form_data,
				success:function(response) {
					//alert(response);
					if(response=="1g"){
						msgError("Document size not permitted<br>Contact your system administrator");
						return;
					}
					
					else{
						window.location="managefiles.php";
					}
				}
			});
		}
	}
			
			  	
		</script>
	</body>
</html>
