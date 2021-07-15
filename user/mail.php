<!-- <?PHP
require("PHPMailer/class.phpmailer.php");  // ประกาศใช้ class phpmailer กรุณาตรวจสอบ ว่าประกาศถูก path

// function smtpmail( $email , $subject , $body )
// {
    $email = "sanbejn@gmail.com";
    $subject = "password";
    $body = "new password is 123";
    $mail = new PHPMailer();
    $mail->IsSMTP();         
      $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้                        
    $mail->Host     = "mail.yourdomain.com"; //  mail server ของเรา
    $mail->SMTPAuth = true;     //  เลือกการใช้งานส่งเมล์ แบบ SMTP
    $mail->Username = "khuk@hotmail.co.th";   //  account e-mail ของเราที่ต้องการจะส่ง
    $mail->Password = "**********";  //  รหัสผ่าน e-mail ของเราที่ต้องการจะส่ง

    $mail->From     = "khuk@hotmail.co.th";  //  account e-mail ของเราที่ใช้ในการส่งอีเมล
    $mail->FromName = "TMPD"; //  ชื่อผู้ส่งที่แสดง เมื่อผู้รับได้รับเมล์ของเรา
    $mail->AddAddress($email);            // Email ปลายทางที่เราต้องการส่ง(ไม่ต้องแก้ไข)
    $mail->IsHTML(false);                  // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
    $mail->Subject     =  $subject;        // หัวข้อที่จะส่ง(ไม่ต้องแก้ไข)
    $mail->Body     = $body;                   // ข้อความ ที่จะส่ง(ไม่ต้องแก้ไข)
     $result = $mail->send();       
     //return $result;
// }
?> -->

<html>
<head>
<title>ThaiCreate.Com PHP Sending Email</title>
</head>
<body>
<?php
    $strTo = "khuk@hotmail.co.th";
    $strSubject = "Test Send Email";
    $strHeader = "From: webmaster@thaicreate.com";
    $strMessage = "My Body & My Description";
    $flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
    if($flgSend)
    {
        echo "Email Sending.";
    }
    else
    {
        echo "Email Can Not Send.";
    }
?>
</body>
</html>