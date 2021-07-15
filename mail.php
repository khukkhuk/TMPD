<?php   
    require_once 'PHPMailer/PHPMailerAutoload.php';
    require_once 'code/class.sql.php';
    $sql = new sql;
    $mail = new PHPMailer;
 
    if($_POST['mail_target']!=''){
        $option = $_POST['option'];
        $to = $_POST['mail_target'];
        
        if($option == 1){
            $result = $sql->select("*","person","person_email = '".$_POST['mail_target']."'");
            $num =  $result->num_rows;

            if($num>0){
                $row = $result->fetch_assoc();
                $pass_rand ="";
                $key = "123456789abcdefghjklmnpqrtuvwxyABCDEFGHJKLMNPQRSTUVWXYZ"; 
                srand((double)microtime()*1000000); 
                for($i=0; $i<7; $i++) { 
                    $pass_rand .= $key[rand()%strlen($key)]; 
                } 
                $code = $pass_rand;
                setcookie("secret_code", $code, time() + (60*10), "/");

                                $body= "Your secret key is : $code
                This email cannot reply your email then you have a problem please contract administrator.
                Thank you.";
            }else{
                echo "2";
                // echo "<script>alert('ไม่พบอีเมลในระบบกรุณาตรวจสอบข้อมูล')</script>";  
            }
        }
        else if($option ==2){
            $body= "Have a new account waiting for approval.";
        }
        else if ($option ==3){
            $body= "Your account has been approved.";
        }

        $subject = "TMPD";
        $from = "tmpd@program.com"; ///// from email
        $from_name ="TMPD";  ////from name
        $mail->IsSMTP(); // enable SMTP
        // $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
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
        if(!$mail->Send()) {
            echo "1";
            // echo "<script>alert('ไม่สามารถส่งเมลได้กรุณาติดต่อผู้ดูแลระบบ')</script>";
        }else {
            if($option==1){
                echo $row['person_id'];    
            }else{
                echo "4"
            } 
            // echo "<script>alert('ระบบได้ส่งรหัสไปที่อีเมลล์ของคุณแล้ว')</script>";
            // $alert->link(0,"forgot_password.php?id=".$row['person_id']);
        }   
    }else{
        echo "3";
        // echo "<script>alert('กรุณากรอกข้อมูล')</script>";
    }
?>