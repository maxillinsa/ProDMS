
<?php 

if (is_dir("install")){
	header("location: install/index.php"); 
	exit;
	
}
else{
	

?>



<!DOCTYPE html>
<?php 




include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$unitid=returnQueryValue("select unitid from pro_users where usern='$curuser'","unitid");
//$ownerdept=returnQueryValue("select deptid from pro_users where id=$unitid","deptid");
						//	$compid=returnQueryValue("select compid from pro_users where id=$ownerid","compid");

	$userid=returnQueryValue("select id from pro_users where usern='$curuser'","id");
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

					

						<div class="row">
						
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								
								<button class="btn btn-white btn-info btn-bold btn-sm radius-3" onclick="startexplore();">
												<i class="ace-icon fa bigger-200"><img src="img/navigate.png" style="width:100px;height:100px;"></i>
												
												
												<b>Explore Documents </b>
											</button>
											
											<button class="btn btn-white btn-warning btn-bold btn-sm radius-3" onclick="search();">
												<i class="ace-icon fa bigger-200"><img src="img/search.png" style="width:100px;height:100px;"></i>
												
												
												<b>Search Documents</b>
											</button>
											
											<button class="btn btn-white btn-default btn-bold btn-sm radius-3" onclick="startnewfile();">
												<i class="ace-icon fa bigger-200"><img src="img/adddoc.png" style="width:100px;height:100px;"></i>
												
												
												<b>Add Documents</b>
											</button>

									
										</button>
										<hr>
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>

									Welcome to
									<strong class="green">
										ProDMS
										<small>(v1.0)</small>
									</strong>. An improved and secure documents caging technology for corporate entities.
									
									
	
								</div>
								<?php 
								$qryc="select * from pro_file_discuss order by id desc limit 0,4";
								$rsc=mysql_query($qryc);
								$nmc=mysql_num_rows($rsc);
								if($nmc>0){
								?>
								
								<div class="alert alert-info" style="font-size:11px;">
											
											

											<?php 
											include("controller/filehandler.php");
											echo "<strong class='green' style='font-size:18px;'>Discussions</strong><br>";
											$rdc=mysql_fetch_assoc($rsc);
											do{
												$userid=$rdc['userid'];
												$fileid=$rdc['fileid'];
												
												$filename=returnQueryValue("select realname from pro_documents where id=$fileid","realname");
												$fileImage="img/".get_file_image($filename);
												
												$fullname=returnQueryValue("select Fullname from pro_users where id=$userid","Fullname");
												$comment=$rdc['comment'];
												echo "<img src='$fileImage' style='height:20px;width:20px;'> On $filename:<b> ".$fullname."</b> says <a href='discuss.php?id=$fileid'>". $comment."</a><br>";
												
											}
											while($rdc=mysql_fetch_assoc($rsc));
											
											?>
											
										</div>
									</div><!-- /.col -->
							<?php 
								}
							?>
							
							
							
							<?php 
								$qrycw="select * from pro_user_tasks where userid=$userid order by id desc limit 0,4";
								//echo $qrycw; exit;
								$rscw=mysql_query($qrycw);
								$nmcw=mysql_num_rows($rscw);
								if($nmcw>0){
								?>
								
								<div class="alert" style="font-size:11px;">
											
											

											<?php 
											//include("controller/filehandler.php");
											echo "<hr><strong class='green' style='font-size:18px;'>Pending Workflow Tasks</strong><br>";
											$rdcw=mysql_fetch_assoc($rscw);
											do{
												$taskid=$rdcw['taskid'];
												$fileid=$rdcw['fileid'];
												$taskname=returnQueryValue("select taskname from pro_workflow_def where id=$taskid","taskname");
												$filename=returnQueryValue("select realname from pro_documents where id=$fileid","realname");
												$fileImage="img/".get_file_image($filename);
												
												$fullname=returnQueryValue("select Fullname from pro_users where id=$userid","Fullname");
												
												echo "<a href='mytickets.php'><img src='img/gear.png' style='height:30px;width:30px;'> <b> Perform: ".$taskname."</b> on $filename </a><br>";
												
											}
											while($rdcw=mysql_fetch_assoc($rscw));
											
											?>
											
									
									</div><!-- /.col -->
							<?php 
								}
							?>
							<hr>
							
							
								
								<div class="well well-lg">
											<h4 class="blue">Public Folders</h4>
											
											<?php 
											$qry="select * from pro_folder where public='Y' and unit=$unitid";
											$res=mysql_query($qry);
											$nm=mysql_num_rows($res);
											if($nm>0){
												$rd=mysql_fetch_assoc($res);
												do{
													$flidx=$rd['id'];
													$parentidx=$rd['parentfolder'];
													if($parentidx>0){
														
														$pfname=returnQueryValue("select name from pro_folder where id=$parentidx","name");
														$fname=$rd['name'];
														echo "<a href='explorer_folder.php?id=$flidx'><small><i class='ace-icon fa'><img src='img/share.png' style='width:40px;height:40px;'></i>"."&nbsp;../".$pfname."/".$fname."</small></a><hr>";
														
														
									
									
								
														
													}else{
														
														$fname=$rd['name'];
														echo "<a href='explorer_folder.php?id=$flidx'><small><i class='ace-icon fa'><img src='img/share.png' style='width:40px;height:40px;'></i>"."&nbsp;../".$fname."</small></a><hr>";
														
													}
													
													
												}
												while($rd=mysql_fetch_assoc($res));
												
												
											}
											else{
												
												echo "Public folders placeholder";
											}
											
											
											?>
										</div>

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
	
	function startexplore(){
		window.location="explore_company.php";
	}
	
	function startnewfile(){
		window.location="newjob.php";
	}
	
	function search(){
		window.location="managefiles.php";
	}
			
			  	
		</script>
	</body>
</html>



<?php 

}
?>