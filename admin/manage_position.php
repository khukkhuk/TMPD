<?php
require_once('top.php');
?>

		<center><h4>จัดการตำแหน่งบุคลากร</h4></center>

 	<?php 
		$result=$sql->select("*","position LEFT JOIN position_type ON position.position_type_id = position_type.position_type_id","position!='ผู้ดูแลระบบ' ORDER BY position_id DESC");
		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","position LEFT JOIN position_type ON position.position_type_id = position_type.position_type_id","position!='ผู้ดูแลระบบ' AND position like '%".$_GET['txt_search']."%' ORDER BY position_id DESC ");
		}
	?>

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
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
		        <center><h2> เพิ่มข้อมูลตำแหน่ง</h2>
			        <table>
			        	<form action="" method="POST"> 
			        	<tr><td>ชื่อตำแหน่ง</td><td><center><input type="text" name="position"></td></tr>
					</table>
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
      <th style="border-top-width: 0;" scope="col">ชื่อตำแหน่ง</th>  
      <th style="border-top-width: 0;" scope="col">กลุ่มตำแหน่ง</th>  
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
				$title = $row['position_title'];
				$rw = $sql->select("*","position","position_id ='$title'")->fetch_assoc();

					?> 
		<input type="hidden" name="id" value="<?php echo $row['position_id']; ?>">
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
			<th scope="row"><?php echo $row['position_id']; ?></th>	
			<th scope="row"><?php echo $row['position']; ?></th>  
			<th scope="row"><?php echo $rw['position']; ?></th>  
			<th scope="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['position_id'] ?>">
  จัดการข้อมูล</button>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['position_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> จัดการข้อมูลตำแแหน่ง <?php echo $row['position']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        	<input type="hidden" name="position_id" value="<?php echo $row['position_id'];?>">
			        	<tr><td>ชื่อตำแหน่ง</td><td><center><input type="text" name="position" value="<?php echo $row['position']; ?>"></td></tr> 
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="ล้าง"> 
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="บันทึกข้อมูล">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>
		<?php 
			$rsPosType = $sql->select("*","position_type","position_title = '".$row['position_id']."'");
		if($rsPosType->num_rows==0){ ?>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit<?php echo $row['position_id'] ?>">
  จัดการกลุ่มตำแหน่ง</button>
<!-- Modal -->
		<div class="modal fade" id="edit<?php echo $row['position_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2><?php echo $row['position']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        	<input type="hidden" name="id" value="<?php echo $row['position_id'];?>">
			        	<tr>
			        		<td>เลือกฝ่ายที่ต้องการย้าย</td>
			        		<td>
			        			<select name="position_id">
			        				<option value='NULL'>---เลือกตำแหน่ง---</option>
			        			<?php 
			       					$rsPosT = $sql->select("*","position_type LEFT JOIN position ON position_type.position_title = position.position_id","");
			       					while($rwPosT = $rsPosT->fetch_assoc()){
			       						?>
								    	<option <?php if($rwPosT['position_type_id']==$row['position_type_id']){echo"selected";} ?> value="<?php echo $rwPosT['position_type_id']; ?>"><?php echo $rwPosT['position'];  ?></option>
		       					<?php
		       						}
		       					?>
		       					</select>
		       				</td>
			        	</tr> 
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="Clear">
		      	<input type="submit" name="btn_del" class="btn btn-danger" value="Delete">
		        <input type="submit" name="btn_edit_pos" class="btn btn-primary" value="Save Change">
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>
	<?php }else{ echo "<div class='btn btn-info'>เป็นกลุ่มอ้างอิง</div> ";} ?>
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
	if(isset($_POST['btn_edit_pos'])){
		$position_id = $_POST['position_id'];
		$id = $_POST['id'];
		if($position_id=='NULL'){
			$position_id='NULL';
		}else{
			$position_id = "'".$position_id."'";
		}
		$sql->update("position","position_type_id = $position_id","position_id='$id'");
		$alert->status("30");
		$alert->link("0","manage_position.php");

	}
	if(isset($_POST['btn_add'])){
		if($_POST['position']!=''){
			$result = $sql->select("*","position","position = '".$_POST['position']."'");
			if($result->num_rows<1){ 
				$result = $sql->insert("position","position","'".$_POST['position']."'"); 
				if($result){
					$alert->status("10");
					$alert->link("0","manage_position.php");
				}
			}else{$alert->status("09");
			}
		}else{
			$alert->status("08");
			//$alert->link("0","manage_position.php");
		}
	}
	if(isset($_POST['btn_edit'])){		
		$result1 = $sql->select("*","position","position = '".$_POST['position']."'");
		if($result1->num_rows==0){
			$result = $sql->update("position"," position='".$_POST['position']."'","position_id = ".$_POST['position_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_position.php");
			}
		}else{ $alert->status("09");}

	}
	if(isset($_POST['btn_del'])){ 
		$result = $sql->delete("position","position_id=".$_POST['position_id']."");
		if($result){
			$alert->status("20");
			$alert->link("0","manage_position.php");
		}

	}


?>