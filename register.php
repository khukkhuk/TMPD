<?php 
	require_once('code/class.sql.php');
	$sql = new sql();
		$title=$_POST['title'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$position=$_POST['position'];
		$email=$_POST['email'];
		$confirm_password=$_POST['confirm_password'];
		if($title!=''&&$name!=''&&$surname!=''&&$username!=''&&$password!=''&&$confirm_password!=''&&$email!=''){
			$result=$sql->select("*","person","username='$username' AND person_email='$email'");
			if($result->num_rows==0){
				if($password==$confirm_password){
					$txt = "TMPD_KMUTNB";
					$result = $sql->insert("person","name,surname,username,password,position,title_id,user_status,status,person_email","'$name','$surname','$username',md5('$password$txt'),'$position','$title','unactivated','off','$email'");
					if($result){
						echo "10";
					}
				}else{
					echo "06";
				}					
			}else{ 
				echo "05";
			}
		}else{
			echo "08";
		}
	 
?>