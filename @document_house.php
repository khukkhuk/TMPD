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

<!DOCTYPE html>
<html>
<head>
	<title>Document House</title>
</head>
<body>

<style type="text/css">
	body{
		background-color: #f8f8f8;
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

</style>
<center>
<form method="GET">
	กรอกชื่อเอกสาร <input type="text" name="txt_search" value="<?php if(isset($_GET['txt_search'])AND($_GET['txt_search']!="")){echo $_GET['txt_search'];} ?>"> 
	<input type="submit" name="" value="ค้นหา"><br>
	<input type="radio" name="status" <?php if(isset($_GET['status'])AND($_GET['status']=="on")){echo "checked";} ?> value="on"> เฉพาะที่เปิดการใช้งาน<br>
	<input type="radio" name="status" <?php if(isset($_GET['status'])AND($_GET['status']=="off")){echo "checked";} ?> value="off"> เฉพาะที่ปิดการใช้งาน<br>
	<input type="radio" name="status" <?php if((isset($_GET['status'])AND($_GET['status']=="all"))OR empty($_GET['status'])){echo "checked";} ?> value="all"> ทั้งหมด
</form>
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

<div class="footer"><img style="width:33px;margin-bottom:-10px ;margin-right: 1%;position: relative;" src="login/kmutnb_2.png"> มหาวิทยาลัยเทคโนโลยีพระจอมเกล้าพระนครเหนือ คณะเทคโนโลยีและการจัดการอุตสาหกรรม<img  style="width:70px;margin-bottom:-10px; ;margin-left: 1%;position: fixed;" src="login/fitm_t.png"></div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="../js/jquery.js"></script> -->
     <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

</body>
</html>