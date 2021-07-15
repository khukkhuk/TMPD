
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.1.0/dist/css/bootstrap.min.css" > -->
    <script type="text/javascript" src="qrcode.min.js"></script>
 <div style="width:500px;margin:auto;"> 
    <div id="qrcode"></div>
 </div>
  <?php
  $id=$_GET['id'];
  ?>
<script type="text/javascript">
new QRCode(document.getElementById("qrcode"), "<?php echo "https://127.0.0.1/project2/user/track.php?id=$id";?>");
</script>