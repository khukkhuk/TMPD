<?php
	require_once('code/class.sql.php');
	$sql = new sql();
	// echo print_r($_REQUEST);

	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$title = $_POST['title'];
	$email = $_POST['email'];

	$person_id = $_POST['person_id'];
	$pass = $_POST['pass'];
	$passcon = $_POST['passcon'];
	$oldpass = $_POST['oldpass'];
	$status = $_POST['status'];
	$result = $sql->select("person_email,password,name,surname,title_id","person","person_id='$person_id'");
	$row = $result->fetch_assoc();
	$password = $row['password'];
	$txt = "TMPD_KMUTNB";

	$id = "Not Found";
	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $pass)){
		$id = "found";
	}
	if( ($name!=''AND$surname!=''AND $email!='') OR $name!=$row['name']OR $surname != $row['surname'] OR $title !=$row['title_id'] OR $row['person_email']!=$email){
		$sql->update("person","name='$name', person_email ='$email' , surname ='$surname' ,title_id='$title' ","person_id='$person_id'");
		$_SESSION['name'] = $name;
		$_SESSION['surname'] = $surname;
		$message = "4";
	}else{
		if($pass==''||$passcon==''||$oldpass==''){$message = "0";}//กรอกข้อมูลไม่ครบ
		else if($pass!=$passcon){$message = "2";}//รหัสผ่านไม่ตรงกัน
		else if($pass==$passcon&&md5($oldpass.$txt) == $password){$message = "1";	
			$sql->update("person","password=md5('$pass$txt')","person_id='$person_id'");

			}//แก้ไขรหัสผ่าน
		else{
			$message ="3";
		}	
	}
	$id = $message.$status;
	// $id = $pass.$status.$person_id;
	echo $id;
	
?>