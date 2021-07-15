<?php 
	require_once('top.php');
 ?>
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> 
<center><h4>จัดการกลุ่มตำแหน่งบุคลากร</h4></center>
	<form>
		<input type="text" name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;">
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
		<button type="button" class="btn" data-toggle="modal" data-target="#modal_add">
  		<i class="fa fa-plus-square" aria-hidden="true"></i></button>  
	</form>	

<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;">ID</th>
      <th style="border-top-width: 0;">ชื่อกลุ่ม</th>
      <th style="border-top-width: 0;">ตำแหน่งอ้างอิงกลุ่ม</th>
    </tr>
  </thead>
  <tbody>
  	<tr>
  	<?php 
  		$rsPosT = $sql->select('position_type.position_type_id,position.position,position_type.position_title','position_type LEFT JOIN position ON position_type.position_title = position.position_id',"position!='ผู้ดูแลระบบ' ORDER BY position_type_id DESC");
  		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
  			$rsPosT = $sql->select('position_type.position_type_id,position.position,position_type.position_title','position_type LEFT JOIN position ON position_type.position_title = position.position_id',"position!='ผู้ดูแลระบบ' AND position like '%".$_GET['txt_search']."%' ORDER BY position_type_id DESC ");
  		}
  		if($rsPosT->num_rows>0){
  		while($rwPosT = $rsPosT->fetch_assoc()){
  	?>

  		<tr>
  			<th><?php echo $rwPosT['position_type_id']; ?></th>
  			<th><?php echo $rwPosT['position']; ?></th>
  			<th><?php echo $rwPosT['position_title']; ?></th>
  			<th>
  			
		  		<button type="button" class="btn" data-toggle="modal" data-target="#show_modal">ดูรายชื่อตำแหน่ง</button>
  				<div class="modal fade" id="show_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  			<div class="modal-dialog" role="document">
		    			<div class="modal-content">
		      				<div class="modal-header">
		        				<h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      				</div>
		      				<div class="modal-body">
		       					<center>รายชื่อตำแหน่งภายในกลุ่ม <?php echo $rwPosT['position']; ?></center>
		      						<form>
		       						<center>
		       						<table>
		       							<?php 
		       								$i = 1;
		       								$rsPos = $sql->select("*","position","position!='".$rwPosT['position']."' AND position_type_id='".$rwPosT['position_type_id']."'");
		       								while($rwPos = $rsPos->fetch_assoc()){
		       							?>
							       		<tr>
							       			<td><?php echo $i; ?></td>
							       			<td><?php echo $rwPos['position']; ?></td>
							       		</tr>	
		       							<?php
		       								$i++;
		       								}
		       							?>
							        </table>
							   		</center>
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
  		?>
  		<tr>
  			<td colspan="3"><center>ไม่พบข้อมูล</td>
  		</tr>
  		<?php
  	}
  	?></tr>
  </tbody>
</table>
  		<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  			<div class="modal-dialog" role="document">
		    			<div class="modal-content">
		      				<div class="modal-header">
		        				<h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      				</div>
		      				<div class="modal-body">
		       					<center>เพิ่มกลุ่มตำแหน่ง</center>
		      						<form method="POST">
		       						<center>
		       						<table> 
							       		<tr>
							       			<td>เลือกชื่ออ้างอิง</td>
							       			<td>
								       			<select name="position_id" style="width: 209px;height: 34px">
								       				<?php 
								       					$result = $sql->select("*","position","position_id!='1' AND position_type_id IS NULL");
								       					while($row = $result->fetch_assoc()) {
								       				?>
								       					<option value="<?php echo $row['position_id']; ?>"><?php echo $row['position']; ?></option>
								       				<?php
								       					}
								       				 ?>
								       			</select>
							       			</td>
							       		</tr> 
							        </table>
							   		</center>
      		  				</div>
		      				<div class="modal-footer">
		      					<input type="reset" name="" class="btn btn-secondary" value="ล้าง"> 
		        				<input type="submit" name="btn_add" class="btn btn-primary" value="บันทึก">
		       						</form>
		     			 	</div>
		    			</div>
		  			</div>
		  		</div>

<?php 
	if(isset($_POST['btn_add'])){ 
		$position_id = $_POST['position_id'];
		$sql->insert("position_type","position_title","$position_id");
		$row = $sql->select("*","position_type ORDER BY position_type_id DESC","")->fetch_assoc();
		$id = $row['position_type_id'];
		$sql->update("position","position_type_id='$id'","position_id='$position_id'");
		$alert->status("10");
		$alert->link("0","manage_position_type.php");

	}
	if(isset($_POST['btn_edit'])){
		$position_name = $_POST['position_name'];
		$id = $_POST['position_type_id'];
		$sql->update("position_type","position_type='$position_name'","position_type_id='$id'");
		$alert->status("30");
		$alert->link("0","manage_position_type.php");
	}
?>
<?php 
	require_once('../bottom.php'); 
?>