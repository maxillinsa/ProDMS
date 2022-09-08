
<!DOCTYPE html>
<?php include("header.php"); 
$curuser=@$_COOKIE['curuser'];
$unitid=returnQueryValue("select unitid from pro_users where usern='$curuser'","unitid");
$qry="select distinct CAST(date_created AS DATE) AS createdate from pro_documents where folderid in (select id from pro_folder where unit=$unitid)";	

	//select distinct CAST(date_created AS DATE) AS createdate, id as folderid from pro_documents where folderid in (select id from pro_folder where unit=1)echo $qry."<br>";
	//echo $qry;exit;
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
								Start Workflow
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
				
				<div class="col-sm-12">
										<div class="widget-box widget-color-blue2">
											<div class="widget-header" style="margin-bottom: 5px;">
												<h4 class="widget-title lighter smaller">Select a document to continue</h4>
											</div>
												<div  style="margin-left:10px;">
												<button type="button" class="btn btn-white btn-primary" onclick="refreshpage();" style="margin-left:3px;">
																				<i class="ace-icon glyphicon glyphicon-refresh icon-on-right bigger-110"></i>
																			</button>
																
																
												<button type="button" class="btn btn-white btn-primary" onclick="discuss();"><i class="ace-icon fa fa-comments icon-on-right bigger-110"></i> Start Workflow</button>
												
									</div>
									<br>

											<div class="widget-body">
								
												<div id="jstree">
    <!-- in this example the tree is populated from inline HTML -->
										<?php 
										//echo $qry;exit;
										$res=mysql_query($qry);
										$nm=mysql_num_rows($res);
										if($nm>0){
											include("controller/filehandler.php");
											//echo $nm."<br>";exit;
											$rd=mysql_fetch_assoc($res);
											do{
												echo "<ul><li>".$rd['createdate'];
												//$folderid=$rd['folderid'];
												$ddate=$rd['createdate'];
												$qrx="select * from pro_documents where CAST(date_created AS DATE)='$ddate';";
												//echo $qrx."<br>";
												$resx=mysql_query($qrx);
												$nmx=mysql_num_rows($resx);
												if($nmx>0){
													$chnode=0;
													$rdx=mysql_fetch_assoc($resx);
													echo "<ul>";
													do{
														$fileid=$rdx['id'];
														$chnode=$chnode+1;
														$fileImage="img/tn_".get_file_image($rdx['realname']);
														echo "<li id='fins_$fileid'  data-jstree='{ \"icon\" : \"$fileImage\" }'><font style='font-size:18px'>".$rdx['realname']."</font></li>";
													}
													while($rdx=mysql_fetch_assoc($resx));
													echo "</ul>";
												}
												
												
												
												echo "</li></ul>";
											}
											while($rd=mysql_fetch_assoc($res));	
																					
											
										}
										
										
										?>
										
									
												 
											  </div>
											 
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

	
  <!-- 5 include the minified jstree source -->
  <script src="tools/dist/jstree.min.js"></script>
  
   <script>
   
   var selectedfile="";
   var curfile=0;
  $(function () {
    // 6 create an instance when the DOM is ready
    $('#jstree').jstree();
    // 7 bind to events triggered on the tree
    $('#jstree').on("changed.jstree", function (e, data) {
      console.log(data.selected);
	 // alert(data.selected);
	  selectedfile=String(data.selected);
    });
    // 8 interact with the tree - either way is OK
    $('button').on('click', function () {
      $('#jstree').jstree(true).select_node('child_node_1');
      $('#jstree').jstree('select_node', 'child_node_1');
      $.jstree.reference('#jstree').select_node('child_node_1');
    });
  });
  </script>
  
		
		<script type="text/javascript">
		
	//	loadCompanies()
	
function loadCompanies(){
	
	//divres
	
	
	 $.post("controller/utility.php", {act: 'loadcompanycmb' },
						   function (data) {

							   if (data.length > 0) {
								   //alert(data);
								  
									
								   //loadcountry(data);
							   }

							});
}

function deletefile(){
	if(selectedfile==""){
		return;
	}
	//alert(selectedfile);
	var str ="";
	str = selectedfile;
	 var res = str.substring(0, 4);
	//alert(res);
	
	if(res=="fins"){
		//str=str.substring(3,1);
		str=replaceAll(selectedfile,"fins_","");
	var iox=deleteFileApi(str);
		
	}
	
}

function deleteFileApi(id){
		$.post("controller/filesystem.php", {act: 'getfilepermissionWithOp',op:"candelete",cid: id },
						   function (data) {

							   if (data.length > 0) {
								   //alert(data);
								  
									window.location="deletefile.php?fid="+id;
								   //loadcountry(data);
							   }

							});
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function searchFile(){
	var txtsearch=Tvar("txtsearch").value;
	var cbolimit=Tvar("cbolimit").value;
	if(txtsearch==""){return;}
		$.post("controller/filesystem.php", {act: 'searchfile',txtsearch:txtsearch, cbolimit: cbolimit},
						   function (data) {

							   if (data.length > 0) {
								  Tvar("jstree").innerHTML="<div style='padding-left:20px;'>"+data+"</div>";
							   }

							});
	
}

function fileinfo(){
	
	if(selectedfile==""){
		return;
	}
	//alert(selectedfile);
	var str ="";
	str = selectedfile;
	 var res = str.substring(0, 4);
	//alert(res);
	
	if(res=="fins"){
		//str=str.substring(3,1);
		str=replaceAll(selectedfile,"fins_","");
		window.location="fileinfo.php?id="+str;
		
	}
	
}

function organize(){
	if(selectedfile==""){
		return;
	}
	//alert(selectedfile);
	var str ="";
	str = selectedfile;
	 var res = str.substring(0, 4);
	//alert(res);
	
	if(res=="fins"){
		//str=str.substring(3,1);
		str=replaceAll(selectedfile,"fins_","");
		window.location="organize.php?id="+str;
		
	}
	
	
	
}

function discuss(){
	
	if(selectedfile==""){
		return;
	}
	//alert(selectedfile);
	var str ="";
	str = selectedfile;
	 var res = str.substring(0, 4);
	//alert(res);
	
	if(res=="fins"){
		//str=str.substring(3,1);
		str=replaceAll(selectedfile,"fins_","");
		window.location="dotask.php?id="+str;
		
	}
	
	
}



function refreshpage(){
	location.reload();
}


	
			

			
			  	
		</script>
	</body>
</html>
