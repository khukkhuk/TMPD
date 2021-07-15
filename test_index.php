<?php 
ob_start(); 
require_once("code/class.alert.php");
require_once("code/class.sql.php");
$sql = new sql();
$alert = new alert();
 ?><!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>
</head>
<body>
<center>
	<div class="container">
		 <img style="width: 100px;margin-left: 52px;" src="login/hos.png">
		 <img style="width: 120px;margin-left: 32px;" src="login/kmutnb_2.png">
		 <img style="width: 220px;" src="login/fitm_t.png">
		<div class="box">
			<form method="post">
				<div class="title">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง<br>โรงพยาบาลค่ายจักรพงษ์</div><br>
				<input type="text" name="txt_user" class="txtuser"  placeholder="USERNAME">

				<input type="password" name="txt_pass" placeholder="PASSWORD" >

				<div class="check"><button  type="button" style="margin-left:45px;margin-top: 0.5px;font-size: 14px;background-color: white;border-width: 0;color: black;" data-toggle="modal" data-target="#openModalforgot">จำรหัสผ่านไม่ได้ ?</button></div>

				<input type="submit" value="เข้าสู่ระบบ" id="btnsub" class="btnsub" name="btnsub">
			</form>
		</div>
	</div>
</center>
<?php
	if(isset($_POST['btnsub'])){
		if(isset($_POST['txt_user'])AND($_POST['txt_user']!='') AND(isset($_POST['txt_pass'])AND($_POST['txt_pass']!=''))){
			$link ="";
	 		$result = $sql->login($_POST['txt_user'],$_POST['txt_pass']);
			$nums = $result->num_rows;
			if($nums>0){
				if(isset($_POST['chk'])&&$_POST['chk'] == "on") { // ถ้าติ๊กถูกจดจำข้อมูล ให้ทำการสร้าง cookie
					$user = $_POST['txt_user'];
					$pass = $_POST['txt_pass'];
					setcookie("txt_user", "", 1);
					setcookie("txt_pass", "", 1);
					setcookie("txt_user",$user,time()+3600*24*356);
					setcookie("txt_pass",$pass,time()+3600*24*356);
				}else{
					setcookie("txt_user", "", 1);
					setcookie("txt_pass", "", 1);
				}
					
				$show = $result->fetch_assoc();
				$_SESSION['person_id'] = $show['person_id'];
				$_SESSION['name'] = $show['name'];
				$_SESSION['username'] = $show['username'];
				$_SESSION['surname'] = $show['surname'];
				$_SESSION['position_id'] = $show['position_id'];
				$_SESSION['position'] = $show['position'];
				$alert->status("00");
				$status = "00";
				if($_SESSION['position_id']=='1'){
					$alert->link("0","admin/index.php");
				}else{
					if(isset($_COOKIE['track_id'])){
						$alert->link("0","2track.php?id=".$_COOKIE['track_id']);	
					}
					$alert->link("0","user/index.php");	
				}
			}else{ 
				setcookie("txt_user", "", 1);
				setcookie("txt_pass", "", 1);
				$alert->status("01"); 
				// $alert->link("0","index.php");
			}
		}else{
			$alert->status("08");
		}
	}
	
?>
