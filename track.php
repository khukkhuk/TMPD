<?php 
if(session_status()==PHP_SESSION_NONE){
  session_start();
} ?>
<!DOCTYPE html>
<html>
<head>
	<title>Tracking</title>
</head>
<body>
<style type="text/css">
	.nav_bar li{
		display: inline;
	}
	.nav_bar{
		background-color: #54cacd;
		width: 100%;
		height: 45px;
		padding-top: 12px
	}
</style>
<div class="nav_bar">
	<ul>
		<li style="margin-left: 35%">ระบบจัดการและติดตามเอกสาร โรงพยาบาลค่ายจักรพงษ์</li>
	</ul>
</div>
<center>
<img style="width: 80px;opacity: 1;transform: translate(-100%,0%);" src="login/kmutnb_2.png">
<img style="width: 80px;opacity: 1;transform: translate(15%,0%);" src="login/hos.png">
<img style="width:170px;opacity: 1;transform: translate(50%,0%);" src="login/fitm_t.png">
</center>
<?php
	// print_r($_SESSION);
    $footer_color = "#bfbfbf";
	require_once('code/class.sql.php');	
	require_once('code/class.alert.php');	
	$id = $_GET['id'];
	$sql = new sql();
	$rsActivity = $sql->select('*','activity',"activity_id='$id'");
	$rwActivity = $rsActivity->fetch_assoc();
	$version = $rwActivity['version'];
	$type = $rwActivity['type'];
	$step = $rwActivity['step'];
	$topic = $rwActivity['topic'];
	$where = "activity_id='$id' AND activity_detail.document_name ='' ORDER BY activity_detail.activity_detail_id ASC";
	$from = "activity_detail left join status on activity_detail.status_id = status.status_id ";
	$field = "*";
	$rsAcDe = $sql->select('*',"$from","$where");
	$i=1;
	$from='';
 ?>
 <script type="text/javascript" src="library/qrcode/qrcode.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">


<style type="text/css">
	html, body { 
	   height: 100%; /* ให้ html และ body สูงเต็มจอภาพไว้ก่อน */
	   margin: 0;
	   padding: 0;
	}
	.wrapper {
	   display: block;
	   min-height: 120%; /* real browsers */
	   height: auto !important; /* real browsers */
	   height: 120%; /* IE6 bug */
	   margin-bottom: -142px; /* กำหนด margin-bottom ให้ติดลบเท่ากับความสูงของ footer */
	}	
	form{
		border-radius: 9px;
		margin:24px;
		margin-top: 1%;
		background-color: #7dd2c5;
		width: 240px;
		padding: 5px 45px;
		font-size:14px;

	}	
	input{
		margin-top: 12px;
	}
	input[type="text"]{ 
		border-radius: 3px;
		border-width: 0.1px;
		padding: 3px;
		width:90%;
		text-align: center
	}
	input[type="submit"]{
		width: 100%;
		background-color:#ff9e52; 
		border:0;
		padding: 10px 0px;
		border-radius: 7px;
		color:black;
		font-size: 24px;
	}
	th,td{
		padding: 12px 5px;
	}
	.footer { 
    	position: fixed;
	    left: 0;
 	  	bottom: 0;
   	 	width: 100%;
   	 	height: 42px;
  	  	background-color: #bfbfbf;
   		color:white;
    	text-align: center;
    	padding-bottom: 5px;
    	padding-top: 5px;
	}
	/*.footer {
  	  	background-color: #bfbfbf;
   		color:white;
   	 	width: 100%;
	    height: 42px; 
	    display: block;
	    text-align: center;
	}*/
	table{
		width: 720px;
		text-align: center;
		margin:14px;
		margin-bottom:25px;
	}

</style>
<center>
	<div class="wrapper">
<div class="status_box">

	<table>
		<tr><td>สถานะปัจจุบันของ : <?php echo $topic; ?></td>
			<td><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ShowQr">QrCode ของงาน</button></td>
		</tr>
		<tr>
			<td>ตำแหน่ง : <?php echo $_SESSION['show_pos']; ?> </td>
			<td>สถานะ : <?php echo $_SESSION['show_status']; ?> </td> 
		</tr>
	</table>
</div>

<table style="background-color: white;border-radius: 12px 12px 0px 0px;color:black;">
 		<thead>
	 		<tr>
	 			<th style="background-color: #54cacd;border-radius: 12px 12px 0px 0px;" colspan="5"><center>รายละเอียดการดำเนินการ</center></th>
	 		</tr> 
	 		<tr style="background-color: #54cacd">
	 			<th>จาก</th>
	 			<th>สถานะ</th>
	 			<th>ถึง</th>
	 			<th>วันที่/เวลา</th>
	 		</tr>
 		</thead>
 		<tbody>
	 		<?php
	 			
	 			while($rwAcDe=$rsAcDe->fetch_assoc()){    
	 				$step = $rwAcDe['step'];
	 				$status = $rwAcDe['status_id'];
	 				$id = $rwAcDe['person_id'];

		 			$rsPerson = $sql->select('*',"person left join position on person.position = position.position_id","person_id = '$id'");
	 				$rwPerson = $rsPerson->fetch_assoc();
	 				

		 			$new_step = $rwAcDe['step']+1;
		 			if($new_step==1){
		 				$new_step=$type."01";
		 			}
		 			$rsStep = $sql->select("*","step left join position on step.position_id = position.position_id "," step='$new_step' AND version='$version'");
		 			$rwStep = $rsStep->fetch_assoc();
		 			$target = $rwStep['position'];

		 			if($status!=2){
		 				$step -=1 ;
	 					$target = "-";
		 			}
	 		 ?>
	 		<tr> 
	 			<td><?php echo $rwPerson['position'];?></td>
	 			<td><?php echo $rwAcDe['status'];?></td>
	 			<td><?php echo $target;	?></td>
	 			<td><?php echo $rwAcDe['date'];?></td>  
	 		</tr>
	 	<?php $i++;
	 	$show_status = $rwAcDe['status'];
	 	$show_pos = $rwPerson['position'];
	 	 } 
	 	if(empty($_SESSION['track_id'])OR($_SESSION['track_id'])!=$_GET['id']){
			$_SESSION['show_status'] = $show_status;
	 		$_SESSION['show_pos'] = $show_pos;
	 		$_SESSION['track_id'] = $_GET['id'];
	 		$alert = new alert();
	 		$alert->link(0,"track.php?id=".$_GET['id']);
	 	}
	 	 ?>
 		</tbody>
 	</table> 



		<div class="modal fade" id="ShowQr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document"> 
		      <div class="modal-body"> 
		      	
				<div id="qrcode" style="margin-top:30px"></div>
		      	
 			  </div>
      		</div> 
		  </div>
	</div>
<div class="footer">©fitm 2019-2020</div>


</body>
</html>
 	 

<script type="text/javascript">
	link = window.location.href
	new QRCode(document.getElementById("qrcode"), link);
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="../js/jquery.js"></script> -->
     <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
