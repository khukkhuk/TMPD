<?php
require_once('top.php');
?>

		<center><h4>จัดการขั้นตอนการทำงาน<?php if(isset($_GET['select_type'])AND$_GET['select_type']!=0){ if(isset($_SESSION['type'])){echo "ในเวอร์ชั่น ".$_SESSION['type'][$_GET['select_type']];}} ?></h4></center>

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
	 $field = "action_type,step.type_id,step.version,step.position_id,step_id,step.step , position.position,activity_type.type,activity_type.activity_type_id";
	 $table = " step left join activity_type on  step.type_id = activity_type.activity_type_id left join position on step.position_id = position.position_id";
	 if(isset($_SESSION['type'])){
	 	$where = $where."ORDER BY step.step ASC";
	 }else{
	 	$table = $table." ORDER BY step.step ASC";	
	 }
		
			$result=$sql->select("$field","$table","$where");
	
	$rsType = $sql->select('*','version LEFT JOIN activity_type ON version.type_id = activity_type.activity_type_id',"version.status = 'on'" );
			
	
?>

	<form style="margin-left: 3%;" action="" method="GET">
		<select name="select_type">
			<option value="0">ดูทั้งหมด</option>
			<?php 
				$resType = $sql->select("*","activity_type",'');
				while($rowType = $resType->fetch_assoc()){ ?>
			<option <?php if(isset($_GET['select_type'])) if($rowType['activity_type_id']==$_GET['select_type']) echo "selected"; ?> value="<?php echo $rowType['activity_type_id']; ?>"><?php echo $rowType['type']; ?></option>
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
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> เพิ่มขั้นตอนการดำเนินการ</h2>
			        <style type="text/css">
			        	select {
			        				text-align: center;
									text-align-last: center;
								    width: 170px;
								}
			        </style>

			        	<form action="" method="POST"> 
			        		<input type="hidden" name="version" value="<?php echo $version; ?>">
			        	<label style="width: 120px">เลือกประเภท</label><select name="type" required>
			        		 <option disabled>--เลือกประเภท--</option>
					        	<?php while($rwType = $rsType->fetch_assoc()){ ?>
					        		<option <?php if(isset($_GET['select_type'])AND$_GET['select_type']==$rwType['type_id']){echo"selected";} ?> value="<?php echo $rwType['activity_type_id']; ?>"><?php echo $rwType['type']; ?></option>
					        	<?php } ?>
			        	</select>

			        	<br>
			        	<label  style="width: 120px">เลือกตำแหน่ง</label><select name="pos" required>
			        		<option disabled>----</option>
					        	<?php 
						        	$rsPos = $sql->select('*','position',"position_id!='1'");
						        	while($rwPos = $rsPos->fetch_assoc()){ ?>
					        		<option  value="<?php echo $rwPos['position_id']; ?>"><?php echo $rwPos['position']; ?></option>
					        	<?php } ?>
			        	</select>
			        		
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="ล้าง"> 
		        <input type="submit" name="btn_add" class="btn btn-primary" value="บันทึกข้อมูล">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>



<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">ID</th>
      <th style="border-top-width: 0;" scope="col">ประเภทการดำเนินการ</th>
      <th style="border-top-width: 0;" scope="col">ฝ่ายดำเนินการ</th> 
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
				$step = $row['step'];
				$position = $row['position'];
				if($row['step']==0){
					$step = $row['activity_type_id']."00";
					$position = "ฝ่ายเสนอ";
				}
					?> 
				
		<input type="hidden" name="id" value="<?php echo $row['status_id']; ?>">
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
			<th scope="row"><?php echo $step; ?></th>	
			<th scope="row"><?php echo $row['type']; ?></th> 	
			<th scope="row"><?php echo $position; ?></th> 
			<th scope="row"> 
				<?php 
					if($row['step']!=0){
				 ?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['step_id'] ?>">
  จัดการขั้นตอน</button>
					<?php } ?>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['step_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
		        	<h4>ขั้นตอนที่ <?php echo substr($row['step'], 2); ?></h4>
		        	<h4>ประเภท <?php echo $row['type']; ?></h4>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="step_id" value="<?php echo $row['step_id']; ?>">
			        	<label style="width: 120px">เลือกตำแหน่ง</label> <select name="pos_edit" required>
					        	<?php 
					        		$rsPos1 = $sql->select('*','position',"");
					        		while($rwPos1 = $rsPos1->fetch_assoc()){ ?>
					        		<option <?php if($row['position_id']==$rwPos1['position_id']){echo "selected";} ?> value="<?php echo $rwPos1['position_id']; ?>"><?php echo $rwPos1['position']; ?></option>
					        	<?php } ?>
			        			</select>
		        			<input type="submit" name="btn_edit_pos" class="btn btn-primary" value="บันทึกข้อมูล">
			    		</form>
			    		<hr>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="step_id" value="<?php echo $row['step_id']; ?>">
			        		<input type="hidden" name="step" value="<?php echo $row['step']; ?>">
			        		<input type="hidden" name="version" value="<?php echo $row['version']; ?>">
			        		<input type="hidden" name="type_id" value="<?php echo $row['type_id']; ?>">
			        	<label style="width: 120px">เลือกลำดับ</label>
			        			<select name="pos_edit" required>
					        	<?php 
					        		$type = $row['type_id'];
					        		$version = $row['version'];
					        		$rsPos2 = $sql->select('*','step',"type_id='$type' AND version='$version' ORDER BY step ASC");
					        		// SELECT * FROM `step` WHERE type_id ='6' AND version ='1' ORDER BY step ASC
					        		while($rwPos2 = $rsPos2->fetch_assoc()){?>
					        			<option <?php if($row['step_id']==$rwPos2['step_id']){echo "selected";} ?> value="<?php echo $rwPos2['step']; ?>"><?php echo $rwPos2['step']; ?></option>
					        	<?php } ?>
			        			</select>
		        			<input type="submit" name="btn_edit_step" class="btn btn-primary" value="บันทึกข้อมูล">
			    		</form>
			    		<hr>
			    		<form action="" method="POST"> 
			        		<input type="hidden" name="step_id" value="<?php echo $row['step_id']; ?>">
			        		<input type="hidden" name="step" value="<?php echo $row['step']; ?>">
			        		<input type="hidden" name="version" value="<?php echo $row['version']; ?>">
			        		<input type="hidden" name="type_id" value="<?php echo $row['type_id']; ?>">
			        	<label style="width: 120px">รูปแบบ</label>
			        			<select name="action_type" required>

			        				<option disabled <?php if($row['action_type']==NULL){echo "selected"; }?> >--เลือกรูปแบบ--</option>
			        				<option <?php if($row['action_type']=="one_way"){echo "selected"; }?> value="one_way">ปกติ</option>
			        				<option <?php if($row['action_type']=="two_way"){echo "selected"; }?> value="two_way">ปิดการดำเนินการ</option>
			        			</select>
		        			<input type="submit" name="btn_edit_action" class="btn btn-primary" value="บันทึกข้อมูล">
			    		</form>

      		  </div>
		      <div class="modal-footer">
		      	<form method="POST" action="">
			        <input type="hidden" name="step_id" value="<?php echo $row['step_id']; ?>">
			        <input type="hidden" name="step" value="<?php echo $row['step']; ?>">
			        <input type="hidden" name="version" value="<?php echo $row['version']; ?>">
			        <input type="hidden" name="type_id" value="<?php echo $row['type_id']; ?>">
		      		<input type="submit" name="btn_del" class="btn btn-danger" value="ลบข้อมูล">
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
	

	$url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

	$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
	$escaped_url = substr($escaped_url, 24 );
	// echo $escaped_url;

	if(isset($_POST['btn_add'])){
		// $chk = $sql->select('*',"")
		$type = $_REQUEST['type'];
		$version = $_SESSION['type'][$type];
		$pos = $_REQUEST['pos'];
		// echo "<script>alert('type = $type  pos = $pos version = $version')</script>";
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
		$result = $sql->insert("step","step,type_id,position_id,version,action_type","'$stepid','$type','$pos','$version','one_way'"); 
			if($result){
			$alert->status("10");
			$alert->link("0",$escaped_url );
		}else{$alert->status("09");
		}		
	}
	
	if(isset($_POST['btn_edit_pos'])){		
		// echo "<script>alert('pos')</script>";
			$result = $sql->update("step"," position_id='".$_POST['pos_edit']."' ","step_id = ".$_POST['step_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0",$escaped_url);

			}else{ $alert->status("09");}
	}

	if(isset($_POST['btn_edit_action'])){		
		// echo "<script>alert('pos')</script>";
			$result = $sql->update("step"," action_type='".$_POST['action_type']."' ","step_id = ".$_POST['step_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0",$escaped_url);

			}else{ $alert->status("09");}
	}

	if(isset($_POST['btn_edit_step'])){		
		$step_edit = $_POST['pos_edit'];
		$step_id = $_POST['step_id'];
		$step = $_POST['step'];
		$type_id = $_POST['type_id'];
		$version = $_POST['version'];
		// echo "step_edit=$step_edit step_id=$step_id step=$step type_id=$type_id version=$version<br>";
		$stop = "0";
		$result = $sql->select('*',"step","version = '$version' AND type_id ='$type_id' ORDER BY step ASC");
		$num_rows = $result->num_rows;
		if($step>$step_edit){ //back to front
		// echo "<script>alert('back to front')</script>";
			$i=1;
			while ($row = $result->fetch_assoc()) {

				$row_id = $row['step_id'];
				if($row['step']==$step){
					$value = "step='$step_edit'";
					$sql->update("step",$value,"step_id=$step_id");
				}
				if($row['step']>=$step_edit AND $num_rows != $i AND $row['step']!=$step){
					$temp = $row['step'] + 1;
					$value = "step = '$temp'";
					$sql->update("step",$value,"step_id=$row_id");
				}
				$i++;
			}
		}

		if($step<$step_edit){//front to back
		// echo "<script>alert('front to back')</script>";
			$i = 1;
			while ($row = $result->fetch_assoc()) {
				$row_id = $row['step_id'];
				if($i == 1){
					$temp = $row['step'];
				}
				if($row['step']==$step){
					$sql->update("step","step='999999'","step_id='$row_id'");
					$temp--;
				}
				if($row['step']==$step_edit){
					$value = "step = '$step_edit'";
					$sql->update("step",$value,"step='999999'");
				}
				if($row['step']>$step AND $row['step']<=$step_edit){
					$value = "step = '".$temp."'";
					$sql->update("step",$value,"step_id='$row_id'");
				}
				$temp++;
				$i++;

			}

		}
		$alert->status("30");
		$alert->link("0",$escaped_url);
	}


	if(isset($_POST['btn_del'])){ 
		$step = $_POST['step']; 
		$step_id = $_POST['step_id']; 
		$version = $_POST['version'];  
		$type = $_POST['type_id']; 
		
		$rsStep = $sql->select("*","step","version = '$version' AND type_id ='$type' AND step > '$step'");
		while ($rwStep  = $rsStep->fetch_assoc()) {
			$temp  = $rwStep['step'] - 1;
		 $value = "step = '$temp'";
			$sql->update("step",$value,"step_id='".$rwStep['step_id']."'");
		}

		$result = $sql->delete("step","step_id ='$step_id'");

		if($result){
			$alert->status("20");
			$alert->link("0","manage_step.php");
		}

	}


?>