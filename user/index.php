	<?php
require_once('top.php');
?>
		<center><h4> การดำเนินการ </h4></center>

 <?php 

	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 	$position_id = $_SESSION['position_id'];
 	$rsStep = $sql->select('step,version,type_id','step',"position_id='$position_id'");
 	$StepLength = $rsStep->num_rows;

 	if(isset($_GET['txt_search'])AND($_GET['txt_search']!="")){
 		$where = '((';
 	}else{
 		$where = '(';
 	}
 	$i=0;

 	$rsTarget = $sql->select("*","activity","pos_target ='$position_id'");

 	if($StepLength>0 OR $rsTarget->num_rows>0){
 		if($StepLength>0){
		 	while($rwStep = $rsStep->fetch_assoc()){
		 		$version = $rwStep['version'];
		 		$step = $rwStep['step'];
		 		$type = $rwStep['type_id'];
		 		$chk_step = $type."01";
		 		$old_step = $step-1;
		 		if($step==$chk_step ){
		 			$old_step = 0;
		 		}
		 		
		 		$where = $where." (activity.type='$type' AND activity.step='$step' AND activity.version='$version' AND activity.status_id!='2' AND activity.status_id!='7') OR";
		 		$where = $where." (activity.type='$type' AND activity.step='$old_step' AND activity.version='$version' AND activity.status_id='2' AND activity.status_id!='7') OR";
		 	}
 		}
 	if($StepLength>0){
 		$where = substr($where,0,-2); 
 		$where = $where." AND ";
 	}
 		$where = $where." status.status_id!='1'  AND activity.status_id!='7'";
 		if(isset($_GET['txt_search'])AND($_GET['txt_search']!="")){
 			$where = $where." )OR topic like '%".$_GET['txt_search']."%'";
 		}
 		if($StepLength>0){
 			$where = $where." )OR activity.pos_target = '$position_id'";
 		}else{
 			$where = $where." )AND activity.pos_target = '$position_id'";
 		}
		
		$rsActivity=$sql->select("activity.version,activity.type as type_id,activity.status_id,step,activity.date_create,activity_id,topic,activity_type.type,position.position as pos,status.status,activity.count","activity left join activity_type on activity.type = activity_type.activity_type_id left join status on activity.status_id = status.status_id left join person on activity.person_id = person.person_id left join position on person.position = position.position_id ","$where  LIMIT $start , $perpage");
		$result_page=$sql->select("activity.version,activity.type as type_id,activity.status_id,step,activity.date_create,activity_id,topic,activity_type.type,position.position as pos,status.status,activity.count","activity left join activity_type on activity.type = activity_type.activity_type_id left join status on activity.status_id = status.status_id left join person on activity.person_id = person.person_id left join position on person.position = position.position_id ","$where");
		$showpage = ceil($result_page->num_rows / $perpage);

	 	if( (isset($_GET['txt_search'])AND($_GET['txt_search']=="")) OR (empty(isset($_GET['txt_search'])))){
			$_SESSION['coming_work'] = $result_page->num_rows; 
		}
	} 
 ?>
	  

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" placeholder="หัวข้อ" name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>

<div style="float: right;margin-right: 18px;">
		<?php 
			if($StepLength>0 AND $showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='index.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='index.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>
<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">รหัสงาน</th>
      <th style="border-top-width: 0;" scope="col">ฝ่ายเสนอ</th>
      <th style="border-top-width: 0;" scope="col">ส่งจาก</th>
      <th style="border-top-width: 0;" scope="col">หัวข้อ</th>
      <th style="border-top-width: 0;" scope="col">วันที่</th>
      <th style="border-top-width: 0;" scope="col">สถานะ</th>
      <th style="border-top-width: 0;" scope="col"></th>
      <th colspan="2"style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>
	<tr>
    	<?php
 			if($StepLength>0 OR $rsTarget->num_rows>0){
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

						if($rwActivity['status_id']==2 OR $rwActivity['status_id']==8){
							$old_step = $rwVersion['step'];
						}else{
							$old_step = $rwVersion['step'] - 1;;
						}
						$old_step." ".$rwActivity['status_id'];
						$rsOldPos =$sql->select("*","step left join position on step.position_id = position.position_id","step='$old_step' AND version='$version' AND type_id='$type'")->fetch_assoc();
						$old_position = $rsOldPos['position'];
					}

				if($rwActivity['status_id']==2){
					$status="รอรับเอกสาร";
				}else{
					$status = $rwActivity['status'];
					$old_position = " - ";
				}
				$step = $rwActivity['step'];
				$step -=1;
			    $result2 = $sql->select('*','activity_detail',"activity_id='".$rwActivity['activity_id']."' ORDER BY activity_detail_id DESC");
			    $row2 = $result2->fetch_assoc();
			    $date = $row2['date'];
			    $date2 = intval(substr($date,0,2)); ///ดึงวันที่เข้ามา
			    $date3 = intval(date("d")); //ดึงวันที่ปัจุบัน
			    $date4 =$date3 - $date2; //หาวันที่เอกสารเข้ามา
			    // $date4 =6;
				if($date4>5){
					$date4 = " <span class='circle_text' style='background-color:red'>".$date4."</span> วัน";
				}else if($date4>3){
					$date4 = " <span class='circle_text' style='background-color:#ffc107'>".$date4."</span> วัน";
				}else if($date4>0){
					$date4 = " <span class='circle_text' style='background-color:#00c149'>".$date4."</span> วัน";
				}else if($date4==0){
					$date4 =  " <span style='text-decoration:underline'>ไม่ครบวัน</span>";
				}
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
			<th scope="row"><?php echo $date; ?></th>
			<th scope="row"><?php echo $status.$date4; ?></th>
			<th scope="row"><center></th> 
			<th scope="row"><center>
				<button  <?php echo $_SESSION['status']; ?> style="text-decoration: underline;border:none;background-color: #f8f9fa;"data-toggle="modal" data-target="#showDoc<?php echo $rwActivity['activity_id'] ?>">ดูเอกสาร</button>
				<div class="modal fade" id="showDoc<?php echo $rwActivity['activity_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      </div>
				      <div class="modal-body">
				        <h6>เอกสารในการดำเนินการ <?php echo $rwActivity['topic']; ?></h6>
				        <center>
							<table>
								<tr>
									<td>ชื่อเอกสาร</td>
									<td>ดาวน์โหลด</td>
								</tr>
								<?php 
									$activity_id = $rwActivity['activity_id'];
									$chk_step = $rwActivity['step'];
									$rsDtail = $sql->select("activity_detail_id,activity_detail.document_name as user_doc,step_detail.document_name as admin_doc","activity_detail left join step_detail on activity_detail.step_detail_id = step_detail.step_detail_id","activity_id='$activity_id' AND activity_detail.document_name!='' AND check_document!='reject'");

									while($rwDtail = $rsDtail->fetch_assoc()){
								?>
								<tr>
									<td>
										<?php echo ($rwDtail['admin_doc']!='')?$rwDtail['admin_doc'] :"อื่น ๆ" ?>
									</td>
									<td>
										<a href="../file_upload/<?php echo $rwDtail['user_doc'];?>">Download</a>		
									</td>
								</tr>
								<?php
									}
								?>

							</table>
						</div>
				    </div>
				  </div>
				</div>

			</th> 
			<th scope="row">
				<?php 
				$status = $rwActivity['status_id'];
				if($status=="2"OR$status=="8"){//// 2 is wait receiver accept
				 ?>
				<button <?php echo $_SESSION['status']; ?> type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $rwActivity['activity_id'] ?>">
  					ดูรายละเอียด</button>
<!-- Modal -->

		<div class="modal fade" id="exampleModal<?php echo $rwActivity['activity_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
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
		        			<input type="hidden" name="topic" value="<?php echo $rwActivity['topic'];?>">
		        			<input type="hidden" name="status" value="<?php echo $rwActivity['status_id'];?>">
		        			<input type="hidden" name="type" value="<?php echo $rwActivity['type_id'];?>">


			        		<tr>
			        			<th>เอกสารมาถึงวันที่</th>
			        			<th>อยู่มาแล้ว</th>
			        		</tr>

			        		
				        	<tr>

				        		<td><?php echo $date; ?></td> 
				        		<td><?php if($date4>0){echo $date4." วัน";}else{echo "ไม่ถึงหนึ่งวัน";} ?></td>
				        	</tr>
				        	
				        	<?php if($row2['note']!=""){ ?>
				        	
				        	<tr>
				        		<td colspan="2">หมายเหตุ</td>
				        	</tr>
				        	<tr>
				        		<td colspan="2"><?php echo $row2['note']; ?></td>
				        	</tr>
				        	
				        	<?php } ?>

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
				<a style="width: 106px" href="process.php?activity_id=<?php echo $rwActivity['activity_id']; ?>" class="btn btn-primary">ดำเนินการต่อ</a>
					<button <?php echo $_SESSION['status']; ?> type="button" class="btn btn-danger" data-toggle="modal" data-target="#manage<?php echo $rwActivity['activity_id']; ?>">
	  					แก้ไขสถานะ</button>
					<button <?php echo $_SESSION['status']; ?> type="button" class="btn btn-info" data-toggle="modal" data-target="#goedit<?php echo $rwActivity['activity_id']; ?>">
	  					ส่งแก้เอกสาร</button>
			
			<?php
		} ?>	

		<div class="modal fade" id="manage<?php echo $rwActivity['activity_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		      	<h6><?php echo $rwActivity['topic']; ?></h6>
		        <center>
				<form action="" method="POST">
		        	<table>
		        		<input type="hidden" name="id" value="<?php echo $rwActivity['activity_id'];?>">
		        		<input type="hidden" name="version" value="<?php echo $rwActivity['version'];?>">
		        		<input type="hidden" name="step" value="<?php echo $rwActivity['step'];?>">
		        		<input type="hidden" name="type_id" value="<?php echo $rwActivity['type_id'];?>">
		        		<input type="hidden" name="count" value="<?php echo $rwActivity['count'];?>">
		        		<input type="hidden" name="topic" value="<?php echo $rwActivity['topic'];?>">
		        		<?php 
							$result7 = $sql->select('*','status',"status_id>8");
							if($result7->num_rows>0){
		        		?>
		        		<tr>
		        			<td>แก้ไขสถานะ</td>
		        		</tr>
		        		<tr>
		        			<td>
		        				<select name="status">
		        					<?php 
		        						while($row7=$result7->fetch_assoc()){ ?>
		        						<option value="<?php echo $row7['status_id']; ?>"><?php echo $row7['status']; ?></option>
		        					<?php } ?>
		        				</select>
		        			</td>
		        		</tr>
		        		<tr>
		        			<td colspan="2">
		        				<input type="submit" name="btn_change" value="ยืนยัน" class="btn btn-success">
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>
		        				<hr>
		        			</td>
		        		</tr>
		        	<?php } ?>
		        		<tr>
		        			<td>หมายเหตุ</td>
		        		</tr>
		        		<tr>
		        			<td><textarea style="width: 240px;resize: vertical;"name="text_report"></textarea>
		        			</td>
		        		</tr>
		        		<tr>
		        			<td>
		        				<input type="submit" class="btn btn-danger" name="btn_goback" value="ยกเลิกการรับเอกสาร">
		        			</td>
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
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <h6>ส่งกลับ <?php echo $rwActivity['topic']; ?></h6>
		        <center>
				<form action="" method="POST">
		        	<table>
		        		<input type="hidden" name="id" value="<?php echo $rwActivity['activity_id'];?>">
		        		<input type="hidden" name="version" value="<?php echo $rwActivity['version'];?>">
		        		<input type="hidden" name="step" value="<?php echo $rwActivity['step'];?>">
		        		<input type="hidden" name="type_id" value="<?php echo $rwActivity['type_id'];?>">
		        		<input type="hidden" name="count" value="<?php echo $rwActivity['count'];?>">
		        		<input type="hidden" name="topic" value="<?php echo $rwActivity['topic'];?>">
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
					echo "<tr><th colspan='8'><center>ไม่พบข้อมูลที่เกี่ยวกับ \" ".$_GET['txt_search']." \"</center></th></tr>";
				}else{
					echo "<tr><th colspan='8'><center>ไม่พบข้อมูล</center></th></tr>";
				}
			}
		}else{
			echo "<tr><th colspan='8'><center>ไม่มีการดำเนินการที่เหลืออยู่</th></tr>";
		}
		?>
	</tr>
  </tbody>
</table>
<!-- สถานะ<br> -->
<!-- <span class="circle_text" style="color:red">0</span> รอการดำเนินการมากกว่า 5 วัน <br>
<span class="circle_text" style="color:#ffc107;background-color:#ffc107">0</span> รอการดำเนินการมากกว่า 3 วัน<br>
<span class="circle_text" style="color:#00c149;background-color:#00c149">0</span> รอการดำเนินการไม่เกิน 3 วัน -->

<?php 
	if(isset($_POST['btn_goback'])){
		 $id = $_POST['id'];
		 $step = $_POST['step'];
		 $type_id = $_POST['type_id'];
		 $version = $_POST['version'];
		 $topic = $_POST['topic'];
		 $count = $_POST['count'];
		 $text_report = $_POST['text_report'];
		$old_step = $step - 1;
		if($old_step==$type_id * 100){
			$old_step = 0;
		}
		$count--;
		$rsActD = $sql->select('*','activity_detail',"activity_id='$id' AND count='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id =$rwActD['person_id'];
		
		$alert->sendLine($person_id,"","ทางฝ่ายรับได้ทำการทำยกเลิกการรับข้อมูล",$topic);
		$result = $sql->update('activity',"step='$old_step',status_id = '2',count = '$count'","activity_id='$id'");
		$person_id = $_SESSION['person_id'];
		$sql->insert('activity_detail',"activity_id , person_id , step ,status_id ,version ,date,count,note","'$id','$person_id','$step','4','$version','$date_now','$count','$text_report'");

		echo "<script>alert('ยกเลิกการรับสำเร็จ')</script>";
		$alert->link("0","index.php");
	}
	if(isset($_POST['btn_goedit'])){
		$id = $_POST['id'];
		$step = $_POST['step'];
		$type_id = $_POST['type_id'];
		$version = $_POST['version'];
		$topic = $_POST['topic'];
		$count = $_POST['count'];
		$text_report = $_POST['text_report'];
		$old_step = $step - 1;
		if($old_step==$type_id * 100){
			$old_step = 0;
		}
		$count--;
		$rsActD = $sql->select('*','activity_detail',"activity_id='$id' AND count='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id =$rwActD['person_id'];

		$alert->sendLine($person_id,"","มีการส่งกลับแก้ไข กรุณาตรวจสอบเอกสารอีกครั้ง",$topic);

		$result = $sql->update('activity',"step='$old_step',status_id = '8',count = '$count'","activity_id='$id'");
		$person_id = $_SESSION['person_id'];
		$sql->insert('activity_detail',"activity_id , person_id , step ,status_id ,version ,date,count,note","'$id','$person_id','$step','8','$version','$date_now','$count','$text_report'");
		echo "<script>alert('ส่งกลับแก้ไขสำเร็จ)</script>";
		$alert->link("0","index.php");
	}
	if(isset($_POST['btn_change'])){////change status
		$status = $_POST['status'];
		$id = $_POST['id'];
		$step = $_POST['step'];
		$version = $_POST['version'];
		$count = $_POST['count'];
		$topic = $_POST['topic'];
		$old_count = $count;
		$count--;
		$rsActD = $sql->select('person_id',"activity_detail","activity_id ='$id' AND count ='$count'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id = $rwActD['person_id'];//last owner
		$rsSta = $sql->select("*","status","status_id = '$status'")->fetch_assoc();
		$status_mes = $rsSta['status'];
		$Message = $topic.":".$status_mes;
		$alert->sendLine($person_id,"",$Message,$topic);

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
		$topic = $_POST['topic'];
		$status = $_POST['status'];
		$type = $_POST['type'];
		if($step==0){
			$step = $type."01";
			$rsActD = $sql->select('person_id',"activity","activity_id ='$id'");
			$rwActD = $rsActD->fetch_assoc();
			$person_id = $rwActD['person_id'];//last owner
			$alert->sendLine($person_id,"","ฝ่ายรับยืนยันการดำเนินการแล้ว",$topic);
		}else{
			$step = $step + 1;
			$rsActD = $sql->select('*',"activity_detail","activity_id ='$id' ORDER BY activity_detail_id DESC");
			$rwActD = $rsActD->fetch_assoc();
			$person_id = $rwActD['person_id'];//last owner
			$alert->sendLine($person_id,"","ฝ่ายรับยืนยันการดำเนินการแล้ว",$topic);
		}
		if($status=='8'){$step = $step -1 ;}
		// echo "person_id:".$person_id;

		
		$person_id = $_SESSION['person_id']; ///my id
		$count = (int)$count;
		$count = $count + 1;
		$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count',"'$id','$step','$version','3','$date_now','$person_id','$count'");
		$sql->update('activity',"status_id='3' ,step = '$step' , count ='$count'","activity_id ='$id'");
		$alert->link("0","index.php");
	}
?>
<?php
require_once('../bottom.php');
?>