<?php
require_once('top.php');
?>

		<center><h4> รอดำเนินการ </h4></center>

<?php 
	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}' AND topic like '%".$_GET['txt_search']."%' ORDER BY activity_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}' AND topic like '%".$_GET['txt_search']."%'");
 		}else{	
			//$result=$sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}' ORDER BY activity_id DESC LIMIT $start , $perpage");
			$result=$sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}' ORDER BY activity_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}'");
 		}
		
	$showpage = ceil($result_page->num_rows / $perpage);


 ?>
	<form style="margin-left: 3%;" action="" method="POST">
		<input type="text" class="txt_search"  placeholder="หัวข้อ"  name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal1"  <?php echo $_SESSION['status']; ?>>เสนอความต้องการ</button>
		<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2>เสนอความต้องการ</h2>
			        <table>
			        		<tr>
			        			<td>หัวข้อ</td>
			        			<td><input style="width: 130px;" type="text" name="topic"></td>
			        		</tr>
			        		<tr>

			        			<td>ความต้องการ</td> 
			        			<td>
				        		<select style="width: 130px;" name="type">
						      		<?php 
						      			$rsType = $sql->select('*','activity_type','');
						      			while($rwType = $rsType->fetch_assoc()){
						      		 ?>
						      				<option value="<?php echo $rwType['activity_type_id']; ?>"><?php echo $rwType['type']; ?></option>
						      		<?php 
						      		} ?>
						      	</select>
						      	</td>
				        	</tr>
					</table>
      		  </div>
		      <div class="modal-footer">
		        <input type="submit" name="btn_add" class="btn btn-primary" value="ยืนยัน">
				
		      </div>
		    </div>
		  </div>
		</div>


	</form>
 
	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='my_activity.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='my_activity.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>

<table class="table table"> 
	<style type="text/css">
		.table th{
			border-top: none;
		}
	</style>

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">รหัสงาน</th>
      <th style="border-top-width: 0;" scope="col">หัวข้อ</th>
      <th style="border-top-width: 0;" scope="col">วันที่</th>
      <th style="border-top-width: 0;" scope="col"></th> 
      <th style="border-top-width: 0;" scope="col"></th> 
      <th style="border-top-width: 0;" scope="col"></th> 
    </tr>
  </thead>
  <tbody>
	<tr>
    	<?php
			if($result->num_rows>0){
				while($row=$result->fetch_assoc()){

			    $result2 = $sql->select('*','activity_detail',"activity_id='".$row['activity_id']."' ORDER BY activity_detail_id DESC");
			    $row2 = $result2->fetch_assoc();
			    $date = $row2['date'];
			    $date2 =substr($date,0,2); ///ดึงวันที่เข้ามา
			    $date3 = date("d"); //ดึงวันที่ปัจุบัน
			    $date4 =$date3 - $date2; //หาวันที่เอกสารเข้ามา 
				if($date4>5){
					$date4 = " อยู่มาแล้ว <span class='circle_text' style='background-color:red'>".$date4."</span> วัน";
				}else if($date4>3){
					$date4 = " อยู่มาแล้ว <span class='circle_text' style='background-color:#ffc107'>".$date4."</span> วัน";
				}else if($date4>0){
					$date4 = " อยู่มาแล้ว <span class='circle_text' style='background-color:#00c149'>".$date4."</span> วัน";
				}else{
					$date4 =  "ไม่ถึงหนึ่งวัน";
				}
					$actD = $sql->select("*","activity_detail","activity_id='".$row['activity_id']."' ORDER BY activity_detail_id DESC")->fetch_assoc();
					$note = $actD['note'];
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
			<th scope="row"><?php echo $date; ?></th>
			<th scope="row"><?php echo $date4; ?></th>
			
			<?php if($note!=''){
			?> 
			<th>
			   <button type="button" style="border:0 none;" data-toggle="modal" data-target="#note<?php echo $row['activity_id']; ?>">ดูหมายเหตุ</button>
				<div class="modal fade" id="note<?php echo $row['activity_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header"> 
				        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      </div>
				      <div class="modal-body">
				      	<h6>หมายเหตุ</h6>
				      	<span><?php echo $actD['note']; ?></span>
		      		  </div> 
				    </div>
				  </div>
				</div>
			</th>
			<?php
			}else{echo "<th></th>";} ?>
			<th scope="row">
				<?php if(($row['status_id']==1 )OR ($row['status_id']==8)){?>
					<a  href="process.php?activity_id=<?php echo $row['activity_id']; ?>"  class="btn btn-primary"><?php if($row['status_id']==1 ){ echo "เริ่มดำเนินการ";
						}else{echo"แก้ไขเอกสาร";} ?>
					</a>
				<?php } ?>
				
			</th> 
		

		</tr> 

		<?php 
				}
			}else{
				if(isset($_GET['txt_search']) AND $_GET['txt_search']!=""){
					echo "<tr><th colspan='6'><center>ไม่พบข้อมูลที่เกี่ยวกับ \" ".$_GET['txt_search']." \"</center></th></tr>";
				}else{
					echo "<tr><th colspan='6'><center>ไม่พบข้อมูล</center></th></tr>";
				}
			}
		?>
	</tr>
  </tbody>
</table>



<?php
require_once('../bottom.php');
	if(isset($_POST['btn_add'])){////offer adding
			 $type = $_POST['type'];
			 $topic = $_POST['topic'];
			 $person_id = $_SESSION['person_id'];
			 $version = $_SESSION['type'][$type];
			$sql->insert('activity','topic,type,person_id,date_create,status_id,version,count',"'$topic','$type','$person_id','$date_now','1','$version','0'");
			$rsAct =$sql->select('activity_id,version','activity','1 ORDER by activity_id DESC');
			$rwAct = $rsAct->fetch_assoc();
			$id = $rwAct['activity_id'];
			$version = $rwAct['version'];
			$person_id = $_SESSION['person_id'];
			$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count',"'$id','0','$version','1','$date_now','$person_id','0'");

			echo "<script>alert('เพิ่มความต้องการสำเร็จ')</script>";
			$alert->link('0','my_activity.php');
		}
	
?>
