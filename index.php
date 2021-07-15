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
	<link rel="shortcut icon" type="image/x-icon" href ="https://www.thaicreate.com/images/icon.ico" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body>
<?php 
    $background_color = "#01A4C0" ;
    $login_button = "#F37430";
    $login_button_h = "#dc5309";
    $footer_color = "#bfbfbf";
?>
<style type="text/css">
@media screen and (max-width: 3000px) {
	body{
		height: 100%;
		background-color:<?php echo $background_color; ?>;
	}
	.container{	

		margin-top: 3%;
		width: 580px;
		background-color: white;
		border-radius: 14px;
	}
	.box{
		width: 430px;
		border-radius:14px;
		height: 300px;
	}
	.box input[type="text"],input[type="password"]{
		margin: 2px; 
		width: 380px; 
		border-color: #b5b5b5;
		border-width: 0;
		background-color: #f8f8f8;
		height: 40px;
		padding:12px;
		font-size: 18px;
	}
	.box input[type="text"]{
		margin-top: 15px;
	}
	input[type="submit"]{
		font-size: 18px;
		margin:0px;
		margin-top: 20px;
		width: 430px; 
		border-color: white;
		border-width: 0;
		height: 48px;
		background-color: <?php echo $login_button; ?>;
		color:white;
	}
	input[type="submit"]:hover{
		background-color: <?php echo $login_button_h; ?>;
	}
	.check{
		margin-top: 15px;
		margin-left: 12px;
		float: left;
		font-size: 14px;
	}
	.forgot{
		margin-top: 15px;
		margin-right: 12px;
		float: right;
	}
	.title{
		height: 50px;
		padding-top: 0px;
		border-radius:14px 14px 0px 0px;
		font-size: 23px;
		/*background-color: #fbb350;*/
		color:black;
	}
	.footer {
    	position: fixed;
	    left: 0;
 	  	bottom: 0;
   	 	width: 100%;
   	 	height: 43px;
  	  	background-color: <?php echo $footer_color; ?>;
   		color:white;
    	text-align: center;
    	padding-bottom: 5px;
    	padding-top: 5px;
	}
} 


</style>
<center>
	<div class="container">
		 <img style="width: 100px;margin-left: 52px;" src="login/hos.png">
		 <img style="width: 120px;margin-left: 32px;" src="login/kmutnb_2.png">
		 <img style="width: 220px;" src="login/fitm_t.png">
		<div class="box">
			<form method="post">
				<div class="title">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง<br>โรงพยาบาลค่ายจักรพงษ์</div><br>
				<input type="text" name="txt_user" id="txt_user" class="txtuser" autocomplete="off" value="<?php if(isset($_COOKIE['txt_user'])&&$_COOKIE['txt_user']!=''){echo $_COOKIE['txt_user'];}?>" placeholder="USERNAME">

				<input type="password" name="txt_pass" id="txt_pass" class="txtpass" autocomplete="off" value="<?php if(isset($_COOKIE['txt_pass'])&&$_COOKIE['txt_pass']!=''){echo $_COOKIE['txt_pass'];}?>" placeholder="PASSWORD" ONKEYDOWN="if(event.keyCode==13){document.getElementById('btnsub').focus();return false;}">

				<div class="check"><input name="chk" type="checkbox" id="chk" value="on" <?php if(isset($_COOKIE['txt_user'])&&$_COOKIE['txt_user']!=''){echo "checked";} ?> />จดจำข้อมูล</div>
				<div class="check"><button type="button" style="margin-left:45px;margin-top: 0.5px;font-size: 14px;background-color: white;border-width: 0;color: black;" data-toggle="modal" data-target="#openModalAdd">สมัครสมาชิก</button></div>
				<div class="check"><button  type="button" style="margin-left:45px;margin-top: 0.5px;font-size: 14px;background-color: white;border-width: 0;color: black;" data-toggle="modal" data-target="#openModalforgot">จำรหัสผ่านไม่ได้ ?</button></div>

				<input type="submit" value="เข้าสู่ระบบ" id="btnsub" class="btnsub" name="btnsub">
			</form>
		</div>
	</div>
</center>

<div class="modal fade" id="openModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h6 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h6>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2>สมัครสมาชิก</h2>
		        	<table>
			        	<form id="form_register">
			        	<tr>
			        		<td>คำนำหน้า</td>
			        		<td>

			        		<select name="title" style="width: 80%;margin-left: 10%;">
			        		<?php 
			        		$rsTitle = $sql->select("*","title","");
			        		while($rwTitle = $rsTitle->fetch_assoc()){
			        			?>
			        			<option value="<?php echo $rwTitle['title_id']; ?>"><?php echo $rwTitle['title_name']; ?></option>
			        			<?php
			        		}
			        		?>
			        		</select>
			        	</td>
			        	</tr>
			        	<tr><td>ชื่อ</td><td><center><input style="width: 80%" type="text" name="name" value=""></td></tr>
			        	<tr><td>นามสกุล</td><td><center><input style="width: 80%" type="text" name="surname" value=""></td></tr>
			        	<tr><td>อีเมล</td><td><center><input style="width: 80%" type="email" name="email" value=""></td></tr>
			        	<tr><td>Username</td><td><center><input style="width: 80%" type="text" name="username" value=""></td></tr>
			        	<tr><td>Password</td><td><center><input style="border-width: 0.1px;border-color: black;background-color: white; height: 35px;width: 80%" type="password" name="password" value=""></td></tr>
			        	<tr><td>Confirm Password</td><td><center><input style="border-width: 0.1px;border-color: black;background-color: white; height: 35px;width: 80%" type="password" name="confirm_password" value=""></td></tr>
			        	<tr>
			        		<td>ตำแหน่ง</td>
			        		<td>

			        		<select name="position" style="width: 80%;margin-left: 10%;">
			        		<?php 
			        		$rsPos = $sql->select("*","position","position_id!='1'");
			        		while($rwPos = $rsPos->fetch_assoc()){
			        			?>
			        			<option value="<?php echo $rwPos['position_id']; ?>"><?php echo $rwPos['position']; ?></option>
			        			<?php
			        		}
			        		?>
			        		</select>
			        		</td>
			        	</tr>
					</table>
      		  </div>
		      <div class="modal-footer">

		      	<input type="hidden" name="option" value="2">
		        <input type="submit" style="margin-right: 16px" class="btn btn-primary" value="บันทึกข้อมูล">
			    </form>
		      </div>
		    </div>
		  </div>
		</div>

<div class="modal fade" id="openModalforgot" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h6 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h6>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2>กู้รหัสผ่าน</h2>
		        	<table>
			        	<form  id="form_mail">
			        		<tr>
			        			<td>กรอกอีเมลล์ของคุณ</td>
			        			<td><input type="email" name="mail_target"></td>
			        		</tr>
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input type="hidden" name="option" value="1">
		        <center><input type="submit" style="margin-right: 16px" class="btn btn-primary" name="btn_forgot" value="ยืนยัน">
			    </form>
		      </div>
		    </div>
		  </div>
		</div>
<div class="footer">©fitm 2019-2020</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/jquery.js"></script>
     <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>
</html>
<script type="text/javascript">
	$(document).ready(function () {
		console.log("js ready")
		$("#form_mail").on("submit",function(e){
	        e.preventDefault(); 
			alert("กำลังดำเนินการ") 
	        var formData = new FormData($(this)[0]);
	        $.ajax({
	            url: 'mail.php',
	            type: 'post',
	            data: formData,
	            processData: false,
	            contentType: false,

	            success: function (id) {
	                alert(id)
	                if(id=="1"){
	                	alert('ไม่สามารถส่งเมลได้กรุณาติดต่อผู้ดูแลระบบ')
	                }else if(id=="2"){
	                	alert('ไม่พบอีเมลในระบบกรุณาตรวจสอบข้อมูล')
	                }else if(id=="3"){
	                	alert('กรุณากรอกข้อมูล')
	                }else{
	                	alert('ระบบได้ส่งรหัสไปที่อีเมลล์ของคุณแล้ว')
	                	window.location.replace("forgot_password.php?id="+id);
	                }

	            }
	        });
	    });
		$("#form_register").on("submit",function(e){
                e.preventDefault(); 
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: 'register.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (id) {
                    	console.log(id)
                    	let status = id;
                    	if(status==10){
                        	$.ajax({
			                    url: 'mail.php',
			                    type: 'post',
			                    data: formData,
			                    processData: false,
			                    contentType: false,

			                    success: function (id) {
				                	alert("รอการยืนยันจากทางผู้ดูแลระบบ")
                        			window.location.replace("index.php");
			                	}
			                });
                    	}else if(status==6){
                    		alert("รหัสผ่านไม่ตรงกัน")
                    	}else if(status==5){
                    		alert("มี Username นี้แล้ว")
                    	}else if(status==8){
                    	alert("กรอกข้อมูลไม่ครบ")
                    		}
                	}
                });

        });



	})
</script>
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
				$alert->link("0","index.php");
			}
		}else{
			$alert->status("08");
		}
	}
	
?>
