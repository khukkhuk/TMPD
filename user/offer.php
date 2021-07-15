<?php
require_once('top.php');
?>
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> 
	<center><h4>เสนอความต้อง จัดซื้อ</h4></center> 

	<?php 

	$type = $_GET['type'];
    $version = $_SESSION['type'][$type];
	$step = $type."01";
	$rsSDetail = $sql->select('*','step_detail',"step = '$step' AND version='$version'"); 
	

	?>
<style type="text/css">
	table thead th{
		
	}
	input[type=text]{
	    padding: 5px 10px;
	    border-radius: 4px;
	    border-width: 1px;
	    background-color: ##373737;
	    border-color: black;

	    border-style: solid;
	}
</style>  
<button style="border:none;background-color:white;">คลิ๊กที่นี่ เพื่อยืนยันการเสนอความต้องการ</button>
<form id="frm" method="POST">
	<table class="table table-striped" style="margin-left:5%;width: 90%;text-align: center">

	  <thead>
	    <tr>
	      <th colspan>ไฟล์เอกสารที่เกี่ยวข้อง</th>
	      <th colspan>เพิ่มเอกสาร</th>
	    </tr>
	    <tr>
	    	<?php while($rwSDetail = $rsSDetail->fetch_assoc()){ ?>
	    		<tr>
	      			<td><a href="../upload_file/<?php echo $rwSDetail['document_name']; ?>">Download</a></td> 
	  				<form id="form<?php?>"><td><input type="file" name="upload"></td></form>
	  			</tr>
	  		<?php } ?>
	    </tr>
	   <tr>
	   </tr>
	  </thead>
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
	</form> 
<?php
	require_once('../bottom.php');
?> 