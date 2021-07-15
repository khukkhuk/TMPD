<?php 
		// echo $txt_user=$_POST['txt_user'];
echo print_r($_REQUEST);
		if(isset($_POST['txt_user'])AND($_POST['txt_user']!='') AND(isset($_POST['txt_pass'])AND($_POST['txt_pass']!=''))){
			require "code/class.sql.php";
			$sql = new sql();
			$link ="";
	 		$result = $sql->login($_POST['txt_user'],$_POST['txt_pass']);
			$nums = $result->num_rows;
			if($nums>0){
				if(isset($_POST['chk'])&&$_POST['chk'] == "on") { // ถ้าติ๊กถูก Login ตลอดไป ให้ทำการสร้าง cookie
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
				// $alert->status("00");
				$status = "00";
				if($_SESSION['position_id']=='1'){
					// $alert->link("0","admin/index.php");
					$link = "admin/index.php";
				}else{
					// $alert->link("0","user/index.php");	
					$link = "user/index.php";
				}
			}else{ 
				setcookie("txt_user", "", 1);
				setcookie("txt_pass", "", 1);
				// $alert->status("01"); 
				// $alert->link("0","index.php");
				$status = "01";
				$link = "index.php";
			}
		}else{
			// $alert->status("08");
				$status = "08";
				$link= "";
		}
		// echo $status.$link;
?>