<form id="form_mail">
	<input type="mail" id="mail_target" value="khuk@hotmail.co.th" required name="mail_target">
	<input type="hidden" name="option" value="1">
	<input type="submit" name="">
</form>
<?php 
require_once ('bottom.php');
?>
<script type="text/javascript">
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
                // alert(id)
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
</script>