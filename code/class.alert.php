<?php 

class alert{
	public function sendMail($to,$body,$subject){
		require_once 'PHPMailer/PHPMailerAutoload.php';
		require_once('class.sql.php');
    	$mail = new PHPMailer;	       
        $from = "tmpd@program.com"; ///// from email
        $from_name ="TMPD";  ////from name
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
        $mail->SMTPAutoTLS = false;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = $tmpd_email;
        $mail->Password = $tmpd_password;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
	}
	public function sendLine($id,$pos,$message,$topic){
		require_once('class.sql.php');
      	$sql = new sql(); 

		if($id==""){
			$result = $sql->select("line_token","person","position ='$pos' AND status='on' AND line_token!=''");
		}else{
			$result = $sql->select('line_token','person',"person_id='$id' AND status='on' AND line_token!=''");
		}
		$check = "ไม่มีการลงทะเบียนการแจ้งเตือนไลน์";

		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			// echo "$id : line = ".$row['line_token'];
			$sMessage = $message;
			$target = $row['line_token'];
			if($topic!=""){
				$sMessage = $topic." : ".$message;
			}
			include('../line_message.php');
			// include('line_message.php');
			$check = "แจ้งเตือนทางไลน์สำเร็จ";
		}
		echo "<script>alert('$check')</script>";
	}
	public function status($id){
		
		if($id=="00"){
			echo '<script language="javascript">alert("กำลังเข้าสู่ระบบ")</script>';
		}
		else if($id=="01"){ 
			echo '<script language="javascript">alert("Username หรือ Password ผิดพลาด")</script>';
		}
		else if($id=="05"){
			echo '<script language="javascript">alert("มี Username นี้แล้ว")</script>'; 
		}
		else if($id=="06"){
			echo '<script language="javascript">alert("รหัสผ่านไม่ตรงกัน")</script>'; 
		}
		else if($id=="07"){
			echo '<script language="javascript">alert("รหัสผ่านไม่ถูกต้อง")</script>'; 
		}
		else if($id=="08"){
			echo '<script language="javascript">alert("กรอกข้อมูลไม่ครบ")</script>';
		}
		else if($id=="09"){
			echo '<script language="javascript">alert("พบข้อมูลซ้ำ กรุณาตรวจสอบใหม่อีกครั้ง")</script>';
		}
		else if($id=="10"){ 
			echo '<script language="javascript">alert("เพิ่มข้อมูลสำเร็จ")</script>';
		}
		else if($id=="20"){
			echo '<script language="javascript">alert("ลบข้อมูลสำเร็จ")</script>'; 
		}
		else if($id=="30"){
			echo '<script language="javascript">alert("แก้ไขข้อมูลสำเร็จ")</script>'; 
		}
		else if($id=="31"){
			echo '<script language="javascript">alert("ไม่สามารถแก้ไขข้อมูลได้ กรุณาตรวจสอบใหม่อีกครั้ง")</script>'; 
		}
		else if($id=="40"){
			echo '<script language="javascript">alert("เพิ่มเอกสารสำเร็จ")</script>';
		}
		else if($id=="50"){
			echo '<script language="javascript">alert("ยกเลิกสำเร็จ")</script>';
		}
		else if($id=="60"){
			echo '<script language="javascript">alert("เปิดการทำงานสำเร็จ")</script>';
		}
		else if($id=="61"){
			echo '<script language="javascript">alert("ปิดการทำงานสำเร็จ")</script>';
		}
		else{
			echo '<script language="javascript">alert("อื่นๆ")</script>'; 
		}

	}
	public function link($delay,$destination){
		echo "<META HTTP-EQUIV='Refresh' CONTENT='$delay;URL= $destination'>";
	} 	
}
 ?>