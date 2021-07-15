<?php
require_once('top.php');
?>
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> 

	<?php
	$id = $_GET['id']; 
	$rsStep = $sql->select('*','step left join activity_type on step.type_id = activity_type.activity_type_id',"step_id ='$id' ");
	$rwStep = $rsStep->fetch_assoc();
	$step = $rwStep['step'];
	$version = $rwStep['version']; 
	$type= $rwStep['type']; 

	$rsSDetail = $sql->select('*','step_detail',"step = '$step' AND version='$version'"); 
	
	?>

	<center><h4>ประเภท <?php echo $type; ?></h4><h4> รหัสขั้นตอน <?php echo $step; ?></h4><h4>เวอร์ชั่น <?php echo $version; ?></h4></center> 
<style type="text/css">
	table thead th{
		
	}
	 
</style>



	<table class="table table-striped" style="margin-left:5%;width: 90%;text-align: center">
	<thead>
		<tr>
			<td colspan="4">ไฟล์ที่เกี่ยวข้อง</td>
		</tr>
	    <tr>
	      <th>ชื่อไฟล์</th>
	      <th>ดาวน์โหลด</th>
	      <th>สถานะ</th>
	      <th></th>
	    </tr>
	    	<?php 
	    	if($rsSDetail->num_rows>0){
	    	while($rwSDetail = $rsSDetail->fetch_assoc()){ ?>
	    		<tr>
		      			<td><?php echo $rwSDetail['document_name'];?></td> 
		  				<td><a href="../file_upload/<?php echo $rwSDetail['document_name']; ?>"><i class="fas fa-arrow-alt-circle-down"></i></a></td>
		  				<?php 
		  					$step_id = $rwSDetail['step_detail_id'];
		  				if($rwSDetail['document_status']=="off"){
		  					echo "<td><i style='color:red' class='fas fa-circle'></i></td><td><a href='status_document.php?d_id=$step_id&&status=on&&id=$id'>เปิดใช้งานเอกสาร</a></td>";
		  				}else{
		  					echo "<td><i style='color:green' class='fas fa-circle'></i></td><td><a href='status_document.php?d_id=$step_id&&status=off&&id=$id'>ปิดใช้งานเอกสาร</a></td>";
		  				} ?>
	  			</tr>
	  			
	  		<?php }}else{ ?>
		
		<tr><td colspan="4">ไม่พบข้อมูล</td></tr> <?php } ?>
		</thead>
		<thead>
	  	<tr><td colspan="4">
	  			<button type="button" style="margin-top:52px" class="btn btn-info" data-toggle="modal" data-target="#exampleModal1">อัพโหลดเอกสารเพิ่ม</button> 
					<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      </div>
					      <div class="modal-body">
					        <center><h2></h2>
						        <table>
						        		<tr>
						        			<form id="admin_upload">
						        			<td><input type="file" name="upload"></td>
						        			<input type="hidden" name="id" value="<?php echo $id; ?>">
						        			<input type="hidden" name="step" value="<?php echo $step; ?>">
						        			<input type="hidden" name="version" value="<?php echo $version; ?>">
						        			<!-- ระบุชื่อไฟล์<input type="text" name="name"> -->
						        			<td><input type="submit" name="btn_sub" onclick="return confirm('ยืนยันการอัพโหลดไฟล์');" value="ยืนยัน"></td></form>
						        		</tr>
						        		
						        		
								</table>
			      		  </div>
					      <div class="modal-footer">
							
					      </div>
					    </div>
					  </div>
					</div>

	  			
	  		</td>
	  	</tr>
	  </thead>
	</table> 

<?php
	require_once('../bottom.php');
?> 
