
<!DOCTYPE html>
<?php include("header.php"); 
include("controller/filehandler.php");
$curuser=@$_COOKIE['curuser'];
$cid=$_GET['id'];

if($cid==""){
	
	header("location: explore_company.php");
}

$deptid=returnQueryValue("select deptid from pro_dept_units where id=$cid","deptid");
$compid=returnQueryValue("select companyid from pro_departments where id=$deptid","companyid");
$compname=returnQueryValue("select name from dms_companies where id=$compid","name");
$deptname=returnQueryValue("select name from pro_departments where id=$deptid","name");
$unitname=returnQueryValue("select name from pro_dept_units where id=$cid","name");
$unitid=	$cid;
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
							<li class="active">Folders</li>
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
								Folders
							<a href='javascript:history.back();'><button type="button" class="btn btn-purple btn-inverse btn-sm"> <i class="ace-icon fa fa-angle-double-left"></i>Back one step</button>
								</a>
								
							</h1>
						</div><!-- /.page-header -->
						
						
						
						
<p>
<span class="btn btn-white btn-info btn-bold popover-info" data-rel="popover" data-placement="bottom" title="New Folder" data-content="<b>Folder Name:</b> <input type='text' id='txtfolderinput'><br><b>Metadata:<br></b><select id='cboschema'>
<?php
$deptidx=returnQueryValue("select deptid from pro_dept_units where id=$unitid","deptid");
		$compidx=returnQueryValue("select companyid from pro_departments where id=$deptidx","companyid");
		
		//echo $compid;exit;
		$qry="select * from pro_schema where compid=$compidx order by id desc";
			$res=mysql_query($qry);
			$nm=mysql_num_rows($res);
			if($nm>0){
				$ret="";
				//echo "here";
				$rd=mysql_fetch_assoc($res);
				
				do{
					
						$prodname=$rd['name'];
							$id=$rd['id'];
								echo "<option value='$id'>$prodname</option>";
                       
				}
				
				while($rd=mysql_fetch_assoc($res));		
				
			}

 ?>
</select> <br><br><button class='btn btn-minier btn-purple' onclick='createFolderInUnit();'>Create Folder</button>"><i class="ace-icon fa fa-folder-o bigger-120 blue"></i>
												New Folder</span>
											

											
										</p>
						<h2>
							
							<?php echo "//:$compname/$deptname/$unitname"; ?>
							</h2>
						
						
						<div class="row">
				
				<?php 
				$qry="select * from pro_folder where deleted='N' and unit=$cid and parentfolder=0";
				$res=mysql_query($qry);
				$num=mysql_num_rows($res);
				if($num>0){
					
					$rd=mysql_fetch_assoc($res);
					do{
						$compid=$rd['id'];
						$cmp=$rd['name'];
						
						echo "<div class='explorer_folder' ><center><img src='img/folder.png' style='width:100px;height:100px;'><br>$cmp</center>
						<span style='font-size:9px;'><a href='javascript:explore(\"$compid\");'>Open</a> | <a href='rename_unit.php?id=$compid&pid=$cid'>Rename</a> | <a href='permissions.php?fid=$compid'>Permission</a> | <a href='javascript:deletefolder(\"$compid\")'>Delete</a></span>
						</div>";
						
					}
					while($rd=mysql_fetch_assoc($res));
				}
				
				$qry="select * from pro_documents where folderid=$cid";
				$res=mysql_query($qry);
				$num=mysql_num_rows($res);
				if($num>0){
					
					$rd=mysql_fetch_assoc($res);
					do{
						$compid=$rd['id'];
						$cmp=$rd['realname'];
						$vs =$rd['version'];
						if($vs>1){
							$vs="(v$vs)";
						}else{
							$vs="";
						}
						$fimage=get_file_image($cmp);
						$fimage=get_file_image($cmp);
						echo "<div class='explorer_folder'><center><img src='img/$fimage' style='width:100px;height:100px;'><br>$cmp $vs</center><span style='font-size:9px;'><a href='javascript:openfile(\"$compid\");'>View</a> | <a href='javascript:deletefile(\"$compid\");'>Delete</a> | <a href='fileinfo.php?id=$compid'>File Info</a></span></div>";
						
					}
					while($rd=mysql_fetch_assoc($res));
				}
				?>

								
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
		
		<script src="assets/js/bootbox.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.gritter.min.js"></script>
		<script src="assets/js/spin.js"></script>
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
<script src="func.js"></script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
		
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<script type="text/javascript">
			$('[data-rel=tooltip]').tooltip();
				$('[data-rel=popover]').popover({html:true});
				
				
		
var unitid="<?php echo $cid; ?>";

function explore(cid){
	
	//alert(cid);
	
	window.location="explorer_folder.php?id="+cid;
}

function createFolderInUnit(){
	var txtfolderinput=Tvar("txtfolderinput").value;
	var cboschema=Tvar("cboschema").value;
	if(txtfolderinput==""){return;}
	
	//alert(cboschema);return;
	
	$.post("controller/filesystem.php", {unitid: unitid,act:"createfolderinuint", txtfolderinput: txtfolderinput, cboschema: cboschema  },
						   function (data) {

							   if (data.length > 0) {
								   
								  // alert(data);
								   
								   if(data=="1"){
										window.location="managefolder.php?id="+unitid;
								   }
								   
								   if(data=="0"){
									   msgError("Could not create folder due to a critical file System error");return;
								   }
								   
								    if(data=="exists"){
									   msgError("Folder already exists");return;
								   }
								   
							   }

							});
	
}


function deletefile(fid){
	//alert(fid);
	
	r = apprise("Do you really want to delete this document?", { 'verify': true }, function (r) {
            if (!r) {
                //alert("No");
				return;
            }
            else {
				$.post("controller/filesystem.php", {act: 'deletefileapi', fid: fid},
						   function (data) {

							   if (data.length > 0) {
								   if(data=="ACCESSDENIED"){
									   apprise("Error: Access denied");return;
								   }
								   
								    if(data=="1"){
									   location.reload();
								   }
								 
									  
								  
									
								  
							   }

							});
			}
			
			});
	
}

function deletefolder(fid){
	
	r = apprise("Do you really want to delete this folder?", { 'verify': true }, function (r) {
            if (!r) {
                //alert("No");
				return;
            }
            else {
				$.post("controller/filesystem.php", {act: 'deletefolderapi', fid: fid},
						   function (data) {

							   if (data.length > 0) {
								   if(data=="ACCESSDENIED"){
									   apprise("Error: Access denied");return;
								   }
								   
								    if(data=="1"){
									   location.reload();
								   }
								 
									  
								  
									
								  
							   }

							});
			}
			
			});
	
}

function openfile(cid){
		
	$.post("controller/filesystem.php", {act:"getfilepermission",cid:cid    },
						   function (data) {

							   if (data.length > 0) {
								   //alert(data);
								   if(data=="Y"){
									   window.location="viewer.php?id="+cid;
								   }
								   else{
									   msgError("<font style='font-size:18px'>Access denied<font><br>You do not have access to 'read' file");return;
								   }
								
								   
							   }

							});
}

			
			  	
		</script>
	</body>
</html>
