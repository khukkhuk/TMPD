<?php
if(session_status()==PHP_SESSION_NONE){
  session_start();
}
header('Content-Type: text/html; charset=utf-8');
if(empty($_SESSION['person_id'])){
          echo "<script type=\"text/javascript\">";
          echo "alert(\"กรุณาเข้าสู่ระบบ \");"; 
          echo "</script>"; 
      echo "<META HTTP-EQUIV='Refresh' CONTENT='1;URL= ../index.php'>";
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
            <div style="margin-top:15px;"><h5>ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5></div>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <form method="GET">
						<h5 style="margin-left: 7%">กรอกชื่อเอกสาร</h5> 
						<input type="text" name="txt_search" value="<?php if(isset($_GET['txt_search'])AND($_GET['txt_search']!="")){echo $_GET['txt_search'];} ?>"> 
						<input type="submit" name="" value="ค้นหา"><br>
						<input type="radio" name="status" <?php if(isset($_GET['status'])AND($_GET['status']=="on")){echo "checked";} ?> value="on"> เฉพาะที่เปิดการใช้งาน<br>
						<input type="radio" name="status" <?php if(isset($_GET['status'])AND($_GET['status']=="off")){echo "checked";} ?> value="off"> เฉพาะที่ปิดการใช้งาน<br>
						<input type="radio" name="status" <?php if((isset($_GET['status'])AND($_GET['status']=="all"))OR empty($_GET['status'])){echo "checked";} ?> value="all"> ทั้งหมด
					</form> 
                </li> 

               <!--  <li>
                    <a href="alert_setting.php">ตั้งค่าการแจ้งเตือน</a>
                </li>  -->
            </ul>

            <ul class="list-unstyled" style="background-color: white">
                <li> 
                	<!-- Credit -->
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
             

        

<?php 
    require_once('code/class.sql.php'); 
    $sql = new sql();
	$status = "";
	$where = "";

	$perpage = 8;
	$start = 0;
	$limit = "";
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}

	if(isset($_GET['status'])AND(isset($_GET['txt_search']))){
		if($_GET['status']!="all"){
			$where = "document_name like '%".$_GET['txt_search']."%' AND document_status ='".$_GET['status']."' Limit $start , $perpage";
		}else{
			$where = "document_name like '%".$_GET['txt_search']."%' Limit $start , $perpage";
		}
	}else{
		$limit = "limit $start , $perpage";
	}
    $result = $sql->select("*","step_detail $limit","$status$where");
    $result_page = $sql->select("*","step_detail ","$status$where");
	$showpage = ceil($result_page->num_rows / $perpage);

?>
 
<style type="text/css">
	body{
		background-color: #f8f8f8;
	}
	form{
		border-radius: 9px;
		margin:24px;
		margin-top: 1%; 
		width: 240px; 
		font-size:14px; 
	}	
	input{
		margin-top: 12px;
	}
	input[type="text"]{ 
		border-radius: 3px;
		border-width: 0.1px;
		padding: 7px 3px;
		width:80%;

		text-align: center
	}
	input[type="submit"]{
		width: 80%;
		background-color:#ff9e52; 
		border:0;
		padding: 3px 0px;
		border-radius: 7px;
		color:black;
		font-size: 24px;
	}
	th,td{
		padding: 12px 5px;
		width: 30%;
		text-align: center
	}.footer {
    	position: fixed;
	    left: 0;
 	  	bottom: 0;
   	 	width: 100%;
   	 	height: 32px;
  	  	background-color: #bfbfbf;
   		color:white;
    	text-align: center;
    	padding-bottom: 5px;
    	padding-top: 5px;
	}
	th{
		background-color: <?php echo $sidebar_color; ?>
	}

</style>
<center> 
	
<div style="margin-left:  18px;">
		<?php 
			if($showpage>1){ 
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''AND($_GET['status']!='')){
						echo "<a href='document_house.php?page=$i&txt_search=".$_GET['txt_search']."&status=".$_GET['status']."' style='margin-right:20px'>$i</a>";
					}else if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='document_house.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='document_house.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
</div>

<table>
	<tr>
		<th>ชื่อเอกสาร</th>
		<th>วันที่อัพโหลด</th>
		<th></th>
	</tr>

<?php
	if($result->num_rows>0){
    	while ($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?php echo $row['document_name']; ?></td>
			<td><?php echo $row['date']; ?></td>
			<td><a href="file_upload/<?php echo $row['document_name']; ?>"> ดาวน์โหลด </a></td>
		</tr>
<?php
    	}
	}else{
		?>
		<tr>
			<td colspan="3"><center>ไม่พบข้อมูล</td>
		</tr>
<?php
	}
 ?>
 </table>
</center>

<div class="footer">©fitm 2019-2020</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="../js/jquery.js"></script> -->
     <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>
</html>