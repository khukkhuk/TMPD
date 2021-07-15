<?php
require_once('top.php');
?>
	<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> 

	<?php
	$id = $_GET['activity_id']; 
	$count_doc =0;
	$numberofdocument =0;
	$Chk = $sql->select("*","activity_detail","activity_id='$id'");
	 $num_Chk = $Chk->num_rows;
	 // $select = "activity.version ,activity.type,activity.step,activity.count,activity.topic,activity_type.type as type_name ";
	 $select = 	"*";
	$rsActivity = $sql->select($select,'activity left join activity_type on activity.type = activity_type.activity_type_id',"activity_id='$id'");
	$rwActivity = $rsActivity->fetch_assoc();
	$version = $rwActivity['version'];
	$step = $rwActivity['step'];
	$type = $rwActivity['type'];
	$count = $rwActivity['count'];
	$topic = $rwActivity['topic'];
	$rsType = $sql->select("*","activity_type","type='$type'");
	$rwType = $rsType->fetch_assoc();
	$type_id = $rwType['activity_type_id'];
	$old_step = $step;
	//echo $version.$step.$type;
	// echo $type;
	// echo $type_id;
	$select_type = $sql->select("*","activity","activity_id='$id'")->fetch_assoc();
	$select_type_id = $select_type['type'];

	if($step==0){
		$step = $type."01";
	}

	$rsActD  = $sql->select("*","activity_detail","activity_id='$id'");
	$chkrow = $rsActD->num_rows;
		$from = "step_detail.step = '$step' AND step_detail.version='$version' AND step_detail.document_status!='off'";
	if($chkrow==1){
		$from = "step_detail.step = '0' AND step_detail.version='$version' AND step_detail.document_status!='off'";
	}
	
	$rsSDetail = $sql->select('*','step_detail',$from); 

	?>
<style type="text/css">
	table thead th{
		
	}
	input[type=text]{
	    padding: 5px 10px;
	    border-radius: 4px;
	    border-width: 1px;
	    background-color: #373737;
	    border-color: black;

	    border-style: solid;
	}
</style>


	<center><h4>เสนอความต้อง<br><?php echo $rwActivity['topic']; ?> ประเภท <?php echo $rwActivity['type']; ?></h4></center> 

	<table class="table table-striped" style="margin-left:5%;width: 90%;text-align: center">
	<thead>
		<tr>
			<td colspan="4">ไฟล์ที่เกี่ยวข้อง</td>
		</tr>
	    <tr>
	      <th colspan>ชื่อไฟล์</th>
	      <th colspan>ดาวน์โหลด</th>
	      <th colspan></th>
	      <th colspan>สถานะ</th>
	    </tr>
	    	<?php
	    	// echo $type;
	    		if($rsSDetail->num_rows>0){
	    			$i =1;
	    	 while($rwSDetail = $rsSDetail->fetch_assoc()){
	    	 		$numberofdocument++;
	    	 		$step_detail_id = $rwSDetail['step_detail_id'];
	    	 		$result = $sql->select("*","activity_detail","activity_id='$id' AND step_detail_id ='$step_detail_id' AND check_document!='reject' AND document_name !=''");
	    	 		$rowdata = $result->fetch_assoc();
	    	 		$docname = $rowdata['document_name'];
	    	  ?>
	    		<tr>
		      			<td><?php echo $rwSDetail['document_name'];?></td> 
		  				<td><a target="_blank" href="../file_upload/<?php echo $rwSDetail['document_name']; ?>"><i class="fas fa-arrow-alt-circle-down"></i></a></td>
		  				<td>
			  				<form enctype="multipart/form-data" method="post">
			  					<input type="hidden" name="type" value="<?php echo $step_detail_id;?>">
				  				<input type="hidden" name="version" value="<?php echo $version; ?>">
					  			<input type="hidden" name="person_id" value="<?php echo $_SESSION['person_id']; ?>">
					  			<input type="hidden" name="step" value="<?php echo $step; ?>">
					  			<input type="hidden" name="activity_id" value="<?php echo $id; ?>">
					  			<input type="file" name="upload"> 
					  			<input type="submit" name="btn_upload" value="Upload" onclick="return confirm('ยืนยันการส่งข้อมูล');" >
			  				</form>
						</td>
		  				<td><?php if($docname!=""){echo "<span style='color:green'>ส่งแล้ว</span>";$count_doc++;}else{echo "<span style='color:red'>ยังไม่ส่ง</span>";} ?></td>	
	  			</tr>
	  			
	  		<?php 
	  			$i++;
	  		 }
	  		 ?> 




	  <thead>
	  	<tr>
	  		<td colspan="4">อัพโหลดไฟล์</td>
	  	</tr>
	  	

	  		<?php 
	  		$saveStep = $step ;
	  		if($chkrow==1){
	  			$step = 0;
	  		}
					$rsSDetail2 = $sql->select('*','step_detail',"step = '$step' AND version='$version' AND document_status!='off'"); 

					$rsSDetail2->num_rows;
			$step = $saveStep;
			 ?>
	  	 
	  	<tr>
	  		<td colspan="4">
	  			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal1">เอกสารที่อัพโหลดแล้ว</button>
					<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					      </div>
					      <div class="modal-body">
					        <center><h2></h2>
						        <table>
						        		<tr>
						        			<td>ลำดับ</td>
						        			<td>ชื่อเอกสาร</td>
						        			<td><center>เอกสารที่อัพโหลดแล้ว</center></td>
						        			<td></td>
						        		</tr>
						        		<?php 
						        			// $rsActDetail = $sql->select('activity_detail_id,step_detail.document_name as admin_doc,activity_detail.document_name as user_doc','activity_detail left join step_detail on activity_detail.step_detail_id = step_detail.step_detail_id',"activity_id='$id' AND activity_detail.version='$version' AND activity_detail.step ='$step' AND check_document!='reject' ");
						        			$rsActDetail = $sql->select("activity_detail_id,activity_detail.document_name as user_doc,step_detail.document_name as admin_doc","activity_detail left join step_detail on activity_detail.step_detail_id = step_detail.step_detail_id","activity_id='$id' AND activity_detail.document_name!='' AND check_document!='reject' AND step_detail.step = '$step' AND step_detail.version ='$version'");
						        			if($rsActDetail->num_rows>0){
						        				$i=1;
						        				while($rwActDetail = $rsActDetail->fetch_assoc()){
						        					?>
						        					<tr>
														<td><?php echo $i++; ?></td>
														<td><?php echo ($rwActDetail['admin_doc']=='')? "อื่น ๆ" : $rwActDetail['admin_doc'] ; ?></td>
														<td><a style="text-decoration-line: underline;" href="../file_upload/<?php echo $rwActDetail['user_doc']; ?>"><?php echo $rwActDetail['user_doc']; ?></a></td>
														<td>
															<form method="POST" action="" id="del<?php echo $rwActDetail['activity_detail_id']; ?>">
																<input type="hidden" name="act_id" value="<?php echo $id; ?>">
																<input type="hidden" name="d_id" value="<?php echo $rwActDetail['activity_detail_id']; ?>">
																<input style="border:0;text-decoration-line: underline;" type="submit" name="btn_del" value="ลบเอกสาร">
															</form>
														</td>
						        					</tr>
						        					<?php
						        				}
						        			}else{
						        				echo "<tr><td colspan='4'><center>ไม่พบข้อมูล</td></tr>";
						        			}

						        		 ?>
						        		
								</table>
			      		  </div>
					      <div class="modal-footer">
							
					      </div>
					    </div>
					  </div>
					</div>

	  	<?php 
	  		}else{
	  	?>
	  			<tr><td colspan='4'>ไม่มีเอกสารในขั้นตอนนี้</td></tr>
	  	<?php
	  		}
	  	?>
	  	<?php
	  	if($count_doc==$numberofdocument){
	  	?>
	  	<?php
	  		$step = $rwActivity['step'];
	  		// echo "step :".$step;

		  	// $step = is_int($step);
		  	///////////หาขั้นตอนถัดไปว่าเป็นขั้นตอนแบบตัวเลือกไหมโดยใช้ position_type เป็นตัวกำหนดรูปแบบของตำแหน่ง
		  	if($step==0){
				$up_step = $type_id."01";
			}else{
				$up_step = $step +1;
			}
			// echo "up step : ".$up_step;
		  	$rsSp = $sql->select("*","step","step = '$up_step' AND version ='$version'");
		  	$rwSp = $rsSp->fetch_assoc();
		  	$pos_id = $rwSp['position_id'];
		  	$rsPt = $sql->select("*","position_type","position_title='$pos_id'");
		  	if($rsPt->num_rows>0){
			  	$rwPt = $rsPt->fetch_assoc();
			  	$pos_type =$rwPt['position_type_id'];

			  	$rsPt = $sql->select("*","position","position_type_id='$pos_type'");
			  	echo "

			  	<tr><td colspan='4'>

			  			<form method='POST' name='form2' action=''>
								เลือกตำแหน่งที่ต้องการดำเนินการต่อ
						  		<select name='pos_target'>

			  	";
			  	while($row = $rsPt->fetch_assoc()){
			  		if($row['position_id']!=$pos_id){
			  		?>

			  		<option value="<?php echo $row['position_id']; ?>"><?php echo $row['position']; ?></option> 
			  		<?php
			  		}
			  	}

			  	echo "			</select> 
						  		<input type='hidden' name='activity_id' value='$id'>
						  		<input type='hidden' name='old_step' value='$old_step'>
						  		<input type='hidden' name='tp_id' value='$type_id'>
						  		<input type='hidden' name='num_Chk' value='$num_Chk'>
						  		<input type='hidden' name='version' value='$version'>
						  		<input type='hidden' name='count' value='$count'>
						  		<input type='hidden' name='topic' value='$topic'>
						  		<input type='submit' name='btn_sub' class='btn btn-success' onclick='return confirm(\"ยืนยันการส่งข้อมูล\");' value='ส่งข้อมูล'>
						  	</form>
			  	</td></tr>";
		  	}else{
		  	 ?>
		  			<tr>
		  				<td colspan="4">
		  					<form method="POST" name="form1" action="">
						  		<?php
							  		$rsSt = $sql->select("*","step","version='$version' AND step='".$rwActivity['step']."'");
							  		$rwSt = $rsSt->fetch_assoc();
							  		$action_type = $rwSt['action_type'];
							  		 if($action_type=="two_way"){
							  			echo "<input type=\"submit\" name=\"btn_sub_two\" class=\"btn btn-success\" onclick=\"return confirm('ยืนยันการส่งข้อมูล');\" value=\"จบการดำเนินการ\">";
							  		}
						  		?>
						  		<input type="hidden" name="activity_id" value="<?php echo $id; ?>">
						  		<input type="hidden" name="old_step" value="<?php echo $old_step; ?>">
						  		<input type="hidden" name="tp_id" value="<?php echo $type_id; ?>">
						  		<input type="submit" name="btn_sub" class="btn btn-success" onclick="return confirm('ยืนยันการส่งข้อมูล');" value="ส่งข้อมูล">
						  		<input type="hidden" name="topic" value="<?php echo $topic; ?>">
						  		<input type="hidden" name="num_Chk" value="<?php echo $num_Chk; ?>">
						  		<input type="hidden" name="version" value="<?php echo $version; ?>">
						  		<input type="hidden" name="count" value="<?php echo $count; ?>">
						  	</form>
		  				</td>
		  			</tr>
		  	<?php } ?>
	  	<?php } ?>
	  </thead>
	</table> 

<?php
	require_once('../bottom.php');
?> 
<?php 
	if(isset($_POST['btn_upload'])){  
	    $activity_id = $_POST['activity_id'];
	    $step = $_POST['step'];
	    $version = $_POST['version']; 
	    $person_id = $_POST['person_id'];
	    $step_detail_id = $_POST['type'];
	 
	    if($_FILES['upload']['name']==''){
	    	echo "<script>alert('กรุณาเลือกไฟล์ที่ต้องการส่ง')</script>";
	    }else{
	        $rsActivityDetail = $sql->select('*','activity_detail',"activity_id = '$activity_id' AND step ='$step' ");
	        $rwActivityDetail = $rsActivityDetail->fetch_assoc();
	        if($rwActivityDetail!=null){
	        	$id = $rsActivityDetail->num_rows;
	        }else{
	        	$id = 0;
	        }
	        $id++;
	        $document_name = $activity_id."_".$step."_".$id;
	        $name = $_FILES['upload']['name'];
	        $cut = strstr($name,".");

	    	copy($_FILES['upload']['tmp_name'],"../file_upload/".$document_name.$cut);
	        $ch = $document_name.$cut;
	        
	        date_default_timezone_set("Asia/Bangkok");
	         $time1 = date("d/m/"); $time2=date(" H:i:s");
	         $year = date("Y")+543;
	         $date_now =  $time1.$year.$time2;

	        $rs = $sql->insert('activity_detail','activity_id,step,document_name,version,step_detail_id,date,person_id',"'$activity_id','$step','$ch','$version','$step_detail_id','$date_now','$person_id'");
	    	echo "<script>alert('อัพโหลดไฟล์สำเร็จ')</script>";
	    	$alert->link("0","process.php?activity_id=".$activity_id);
	    }
	}
	if(isset($_POST['btn_del'])){
		$act_id = $_POST['act_id'];
		$d_id = $_POST['d_id'];

		$sql->update("activity_detail","check_document='reject'","activity_detail_id='$d_id'");
		$alert->status("20");
		$alert->link("0","process.php?activity_id=".$act_id);
	}
	if(isset($_POST['btn_sub'])){
		// echo print_r($_POST);
		if(isset($_POST['pos_target'])){
			// echo "pos target !";
			$target = $_POST['pos_target'];
		}
		// echo print_r($_POST);
		$type_id = $_POST['tp_id'];
		$id = $_POST['activity_id'];
		$step = $_POST['old_step'];
		$version = $_POST['version'];
		$num_Chk  = $_POST['num_Chk'];
		$count  = $_POST['count'];
		$topic  = $_POST['topic'];
		$person_id = $_SESSION['person_id'];
		$rsPos = $sql->select("*","step","type_id='$type_id' AND version='$version' ORDER BY step DESC"); //หา step สุดท้าย
		$rwPos = $rsPos->fetch_assoc();
		// echo $type_id;
		$last_step = $rwPos['step'];
		
		if($num_Chk>=0){	
			$step;
		}else{
			$step = 0;
		}
		$update = "step='$step',status_id='2'";
		
		$temp = '2';
		if($step == $last_step){
			$update = "finish = '$date_now',step='$step',status_id='7'";
			$temp = '7';
			
		}

		$rsTarget = $sql->select("*","activity","activity_id='$id'");
		$rwTarget = $rsTarget->fetch_assoc();
		if($_SESSION['position_id']==$rwTarget['pos_target']){
			$update = $update." , pos_target = NULL";
			// echo "if";
		}else if(isset($target)){
			$update = $update." , pos_target = '$target'";
			// echo "else";
		}
		// echo $last_step;
		// echo $update;
		$sql->update('activity',$update,"activity_id='$id'");
		$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count'," '$id','$step','$version','$temp','$date_now','$person_id','$count'");
		if($step == 0){
			$step = $type_id."01";
		}else{
			$step = $step+1;
		}
		$rsStep = $sql->select("*","step","step ='$step' AND version ='$version'");
		$rwStep = $rsStep->fetch_assoc();
		// echo "step = ".$step."<br>";
		// echo "version = ".$version."<br>";
		$pos =$rwStep['position_id'];
		// echo "pos : ".$pos;
		$alert->sendLine("",$pos,"มีการดำเนินการเข้ามาในฝ่าย",$topic);

    	$_SESSION['coming_work'] = $_SESSION['coming_work'] - 1;
		echo "<script>alert('ส่งข้อมูลสำเร็จ')</script>";
		if($count==0){
			$alert->link('0','my_activity.php');
		}else if($step!=0){
			$alert->link('0','index.php');
		}

	}
	if(isset($_POST['btn_sub_two'])){
		if(isset($_POST['pos_target'])){
			$target = $_POST['$pos_target'];
		}
		$id = $_POST['activity_id'];
		$step = $_POST['old_step'];
		$version = $_POST['version'];
		$num_Chk  = $_POST['num_Chk'];
		$count  = $_POST['count'];
		$topic  = $_POST['topic'];
		$person_id = $_SESSION['person_id'];
		$rsPos = $sql->select("*","step","type_id='$type_id' AND version='$version' ORDER BY step DESC");
		$rwPos = $rsPos->fetch_assoc();
	
		$update = "finish = '$date_now',step='$step',status_id='7'";
		$temp = '7';
			
		$sql->update('activity',$update,"activity_id='$id'");
		$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count'," '$id','$step','$version','$temp','$date_now','$person_id','$count'");
		
		

		if($count==0){
				$alert->link('0','my_activity.php');
			}else if($step!=0){
				$alert->link('0','index.php');
			}

	}

?>

