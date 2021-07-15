<?php
require_once('top.php');
?>

		<center><h4>จัดการขั้นตอนการทำงาน <?php if(isset($_GET['select_type'])AND$_GET['select_type']!=0){ if(isset($_SESSION['type'])){echo "version".$_SESSION['type'][$_GET['select_type']];}} ?></h4></center>

 <?php 
 		$where="";
 		$i=1;
 		if(isset($_SESSION['type'])){
 		$CountType = count($_SESSION['type']);
		for($i;$i<$CountType+1;$i++){

				if(isset($_GET['select_type']) and ($_GET['select_type'])!=0 ){
					$type = $_GET['select_type'];
					$where = "version = '".$_SESSION['type'][$_GET['select_type']]."' AND type_id = '$type' OR";
					$version = $_SESSION['type'][$_GET['select_type']];
				}else{
					// echo $i;
					$key = $_SESSION['key'][$i];
					$where = $where." (type_id='".$key."' AND version = '".$_SESSION['type'][$key]."') OR";
					
				}

			}
			$where = substr($where,0,-2);

	}
	 $field = "step_id,step.step , position.position,activity_type.type";
	 $table = " step left join activity_type on  step.type_id = activity_type.activity_type_id left join position on step.position_id = position.position_id";

		
			$result=$sql->select("$field","$table","$where");
	
	$rsType = $sql->select('*','version LEFT JOIN activity_type ON version.type_id = activity_type.activity_type_id',"version.status = 'on'" );
			
	
?>

	<form style="margin-left: 3%;" action="" method="GET">
		<select name="select_type">
			<option value="0">ดูทั้งหมด</option>
			<?php 
				$resType = $sql->select("*","activity_type",'');
				while($rowType = $resType->fetch_assoc()){ ?>
			<option value="<?php echo $rowType['activity_type_id']; ?>"><?php echo $rowType['type']; ?></option>
			<?php } ?>
		</select>
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
		<button type="button" class="btn" data-toggle="modal" data-target="#modal_add">
  <i class="fa fa-plus-square" aria-hidden="true"></i></button>  
	

	</form>
	
<!-- Modal -->
		<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> เพิ่มประเภทสถานะ</h2>
			        <style type="text/css">
			        	select {
			        				text-align: center;
									text-align-last: center;
								    width: 170px;
								}
			        </style>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="version" value="<?php echo $version; ?>">
			        	<select name="type">
			        		<option>--เลือกประเภท--</option>
					        	<?php while($rwType = $rsType->fetch_assoc()){ ?>
					        		<option value="<?php echo $rwType['activity_type_id']; ?>"><?php echo $rwType['type']; ?></option>
					        	<?php } ?>
			        	</select>

			        	<br>
			        	<select name="pos">
			        		<option>--เลือกฝ่าย--</option>
					        	<?php 
						        	$rsPos = $sql->select('*','position',"");
						        	while($rwPos = $rsPos->fetch_assoc()){ ?>
					        		<option value="<?php echo $rwPos['position_id']; ?>"><?php echo $rwPos['position']; ?></option>
					        	<?php } ?>
			        	</select>
			        		
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="Clear"> 
		        <input type="submit" name="btn_add" class="btn btn-primary" value="Save">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>



<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">ขั้นตอน</th>
      <th style="border-top-width: 0;" scope="col">ประเภทการดำเนินการ</th>
      <th style="border-top-width: 0;" scope="col">ฝ่ายดำเนินการ</th> 
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
					?> 
		<input type="hidden" name="id" value="<?php echo $row['status_id']; ?>">
		<tr> 
			<th scope="row"><?php echo $row['step']; ?></th>	
			<th scope="row"><?php echo $row['type']; ?></th> 	
			<th scope="row"><?php echo $row['position']; ?></th> 
			<th scope="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['step_id'] ?>">
  ย้ายขั้นตอน</button>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['step_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
		        	<h4>ขั้นตอนที่ <?php echo substr($row['step_id'], 2); ?></h4>
		        	<h4>ประเภท <?php echo $row['type']; ?></h4>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="step_id" value="<?php echo $row['step_id']; ?>">
			        	<select name="pos_edit">
			        		<option>--เลือกฝ่าย--</option>
					        	<?php 
					        		$rsPos1 = $sql->select('*','position',"");
					        		while($rwPos1 = $rsPos1->fetch_assoc()){ ?>
					        		<option value="<?php echo $rwPos1['position_id']; ?>"><?php echo $rwPos1['position']; ?></option>
					        	<?php } ?>
			        	</select>
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="Clear">
		      	<input type="submit" name="btn_del" class="btn btn-danger" data-dismiss="modal" value="Delete">
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="Save Change">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>
		<a href="manage_document.php?id=<?php echo $row['step_id']; ?>" class="btn btn-info">จัดการเอกสารที่เกี่ยวข้อง</a>
			</th>
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



	?>
    </tr>
  </tbody>
</table>



<?php
require_once('../bottom.php');
?> 
<?php

	if(isset($_POST['btn_add'])){
		// $chk = $sql->select('*',"")
		$type = $_REQUEST['type'];
		$version = $_SESSION['type'][$type];
		$pos = $_REQUEST['pos'];
		echo "<script>alert('type = $type  pos = $pos version = $version')</script>";
		$rsStep = $sql->select('*',"step LEFT join position on step.position_id = position.position_id left join activity_type on step.type_id = activity_type.activity_type_id","version = '$version' and step LIKE '$type%' ORDER BY step DESC");
		$rwStep = $rsStep->fetch_assoc();
		$ChkLength = $rsStep->num_rows;
		if($ChkLength>0){

		// echo "<script>alert('>0')</script>";
			$id = $rwStep['step'];
			// echo "<script>alert('id = $id')</script>";

			$id = floor($id/100);
			if( $id >=1){
				$stepid = $rwStep['step'];
				$stepid++;
				$c = 1;
			}else{
				$stepid = "$type"."01";
				$c = 2;
			}
		}else{
			$stepid=$type."01";
		}
		// echo "<script>alert('step = $stepid c = $c')</script>";
		$result = $sql->insert("step","step,type_id,position_id,version","'$stepid','$type','$pos','$version'"); 
			if($result){
			$alert->status("10");
			if(isset($_GET['select_type'])){
				$select_type = $_GET['select_type'];
				$linkstep = "manage_step.php?select_type=$select_type";
			}else{
				$linkstep = "manage_step.php";
			}
			$alert->link("0",$linkstep);
		}else{$alert->status("09");
		}		
	}
	
	if(isset($_POST['btn_edit'])){		
		echo "<script>alert('".$_POST['pos_edit']."')</script>";
			$result = $sql->update("step"," position_id='".$_POST['pos_edit']."' ","step_id = ".$_POST['step_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_step.php");
			}else{ $alert->status("09");}

	}


	if(isset($_POST['btn_del'])){ 
		$result = $sql->delete("step","step_id","".$_POST['step_id']."");
		if($result){
			$alert->status("20");
			$alert->link("0","manage_step.php");
		}

	}


?>