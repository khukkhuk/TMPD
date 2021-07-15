<?php
require_once('top.php');
?>

		<center><h4>จัดการประเภทการดำเนินการ</h4></center>

 <?php 

		$result=$sql->select("*","activity_type ORDER BY activity_type_id DESC","");
		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","activity_type","type like '%".$_GET['txt_search']."%' ORDER BY activity_type_id DESC");	
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
		        <center><h2> เพิ่มประเภทการดำเนินการ</h2>
			        <table>
			        	<form action="" method="POST"> 
			        	<tr><td><center><input type="text" name="type"></td></tr>
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
      <th style="border-top-width: 0;" scope="col">ชื่อการดำเนินการ</th> 
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
					?> 
		<input type="hidden" name="activity_type_id" value="<?php echo $row['activity_type_id']; ?>">
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
			<th scope="row"><?php echo $row['activity_type_id']; ?></th>	
			<th scope="row"><?php echo $row['type']; ?></th> 
			<th scope="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal<?php echo $row['activity_type_id']; ?>">
  จัดการข้อมูล</button>
<!-- Modal -->
		<div class="modal fade" id="Modal<?php echo $row['activity_type_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> แก้ไขชื่อประเภท <?php echo $row['type']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        	<input type="hidden" name="activity_type_id" value="<?php echo $row['activity_type_id'];?>">
			        	<tr><td>position</td><td><center><input type="text" name="type" value="<?php echo $row['type']; ?>"></td></tr> 
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="Clear"> 
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="Save Change">
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
    </tr>
  </tbody>
</table>



<?php
require_once('../bottom.php');
?>
<?php

	if(isset($_POST['btn_add'])){
		$result = $sql->select("*","activity_type","type = '".$_POST['type']."'");
		if($result->num_rows<1){ 
			$result = $sql->insert("activity_type","type","'".$_POST['type']."'"); 
			if($result){
				$alert->status("10");
				$alert->link("0","manage_activity_type.php");
			}
		}else{$alert->status("09");}
	}
	if(isset($_POST['btn_edit'])){		
		$result1 = $sql->select("*","activity_type","type = '".$_POST['type']."'");
		if($result1->num_rows==0){
			$result = $sql->update("activity_type"," type='".$_POST['type']."' ","activity_type_id = ".$_POST['activity_type_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_activity_type.php");
			}
		}else{ $alert->status("09");}

	}
	if(isset($_POST['btn_del'])){ 
		$result = $sql->delete("activity_type","activity_type_id =".$_POST['activity_type_id']."");
		if($result){
			$alert->status("20");
			$alert->link("0","manage_activity_type.php");
		}

	}


?>