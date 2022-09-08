
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$fid=$_GET['id'];
$fileid=$fid;
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
								Discuss Document
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Add Comments to Documents
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="col-sm-10">
						
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
												<div style="width:70%;margin-left:20%">
															<label for="txtcomment"><b>Write Comment</b></label>

															<textarea id="txtcomment" class="autosize-transition form-control"></textarea>
															<div style="text-align:right"><button class="btn btn-sm btn-primary" onclick="pstComment();">Post</button></div>
														</div><br>
											</div>
											<div id="divcomments">
											
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
	
function pstComment(){
	var txtcomment=Tvar("txtcomment").value;
	
	if(txtcomment==""){
		return;
	}
	
		 $.post("controller/utility.php", {act: 'comment', fileid: fileid, txtcomment: txtcomment },
						   function (data) {

							   if (data.length > 0) {
								   
								   //alert(data);
									//loadcountry3(data)
									Tvar("txtcomment").value="";
									loadComments();
								   //Tvar("responsivtablediv").innerHTML=data;
							   }

							});
	
}
loadComments();
function loadComments(){
		 $.post("controller/utility.php", {act: 'loadcomment', fileid: fileid },
						   function (data) {

							   if (data.length > 0) {
								   
								 //  alert(data);
									//loadcountry3(data)
									
								   Tvar("divcomments").innerHTML=data;
							   }

							});
	
}

function reply(userid){
	//alert(userid);
	 $.post("controller/utility.php", {act: 'getuserfullname', userid: userid },
						   function (data) {

							   if (data.length > 0) {
								   
								 //  alert(data);
									//loadcountry3(data)
									
								   Tvar("txtcomment").value="@"+data+" ";
							   }

							});
	
}
			
			  	
		</script>
	</body>
</html>
