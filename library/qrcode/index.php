<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title>Document</title> 
    <!-- <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.1.0/dist/css/bootstrap.min.css" > -->
    <script type="text/javascript" src="qrcode.min.js"></script>
</head>
<body>
	<style type="text/css">
		br{

		}
		.create_space{

		}
	</style>  
 <br />
<br />
 <div style="width:500px;margin:auto;"> 
    <div id="qrcode"></div>
 </div>
  <?php
  $name=$_POST['name'];
  ?>
<script type="text/javascript">
new QRCode(document.getElementById("qrcode"), "<?php echo "https://www.$name.com";?>");
</script>
</body>
</html>