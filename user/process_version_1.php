<?php
require_once('top.php');
?>
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> 
	<center><h4>เสนอความต้อง จัดซื้อ</h4></center> 

	<?php
	$id = $_GET['id']; 
	$rsActivity = $sql->select('*','activity',"activity_id='$id'");
	$rwActivity = $rsActivity->fetch_assoc();
	$version = $rwActivity['version'];
	$step = $rwActivity['step'];
	$type = $rwActivity['type'];
	if($step=="0"){
		$step=101;
	}
	$rsSDetail = $sql->select('*','step_detail',"step = '$step' AND version='$version'"); 
	
	?>
<style type="text/css">
	table thead th{
		
	}
	input[type=text]{
	    padding: 5px 10px;
	    border-radius: 4px;
	    border-width: 1px;
	    background-color: #373737;
	    border-color: black;

	    border-style: solid;
	}
</style>



	<table class="table table-striped" style="margin-left:5%;width: 90%;text-align: center">

	    <tr>
	      <th colspan>ไฟล์เอกสารที่เกี่ยวข้อง</th>
	      <th colspan>เพิ่มเอกสาร</th>
	    </tr>

	    	<?php while($rwSDetail = $rsSDetail->fetch_assoc()){ ?>
	    		<tr>
		      			<td><a href="../upload_file/<?php echo $rwSDetail['document_name']; ?>">Download</a></td> 
		  				<td>

	    				 
	    				<form method="post" enctype="multipart/form-data" id="frm_img" name="frm_img">
	    					<input type="hidden" name="version" value="<?php echo $version; ?>">
	    					<input type="hidden" name="activity_id" value="<?php echo $id; ?>">
	    					<input type="hidden" name="step" value="<?php echo $step; ?>">
	    					<input type="file" name="upload">
	    					<input type="submit" name=""> 
		  				</form>
		  			</td>	
	  			</tr>
	  			
	  		<?php } ?>


	  <?php 
	  $rsStepDetail = $sql->select('*','step_detail','step="$step" AND version="version"');
	  $rwStepDetail = $rsStepDetail->fetch_assoc();
	  $num1 = 1;
	  $num2 = 5; ////////variable for testing
	  if($rwStepDetail!=Null){
	  	$num1 = $rwStepDetail->num_rows;
	  }


	  $rsCheckPass = $sql->select('*','activity_detail','activity_id="$activity_id" AND step="$step" AND check_document="pass"');
	  $rwCheckPass = $rsCheckPass->fetch_assoc();
	  if($rwCheckPass!=Null){
	  	$num2 = $rwCheckPass->num_rows;
	  }

	  if($num1 >= $num2)
	  { ?>
	  <thead>
	  	<td colspan="2"><button class="btn btn-success">ส่งเอกสาร</button></td>
	  </thead>
	<?php } ?>
	</table> 

<?php
	require_once('../bottom.php');
?> 

