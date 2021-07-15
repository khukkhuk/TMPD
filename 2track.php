<?php
	if(session_status()==PHP_SESSION_NONE){
	  session_start();
	}
	ob_start();
	header('Content-Type: text/html; charset=utf-8');
	setcookie("track_id",$_GET['id'],time()+60);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	function receiveAct(id,step,version,count,topic,status,type){
		var r = confirm("ยืนยันการรับการดำเนินการ")
		if(r == true){
			var dataObj =  {
				        'id': id,
				        'step': step,
				        'version': version,
				        'count': count,
				        'topic': topic,
				        'status': status,
				        'type': type,
				    };
			$.ajax({
		            url: 'receiveAct.php',
		            type: 'POST',
		            data: dataObj,

		            success: function (id) {
		            	// alert(id)
		            }
		        });
			alert("รับการดำเนินการสำเร็จ")
			window.location.replace("user/index.php")
		}else{
			window.close()
		}
	}
</script>
<?php
	require_once('code/class.sql.php');	
	require_once('code/class.alert.php');	
	$sql = new sql();
	$alert = new alert();
	$person_id = $_SESSION['person_id'];
	$activity_id = $_GET['id'];
	$result = $sql->select("*","activity","activity_id = '$activity_id' AND person_id = '$person_id'");

	$rsAct = $sql->select("*","activity","activity_id='$activity_id' AND status_id='2'");
	// echo print_r($_SESSION);
	
	if(empty($_SESSION['person_id'])){
		echo "<script>alert('กรุณาเข้าสู่ระบบ')</script>";
		$alert->link("0","index.php");
	}else if($_SESSION['position_id']=='1'){
		echo "<script>alert('ติดตามการดำเนินการ')</script>";
	}else if($result->num_rows>0){
		echo "<script>alert('ติดตามการดำเนินการ')</script>";
	}else if($rsAct->num_rows>0){ 

		$rwAct = $rsAct->fetch_assoc();
		$stepAct  = $rwAct['step'];
		$typeAct  = $rwAct['type']; 
		$countAct = $rwAct['count'];
		$topicAct = $rwAct['topic'];
		$statusAct = $rwAct['status_id'];
		if($stepAct<100){
			$stepAct = $typeAct."00"; 
		}
		$stepAct += 1; 
		$versionAct  = $rwAct['version'];
		$rsPos = $sql->select("*","step","step='$stepAct' AND version ='$versionAct'");
		$rwPos = $rsPos->fetch_assoc();
		$position_id = $_SESSION['position_id'];
		if($position_id == $rwPos['position_id']){
			echo "รับการดำเนินการ";
			// echo "<script>confirm('ยืนยันการรับการดำเนินการ')</script>";
			$stepAct  = $rwAct['step'];
			echo "<script> receiveAct($activity_id,$stepAct,$versionAct,$countAct,'$topicAct',$statusAct,$typeAct); </script>";
			
		}else{
			echo "<script>alert('ไม่มีสิทธิ์เข้าถึง')</script>";
			echo "<script>window.close()</script>";
		}
	}else{
		echo "<script>alert('ไม่มีสิทธิ์เข้าถึง')</script>";
		echo "<script>window.close()</script>";
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href ="https://www.thaicreate.com/images/icon.ico" />

    <title>ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</title>

	<script type="text/javascript" src="library/qrcode/qrcode.min.js"></script>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> -----------------offline--------------- -->
    
    <style type="text/css">
        th{
            text-align: center;
        }
        .circle_text{
            color:white;
            padding:1px 7px;
            font-size:14px;
            background-color:red;
            border-radius:120px;
        }
        table tr:nth-child(even){
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
        #background{
            position:absolute;
            z-index:0;
            background:white;
            display:block;
            min-height:50%; 
            min-width:50%;
            color:yellow;
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
		.data_box{
			margin-left: 7%;
			margin-top: 3%;
			min-width: 300px;
		}
		.data_box th,td{
			text-align: center;
			padding: 7px 10px;
		}
		.qrcode img{
			margin-left: 15%;
			width: 170px;
		}
    </style>
</head>
<?php 
    $sidebar_color = "#118DA3" ;
    $sub_sidebar_color = "#01A4C0" ;
    $button_menu = "#F37430";
 ?>
<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" style="background-color: <?php echo $sidebar_color; ?>">
            <div class="sidebar-header" style="background-color: <?php echo $sidebar_color; ?>">  
	        	<center> 
	            <img style="height: 80px;" src="login/hos.png">
	            <img style="height: 80px;" src="login/kmutnb_2.png">
	            <img style="height: 100px;" src="login/fitm_t.png">
	            <div style="margin-top:15px;">
	            	<h5>ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
	            </div>
            </div>

            <ul class="list-unstyled components">
            	<li>
            		<div id="qrcode" class="qrcode" style=""></div>
            		<h6 style="margin-left: 23px;margin-top: 18px;">qrcode สำหรับการดำเนินการ</h6>
            	</li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            
           

<?php
	// print_r($_SESSION);
    $footer_color = "#bfbfbf";
	$id = $_GET['id'];
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
<div class="data_box">
	<table style="width: 70%;">
		<tr><td colspan="2"><center>สถานะปัจจุบันของ : <?php echo $topic; ?></td> 
		</tr>
		<tr>
			<td>ตำแหน่ง : <?php echo $_SESSION['show_pos']; ?> </td>
			<td>สถานะ : <?php echo $_SESSION['show_status']; ?> </td> 
		</tr>
	</table>

	<table style="width: 70%;margin-top: 15px;background-color: white;border-radius: 12px 12px 0px 0px;color:black;">
 		<thead>
	 		<tr>
	 			<th style="background-color: <?php echo $sidebar_color; ?>;border-radius: 12px 12px 0px 0px;" colspan="5"><center>รายละเอียดการดำเนินการ</center></th>
	 		</tr> 
	 		<tr style="background-color: <?php echo $sidebar_color; ?>">
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
	 		$alert->link(0,"2track.php?id=".$_GET['id']);
	 	}
	 	 ?>
 		</tbody>
 	</table> 
</div>
</div>
 
<script type="text/javascript">
	link = window.location.href
	new QRCode(document.getElementById("qrcode"), link);


</script>


<div class="footer">©fitm 2019-2020</div>
    <!-- <script src="../js/jquery.js"></script> -->
     <!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>