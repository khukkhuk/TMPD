<?php
require_once('top.php');
?>

		<center><h4>จัดการสถานะ</h4></center>
 <?php 
	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","status","status like '%".$_GET['txt_search']."%' ORDER BY status_id DESC LIMIT $start , $perpage ");
			$result_page=$sql->select("*","status","status like '%".$_GET['txt_search']."%'");
 		}else{
			$result=$sql->select("*","status ORDER BY status_id DESC LIMIT $start , $perpage ","");
			$result_page=$sql->select("*","status","");
 		}
		
	$showpage = ceil($result_page->num_rows / $perpage);


 ?>
	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" name="txt_search" style="border-radius: 12px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
		<button type="button" class="btn" data-toggle="modal" data-target="#modal_add">
  <i class="fa fa-plus-square" aria-hidden="true"></i></button>  
	</form>

	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='manage_status.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='manage_status.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>
	
<!-- Modal -->
		<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> เพิ่มสถานะ</h2>
			        <table>
			        	<form action="" method="POST"> 
			        	<tr><td><center><input type="text" name="status"></td></tr>
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
      <th style="border-top-width: 0;" scope="col">สถานะ</th> 
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
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
			<th scope="row"><?php echo $row['status_id']; ?></th>	
			<th scope="row"><?php echo $row['status']; ?></th> 
			<th scope="row"><?php if($row['status_id']>8){ ?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['status_id'] ?>">
  จัดการข้อมูล</button>
  	<?php }else{ ?>
  					<button type="button" class="btn btn-primary" disabled>สถานะหลัก</button>
  	<?php } ?>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['status_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h4> แก้ไขสถานะ<br> <?php echo $row['status']; ?></h4>
			        <table>
			        	<form action="" method="POST">
			        	<input type="hidden" name="status_id" value="<?php echo $row['status_id'];?>">
			        	<tr><td>สถานะ</td><td><center><input type="text" name="status" value="<?php echo $row['status']; ?>"></td></tr> 
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input type="reset" name="" class="btn btn-secondary" value="ล้าง">
		      	<input type="submit" name="btn_del" class="btn btn-danger" value="ลบข้อมูล">
		        <input type="submit" name="btn_edit" class="btn btn-primary" value="บันทึกข้อมูล">
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
		$result = $sql->select("*","status","status = '".$_POST['status']."'");
		if($result->num_rows<1){ 
			$result = $sql->insert("status","status","'".$_POST['status']."'"); 
			if($result){
				$alert->status("10");
				$alert->link("0","manage_status.php");
			}
		}else{$alert->status("09");}
	}
	if(isset($_POST['btn_edit'])){		
		$result1 = $sql->select("*","status","status = '".$_POST['status']."'");
		if($result1->num_rows==0){
			$result = $sql->update("status"," status='".$_POST['status']."' ","status_id = ".$_POST['status_id']."");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_status.php");
			}
		}else{ $alert->status("09");}

	}
	if(isset($_POST['btn_del'])){ 
		$result = $sql->delete("status","status_id = ".$_POST['status_id']."");
		if($result){
			$alert->status("20");
			$alert->link("0","manage_status.php");
		}

	}


?>