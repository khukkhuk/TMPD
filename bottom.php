  <style type="text/css">
    .footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 41px;
    background-color: #bfbfbf;
    color: black;
    text-align: center;
    padding-bottom: 5px;
    padding-top: 5px;
    }
  </style>
<?php if(empty($_GET['track'])){ ?>
<!-- <div class="footer">Copyright © by fitm 2019-2020</div> -->
<div class="footer">©fitm 2019-2020</div>
<!-- <div class="footer"><img style="width:33px;margin-right: 1%;position: relative;" src="../login/kmutnb_2.png">มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ คณะเทคโนโลยีและการจัดการอุตสาหกรรม <img  style="width:70px;margin-bottom:-10px; ;margin-left: 1%;position: fixed;" src="../login/fitm_t.png"></div> -->
<?php } ?>
  <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="../js/jquery.js"></script> -->
     <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">

        function upload(id){
            var formData = $("#form_img").serialize();

            $.post("save_img.php",
                formData,
                function(data){
                alert(data);
        })
        }
        function upload_file(id){
                // alert('#frm'+id);

                $.ajax({
                    url: "save_img.php",
                    type: 'post',
                    data: $('#form'+id).serialize(),
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (result) {
                        alert(result);
                    }
                });
            }

        function form_upload_file(id){ 
            // alert("form_upload_file");
 
            var formData = new $('#form_upload'+id).serialize(); 

            $.ajax({
                    url: '../upload_file.php',
                    type: 'get',
                    data: formData, 
                    processData: false, 
                    contentType: false,

                    success: function (id) {
                        alert(id)
                        var len = id.length;
                        len = len - 1;
                        console.log(id);
                        status = id.substring(len,len+1);
                        id = id.substring(0,len);

                        if(status=="s"){ 
                            alert('เพิ่มเอกสารสำเร็จ')
                            window.location.replace("/TMPD/user/process.php?activity_id="+id);
                        }else if(status=="u"){
                            alert('ไม่สามารถเพิ่มเอกสารได้กรุณาติดต่อผู้ดูแลระบบ')
                        }
 
                    }
                });

        }
        $(document).ready(function () {
            <?php 
                if(isset($_SESSION['coming_work'])AND$_SESSION['coming_work']>0){
            ?>
                // console.log("coming_work");
                // alert("OK");
                var coming_work = <?php echo $_SESSION['coming_work']; ?>;
                $("#coming_work").append(" <span style='color:white;padding:1px 7px;font-size:14px; background-color:red;border-radius:120px  '>"+coming_work+"</span>");
            <?php }else{
            ?>
                // alert("no");
            <?php
            } ?>
            
            console.log("Js Ready");
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

             $("#form_upload").on("submit",function(e){
                e.preventDefault(); 
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '../upload_file.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (id) {
                        // alert(id)
                        var len = id.length;
                        len = len - 1;
                        console.log(id);
                        status = id.substring(len,len+1);
                        id = id.substring(0,len);

                        if(status=="s"){ 
                            alert('เพิ่มเอกสารสำเร็จ')
                            window.location.replace("/TMPD/user/process.php?activity_id="+id);
                        }else if(status=="u"){
                            alert('ไม่สามารถเพิ่มเอกสารได้กรุณาติดต่อผู้ดูแลระบบ')
                        }
 
                    }
                });
            });

             $("#form_edit").on("submit",function(e){
                link = window.location.href
                e.preventDefault(); 
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '../edit_profile.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (id) {

                        len = id.lenght;

                        message = id.substring(0, 1);
                        status = id.substring(1, 2);
                        // alert(message+" & "+status)
                        if(status=="a"){
                            status = "admin"
                        }else if(status=="u"){
                            status = "user"
                        }
                        if(message=="0"){
                            message = "กรอกข้อมูลไม่ครบ"
                        }else if(message =="1"){
                            message = "แก้ไขสำเร็จ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
                            link = "/TMPD/"+status+"/logout.php"
                        }else if(message =="2"){
                            message = "รหัสผ่านไม่ตรงกัน"
                        }else if(message =="3"){
                            message = "รหัสเดิมไม่ถูกต้อง"
                        }else if(message =="4"){
                            message = "แก้ไขข้อมูลสำเร็จ"
                        }

                        // alert(id)
                        alert(message)
                        window.location.replace(link);
                    }
                });
            });


             $("#admin_upload").on("submit",function(e){
                e.preventDefault(); 
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url: '../admin_upload.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function (id) {
                        alert(id)
                        var len = id.length;
                        len = len - 1;
                        console.log(id);
                        status = id.substring(len,len+1);
                        id = id.substring(0,len);
                        console.log("status : "+status);
                        console.log("id : "+id);
                        if(status == 'u'){
                            alert("เอกสารนี้มีอยู่ในระบบแล้ว");    
                        }else if(status =='s'){
                            alert("เพิ่มเอกสารสำเร็จ")
                            // window.location.replace("/TMPD/admin/manage_document.php?id="+id);
                        }
                    }
                });
                 
            });

            

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
 
        })
    </script>
    <style type="text/css">
        textarea{
            width: 650px;
            height: 120px;
            resize: both;
        }
    </style>