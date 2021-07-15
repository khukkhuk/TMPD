<?php 
	ob_start();
	require_once("code/class.sql.php");
	require_once("code/class.alert.php");
	$sql = new sql();
	$alert = new alert();
	$person_id = $_GET['id'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
</head>
<body>

<style type="text/css">
	body{
		background-color: #f8f8f8;
	}
	form{
		border-radius: 9px;
		margin:24px;
		margin-top: 8%;
		background-color: #7dd2c5;
		width: 240px;
		padding: 45px;
		font-size:24px;

	}	
	input{
		margin-top: 20px
	}
	input[type="text"]{ 
		border-radius: 3px;
		border-width: 0.1px;
		padding: 3px;
		width:90%;
		text-align: center
	}
	input[type="submit"]{
		width: 100%;
		background-color:#ff9e52; 
		border:0;
		padding: 10px 0px;
		border-radius: 7px;
		color:black;
		font-size: 24px;
	}

</style>
<center>
	<form method="post">
		กรอกรหัสยืนยัน<br><input style="padding:12px;" type="text" name="password">
		<input type="hidden" name="person_id" value="<?php echo $person_id; ?>"><br>
		<input type="submit" name="btn_ok"  onclick="return confirm('ยืนยันการเปลี่ยนรหัส');"  value="ยืนยัน">	
				
	</form>
</center>
</body>
</html> 
<?php 
	if(isset($_POST['btn_ok'])){
		$person_id = $_POST['person_id'];
		$password = $_POST['password'];
		// echo $_COOKIE['secret_code'];
		if(isset($_COOKIE['secret_code'])AND($_COOKIE['secret_code'])!=''){
			if($password==$_COOKIE['secret_code']){
				$txt = "TMPD_KMUTNB";
				$sql->update("person","`password` = md5('tmpd123$txt')","person_id ='$person_id'");
				echo "<script>alert('รหัสผ่านใหม่คือ tmpd123 ')</script>";
				$alert->link(0,"index.php");
			}else{
				echo "<script>alert('รหัสยืนยันผิดพลาดกรุณาตรวจสอบอีกครั้ง')</script>";
			}
		}else{
			echo "<script>alert('เกินเวลาที่กำหนดกรุณาทำรายการใหม่')</script>";
				$alert->link(0,"index.php");
		}
	}

		
?>