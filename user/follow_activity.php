<?php
require_once('top.php');
?>

		<center><h4> ติดตามการดำเนินการ </h4></center>

<?php 
	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
	$acttype= "";
	if(isset($_GET['activity_type'])AND $_GET['activity_type']!='all'){
		$acttype = "AND activity.type = '".$_GET['activity_type']."'";
	}
 	if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
		$result=$sql->select("*","activity","person_id='{$_SESSION['person_id']}' AND status_id != '7' AND topic like '%".$_GET['txt_search']."%' ORDER BY activity_id DESC LIMIT $start , $perpage");
		$result_page=$sql->select("*","activity","person_id='{$_SESSION['person_id']}' AND status_id != '7' AND topic like '%".$_GET['txt_search']."%'");
 	}else{
		$result=$sql->select("*","activity","person_id='{$_SESSION['person_id']}' AND status_id != '7' ORDER BY activity_id DESC LIMIT $start , $perpage");
		$result_page=$sql->select("*","activity","person_id='{$_SESSION['person_id']}'  AND status_id != '7'");
 	}
		
	$showpage = ceil($result_page->num_rows / $perpage);


 ?>
	<form style="margin-left: 3%;float: left;" action="" method="GET">
		<input type="text" class="txt_search"  placeholder="หัวข้อ"  name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<select name="activity_type">
			<option selected disabled>เลือกประเภทการดำเนินการ</option>
			<option value="all">ดูทั้งหมด</option>
			<?php 
				$rsAcT = $sql->select("*","activity_type","");
				while($rwAcT = $rsAcT->fetch_assoc()){
					if($_GET['activity_type']==$rwAcT['activity_type_id']){
						$show_type = $rwAcT['type'];
					}
					echo "<option value='".$rwAcT['activity_type_id']."'>".$rwAcT['type']."</option>";
				}
			 ?>
		</select>
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>
	<div style="float: right;margin-right: 5%;"><?php if(isset($show_type)) echo $show_type; ?> มี <?php echo $result_page->num_rows; ?> การดำเนินการ</div>

	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='follow_activity.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='follow_activity.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>


<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">รหัสงาน</th>
      <th style="border-top-width: 0;" scope="col">หัวข้อ</th>
      <th style="border-top-width: 0;" scope="col">วันที่ยื่นเรื่อง</th>      
    </tr>
  </thead>
  <tbody>
	<tr>
    	<?php
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){		
				$result2 = $sql->select('*','activity_detail',"activity_id='".$row['activity_id']."' ORDER BY activity_detail_id ASC");
			    $row2 = $result2->fetch_assoc();
			    $date = $row2['date'];
			    $date2 =substr($date,0,2); ///ดึงวันที่เข้ามา
			    $date3 = date("d"); //ดึงวันที่ปัจุบัน
			    $date4 =$date3 - $date2; //หาวันที่เอกสารเข้ามา
			    // $date4 =6;
				if($date4<1){
					$date4 = "ไม่ถึงหนึ่งวัน";
				}else{
					$date4 = "ดำเนินการมาแล้ว ".$date4." วัน";
				}
					
		?> 
		<input type="hidden" name="activity_id" value="<?php echo $row['activity_id']; ?>">
		<style type="text/css">
			th,td{
				text-align: center;
			}
			.table td{
				border-top:0px solid white;
			}
			button{
			}
		</style>
		<tr> 
			<th scope="row"><?php echo $row['activity_id']; ?></th>	
			<th scope="row"><?php echo $row['topic']; ?></th>	
			<th scope="row"><?php echo $row['date_create']; ?></th> 
			<th scope="row"><?php echo $date4; ?></th> 			
			<th scope="row"><a href="../track.php?id=<?php echo $row['activity_id']; ?>" target="_blank" class="btn btn-primary">ติดตามการดำเนินการ</a>
			<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#<?php echo $row['activity_id'] ?>">
  				แก้ไขข้อมูล</button><div class="modal fade" id="<?php echo $row['activity_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		      	<form method="POST">
		      		หัวข้อ <input type="text" name="topic" value="<?php echo $row['topic']; ?>">
		      		<input type="hidden" name="activity_id" value="<?php echo $row['activity_id']; ?>">
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="ล้าง"> 
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="บันทึกข้อมูล">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div></th> 


		</tr> 

		<?php 
				}
			}else{
				if(isset($_GET['txt_search']) AND $_GET['txt_search']!=""){
					echo "<tr><th colspan='5'><center>ไม่พบข้อมูลที่เกี่ยวกับ \" ".$_GET['txt_search']." \"</center></th></tr>";
				}else{
					echo "<tr><th colspan='5'><center>ไม่พบข้อมูล</center></th></tr>";
				}
			}
		?></tr>
  </tbody>
</table>



<?php
require_once('../bottom.php');
?>
<?php 
if(isset($_POST['btn_edit'])){
		if($_POST['topic']==""){
			echo "<script>alert('กรุณากรอกข้อมูล')</script>";
		}else{
			$topic = $_POST['topic'];
			$id =  $_POST['activity_id'];
			$sql->update('activity',"topic = '$topic'","activity_id = '$id'");
			$alert->status("30");
			$alert->link('0','follow_activity.php');
		}
	} ?>