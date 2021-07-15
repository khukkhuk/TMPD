<?php 
	$sMessage = $_POST['LineMessage']; 
	$target=$_POST['linetoken']; 
	$sMessage = "ทดสอบการเชื่อมต่อ";
	require_once('../line_message.php');
	echo "<script>alert('ส่งข้อความทดสอบแล้ว')</script>"; 
 ?>