<?php
require_once('top.php');
?>

		<center><h4>จัดการ Version</h4></center>

 <?php  
 	$type = "1";
	if(isset($_GET['type']) AND $_GET['type']!=0){
		$type = $_GET['type'];
		$type = " version.type_id = '$type'";
	}
	$result =$sql->select("*","version left join activity_type on version.type_id = activity_type.activity_type_id","$type ORDER BY status DESC,type_id ");
	$rsType = $sql->select('*','activity_type',"");
	
?>

<form method="GET" action"">
	<select name="type">
		<option value="0">เลือกประเภท</option>
		<?php 
		$rsAT = $sql->select('*','activity_type','');
		while($rwAT = $rsAT->fetch_assoc()){ ?>
		<option value="<?php echo $rwAT['activity_type_id']; ?>"><?php echo $rwAT['type']; ?></option>
		<?php } ?>
	</select>
	<input type="submit" name="" value="ค้นหา">
</form>
<button type="button" style="width: 140px" class="btn btn-primary" data-toggle="modal" data-target="#version">เพิ่มเวอร์ชั่น</button>
  	
<!-- Modal -->
		<div class="modal fade" id="version" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
		        	<h4>เพิ่มเวอร์ชั่น</h4>
		        	<?php $rsVersion = $sql->select('*','activity_type',""); ?>
			        	<form action="" method="POST"> 
			        		<select name="type_id">
				        		<?php while($rwVersion = $rsVersion->fetch_assoc()){ ?>
				        			<option value="<?php echo $rwVersion['activity_type_id']; ?>"><?php echo $rwVersion['type']; ?></option>
				        		<?php } ?>
			        		</select>
			        	
		        <input type="submit" name="btn_add" class="btn btn-primary" value="ยืนยัน">
      		  </div>
		      <div class="modal-footer"> 
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>




<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">ประเภทการดำเนินการ</th>
      <th style="border-top-width: 0;" scope="col">version</th>
      <th style="border-top-width: 0;" scope="col">สถานะ</th> 
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
				if($row['status']=='on'){
					$status = "ON";
					$color = "green";
				}else{ $color ="red";$status="OFF";}
				?> 
				
		<input type="hidden" name="id" value="<?php echo $row['status_id']; ?>">
		<tr>
			<th scope="row"><?php echo $row['type']; ?></th>	
			<th scope="row"><?php echo $row['version']; ?></th> 	
			<th scope="row"><div style="text-align: center; padding:4px;background-color: <?php echo $color; ?>;width: 38px;border-radius: 3px;color:white"><?php echo $status; ?></div></th> 
			<th scope="row">
					
  	<?php if($row['status']=="on"){?>
  		<button type="button" style="width: 140px;background-color:#afafaf;border-color: #afafaf" disabled class="btn btn-primary" >กำลังใช้งาน</button>
  	<?php
  	}else{
  		?>
  		<button type="button" style="width: 140px" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['version_id'] ?>">ปรับใช้งาน</button>
  	<?php 
  	} ?>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['version_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"></h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
		        	<h4>ประเภท <?php echo $row['type']; ?></h4>
		        	<h4>เวอชั่นที่ <?php echo $row['version']; ?></h4>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="version_id" value="<?php echo $row['version_id']; ?>">
			        		<input type="hidden" name="type_id" value="<?php echo $row['type_id']; ?>">
			        	
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="เรียกใช้งาน">
      		  </div>
		      <div class="modal-footer"> 
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
			echo "<tr><th colspan='5'><center>ไม่พบข้อมูลที่เกี่ยวกับ \" ".$_GET['txt_search']." \"</center></th></tr>";
		}else{
			echo "<tr><th colspan='5'><center>ไม่พบข้อมูล</center></th></tr>";
		}
	}



	?>
	<th>
    </tr>
  </tbody>
</table>



<?php
require_once('../bottom.php');
?> 
<?php

	
	if(isset($_POST['btn_edit'])){		
		$version_id = $_REQUEST['version_id'];
		$type_id = $_REQUEST['type_id'];
		$result = $sql->update("version"," status='off'","version_id!='' and type_id ='$type_id'");
		$result = $sql->update("version"," status='on' ","version_id='$version_id'");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_version.php");
			}else{ $alert->status("09");}

	}
	if(isset($_POST['btn_add'])){

		$type_id = $_POST['type_id'];
		$rsStep = $sql->select('*','version',"type_id='$type_id' ORDER BY version DESC");
		$chk =$rsStep->num_rows;
		if($rsStep->num_rows>0){
			$rwStep = $rsStep->fetch_assoc();
			$version = $rwStep['version'];
			$version++;
		}
		else{
			$version = 1;
		}
		$result = $sql->insert('version','type_id,version,status',"'$type_id','$version','off'");
		if($result){ 
				$alert->status("10");
				$alert->link("0","manage_version.php");
		}
	}

	if(isset($_POST['btn_del'])){ 
		$result = $sql->delete("step","step_id","".$_POST['step_id']."");
		if($result){
			$alert->status("20");
			$alert->link("0","manage_step.php");
		}

	}


?>