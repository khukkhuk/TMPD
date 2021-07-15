<?php 
    require_once('../code/class.sql.php'); 
    $sql = new sql(); 
	$d_id = $_GET['d_id'];
	$id = $_GET['id'];
	$status = $_GET['status'];
	$sql->update('step_detail',"document_status ='$status' ","step_detail_id='$d_id'" );
	echo "<script>alert('Success')</script>";
	echo "<meta http-equiv='refresh' content='0;url=manage_document.php?id=$id'>";

 ?>