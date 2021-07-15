	<?php
require_once('top.php');
?>

		<center><h4> การดำเนินการ </h4></center>

 <?php 

 	$position_id = $_SESSION['position_id'];
 	$rsStep = $sql->select('step,version,type_id','step',"position_id='$position_id'");
 	$StepLength = $rsStep->num_rows;

 	$where = '';
 	$i=0;
 	if($StepLength>0){
 	while($rwStep = $rsStep->fetch_assoc()){
 		// echo "<script>alert('$i')</script>";
 		$version = $rwStep['version'];
 		$step = $rwStep['step'];
 		$type = $rwStep['type_id'];
 		$chk_step = $type."01";
 		$old_step = $step-1;
 		if($step==$chk_step ){
 			$old_step = 0;
 		}
 		
 		//echo "type = $type , version = $version , step = $step=2 , old_step = $old_step.!=2 <br>";
 		//$where = $where."(version ='$version' AND step='$step') OR ";
 		$where = $where." (activity.type='$type' AND activity.step='$step' AND activity.version='$version' AND activity.status_id!='2' AND activity.status_id!='7') OR";
 		$where = $where." (activity.type='$type' AND activity.step='$old_step' AND activity.version='$version' AND activity.status_id='2' AND activity.status_id!='7') OR";
		// echo $where = $where."(activity.step='$old_step'AND activity.status_id='3'AND version='$version')OR(activity.step='$step'AND activity.status_id!='3' AND version='$version') OR";
 	}
 		$where = substr($where,0,-2); 
 		$where = $where."AND status.status_id!='1'  AND activity.status_id!='7'";///เงื่อนไขเพิ่มเติม
 		// echo $where ;
		$rsActivity=$sql->select("activity.version,activity.type as type_id,activity.status_id,step,activity.date_create,activity_id,topic,activity_type.type,position.position as pos,status.status,activity.count","activity left join activity_type on activity.type = activity_type.activity_type_id left join status on activity.status_id = status.status_id left join person on activity.person_id = person.person_id left join position on person.position = position.position_id ","$where");
	}
 ?>
	  

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" name="txt_search" style="border-radius: 12px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>

<?php 
// print_r($_SESSION);
 ?>	

<!-- <a href="../html-link.htm" target="popup" onclick="window.open('../html-link.htm','name','width=600,height=400')">new window</a> เตรียมไว้ทำ -->


<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">รหัสงาน</th>
      <th style="border-top-width: 0;" scope="col">ฝ่ายเสนอ</th>
      <th style="border-top-width: 0;" scope="col">ส่งจาก</th>
      <th style="border-top-width: 0;" scope="col">หัวข้อ</th>
      <th style="border-top-width: 0;" scope="col">วันที่ยื่นเรื่อง</th>
      <th style="border-top-width: 0;" scope="col">สถานะ</th>
      <th colspan="2"style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    	<?php
    	if($StepLength>0){
    		$num=$rsActivity->num_rows;
			if($num>0){
				while($rwActivity=$rsActivity->fetch_assoc()){

						$type = $rwActivity['type_id'];
						$version = $_SESSION['type'][$type];

					if($rwActivity['step']==0){
						$old_position = $rwActivity['pos'];
					}else{
						$cal_step = $rwActivity['step'];
						$rsVersion = $sql->select('*',"step","step.step = '$cal_step' AND step.version ='$version'");
						$rwVersion = $rsVersion->fetch_assoc();
						$old_step = $rwVersion['step'] - 1;
						$rsPos = $sql->select('*','position',"position_id='$old_step'");
						$rwPos = $rsPos->fetch_assoc();
						$old_position = $rwPos['position'];
					}

					// echo $rwActivity['status_id'];
				if($rwActivity['status_id']==2){
					$status="รอรับเอกสาร";
				}else{
					$status = $rwActivity['status'];
					$old_position = " - ";
				}
				$step = $rwActivity['step'];
				$step -=1;
		?> 
		<input type="hidden" name="activity_id" value="<?php echo $rwActivity['activity_id']; ?>">
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
			<th scope="row"><?php echo $rwActivity['activity_id']; ?></th>
			<th scope="row"><?php echo $rwActivity['pos']; ?></th>
			<th scope="row"><?php echo $old_position; ?></th>
			<th scope="row"><?php echo $rwActivity['topic']; ?></th>	
			<th scope="row"><?php echo $rwActivity['date_create']; ?></th>
			<th scope="row"><center><?php echo $status; ?></th> 
			<th scope="row">
				<?php 
				$status = $rwActivity['status_id'];
				//echo $status;
				if($status=="2"){//// 2 is wait receiver accept
				 ?>
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $rwActivity['activity_id'] ?>">
  					ดูรายละเอียด</button>
<!-- Modal -->

		<div class="modal fade" id="exampleModal<?php echo $rwActivity['activity_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2><?php echo $rwActivity['topic']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        		<input type="hidden" name="id" value="<?php echo $rwActivity['activity_id']; ?>">
			        		<input type="hidden" name="step" value=" <?php echo $rwActivity['step']; ?> ">
			        		<input type="hidden" name="count" value=" <?php echo $rwActivity['count']; ?> ">
			        		<input type="hidden" name="version" value=" <?php echo $rwActivity['version']; ?> ">


			        		<tr>
			        			<th>เอกสารมาถึงวันที่</th>
			        			<th>อยู่มาแล้ว</th>
			        		</tr>

			        		<?php 
			        			$result2 = $sql->select('*','activity_detail',"activity_id='".$rwActivity['activity_id']."' ORDER BY activity_id DESC");
			        			$row2 = $result2->fetch_assoc();
			        			$date = $row2['date'];
			        			$date2 =substr($date,0,2); ///ดึงวันที่เข้ามา
			        			$date3 = date("d"); //ดึงวันที่ปัจุบัน
			        			$date4 =$date3 - $date2; //หาวันที่เอกสารเข้ามา

			        		?>
				        	<tr>

				        		<td><?php echo $date; ?></td> 
				        		<td><?php if($date4>0){echo $date4." วัน";}else{echo "ไม่ถึงหนึ่งวัน";} ?></td>
				        	</tr>

					</table>
      		  </div>
		      <div class="modal-footer">
		        <input type="submit" name="btn_receive" class="btn btn-primary" value="รับข้อมูล">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>

			
		<?php }
		else{
			?> 
				<a style="width: 106px" href="process.php?id=<?php echo $rwActivity['activity_id']; ?>" class="btn btn-primary">ดำเนินการต่อ</a>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manage<?php echo $rwActivity['activity_id']; ?>">
	  					แก้ไขสถานะ</button>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#goedit<?php echo $rwActivity['activity_id']; ?>">
	  					ส่งแก้เอกสาร</button>
			
			<?php
		} ?>	

		<div class="modal fade" id="manage<?php echo $rwActivity['activity_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"><?php echo $rwActivity['topic']; ?></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
				<form action="" method="POST">
		        	<table>
		        		<input type="hidden" name="id" value="<?php echo $rwActivity['activity_id'];?>">
		        		<input type="hidden" name="version" value="<?php echo $rwActivity['version'];?>">
		        		<input type="hidden" name="step" value="<?php echo $rwActivity['step'];?>">
		        		<input type="hidden" name="type_id" value="<?php echo $rwActivity['type_id'];?>">
		        		<input type="hidden" name="count" value="<?php echo $rwActivity['count'];?>">
		        		<tr>
		        			<td>
		        				<select name="status">
		        					<?php 
		        						$result7 = $sql->select('*','status',"status_id!='3'AND status_id!='2' AND status_id!='1'");
		        						while($row7=$result7->fetch_assoc()){ ?>
		        						<option value="<?php echo $row7['status_id']; ?>"><?php echo $row7['status']; ?></option>
		        					<?php } ?>
		        				</select>
		        			</td>
		        		</tr>
		        			<td colspan="2"><input type="submit" name="btn_change" value="ยืนยัน" class="btn btn-success">
		        				<input type="submit" class="btn btn-danger" name="btn_goback" value="ยกเลิกการรับเอกสาร"></td>
		        		</tr>
		        	</table> 
		        	</form>
				</div>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="goedit<?php echo $rwActivity['activity_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ส่งกลับ <?php echo $rwActivity['topic']; ?></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
				<form action="" method="POST">
		        	<table>
		        		<input type="hidden" name="id" value="<?php echo $rwActivity['activity_id'];?>">
		        		<input type="hidden" name="version" value="<?php echo $rwActivity['version'];?>">
		        		<input type="hidden" name="step" value="<?php echo $rwActivity['step'];?>">
		        		<input type="hidden" name="type_id" value="<?php echo $rwActivity['type_id'];?>">
		        		<input type="hidden" name="count" value="<?php echo $rwActivity['count'];?>">
		        		<tr>
		        			<td>หมายเหตุ</td>
		        		</tr>
		        		<tr>
		        			<td><textarea style="width: 240px;resize: vertical;"name="text_report"></textarea>
		        			</td>
		        		</tr>
		        		<tr>
		        			<td colspan="2"><input type="reset" value="ยกเลิก" class="btn btn-success">
		        				<input type="submit" class="btn btn-danger" name="btn_goedit" value="ส่งเรื่องกลับ"></td>
		        		</tr>
		        	</table> 
		        	</form>
				</div>
		    </div>
		  </div>
		</div>
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
		}else{
			echo "<tr><th colspan='6'><center>ไม่มีการดำเนินการที่เหลืออยู่</th></tr>";
		}
		?>
  </tbody>
</table>

<?php 
	if(isset($_POST['btn_goback'])){
		 $id = $_POST['id'];
		 $step = $_POST['step'];
		 $type_id = $_POST['type_id'];
		 $version = $_POST['version'];
		 $count = $_POST['count'];
		$old_step = $step - 1;
		if($old_step==$type_id * 100){
			$old_step = 0;
		}
		$count--;
		// echo $old_step;
		// echo $count;
		$rsActD = $sql->select('*','activity_detail',"activity_id='$id' AND count='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id =$rwActD['person_id'];
		
		$alert->sendLine($person_id,"","ทางฝ่ายรับได้ทำการทำยกเลิกการรับข้อมูล");
		$result = $sql->update('activity',"step='$old_step',status_id = '2',count = '$count'","activity_id='$id'");
		$person_id = $_SESSION['person_id'];
		$sql->insert('activity_detail',"activity_id , person_id , step ,status_id ,version ,date,count","'$id','$person_id','$step','4','$version','$date_now','$count'");

		echo "<script>('ยกเลิกการรับสำเร็จ')</script>";
		// $alert->link("0","index.php");
	}
	if(isset($_POST['btn_goedit'])){
		 $id = $_POST['id'];
		 $step = $_POST['step'];
		 $type_id = $_POST['type_id'];
		 $version = $_POST['version'];
		 $count = $_POST['count'];
		 $text_report = $_POST['text_report'];
		$old_step = $step - 1;
		if($old_step==$type_id * 100){
			$old_step = 0;
		}
		// echo $old_step;
		$count--;
		$rsActD = $sql->select('*','activity_detail',"activity_id='$id' AND count='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id =$rwActD['person_id'];

		$alert->sendLine($person_id,"","มีการส่งกลับแก้ไข กรุณาตรวจสอบเอกสารอีกครั้ง");

		$result = $sql->update('activity',"step='$old_step',status_id = '8',count = '$count'","activity_id='$id'");
		$person_id = $_SESSION['person_id'];
		$sql->insert('activity_detail',"activity_id , person_id , step ,status_id ,version ,date,count","'$id','$person_id','$step','8','$version','$date_now','$count'");
			echo "<script>('ส่งกลับแก้ไขสำเร็จ)</script>";
			// $alert->status("50");
			$alert->link("0","index.php");
	}
	if(isset($_POST['btn_change'])){////change status
		//print_r($_POST);
		$status = $_POST['status'];
		$id = $_POST['id'];
		$step = $_POST['step'];
		$version = $_POST['version'];
		$count = $_POST['count'];
		$old_count = $count;
		$count--;
		$rsActD = $sql->select('person_id',"activity_detail","activity_id ='$id' AND count ='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id = $rwActD['person_id'];//last owner

		$alert->sendLine($person_id,"",$status);

		$person_id = $_SESSION['person_id'];////my id
		$sql->insert('activity_detail','activity_id,status_id,date,version,step,person_id,count',"'$id','$status','$date_now','$version','$step','$person_id','$old_count'");
		$sql->update('activity',"status_id ='$status'","activity_id='$id'");
			$alert->status("30");
			$alert->link("0","index.php");

	} 
	if(isset($_POST['btn_receive'])){////recieve offer
		$id = $_POST['id'];
		$step = $_POST['step'];
		$version = $_POST['version']; 
		$count = $_POST['count'];
		// echo $step ;
		if($step==0){
			$step = $type."01";
			// echo "y";
		}else{
			// echo "n";
			$step = $step + 1;
		}
		// echo $step;
		$rsActD = $sql->select('person_id',"activity_detail","activity_id ='$id' ORDER BY activity_detail_id DESC");
		$rwActD = $rsActD->fetch_assoc();
		// echo "id = ".$id;
		$person_id = $rwActD['person_id'];//last owner
		// echo "personid = ".$person_id;

		$alert->sendLine($person_id,"","ฝ่ายรับยืนยันการดำเนินการแล้ว");
		
		$person_id = $_SESSION['person_id']; ///my id
		$count = (int)$count;
		$count = $count + 1;
		// echo $count;
		$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count',"'$id','$step','$version','3','$date_now','$person_id','$count'");
		$sql->update('activity',"status_id='3' ,step = '$step' , count ='$count'","activity_id ='$id'");
		$alert->link("0","index.php");
	}
?>
<?php
require_once('../bottom.php');
?>