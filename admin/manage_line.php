<?php
require_once('top.php');
?>

		<center><h4>จัดการ Line Notify </h4></center>

 <?php 
	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","person left join position on person.position = position.position_id ","person.position!='1' AND (username like '%".$_GET['txt_search']."%' OR name like '%".$_GET['txt_search']."%' OR surname like '%".$_GET['txt_search']."%' ) ORDER BY person_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","person left join position on person.position = position.position_id","person.position!='1'  AND (username like '%".$_GET['txt_search']."%' OR name like '%".$_GET['txt_search']."%' OR surname like '%".$_GET['txt_search']."%' ) ");
 		}else{
			$result=$sql->select("*","person left join position on person.position = position.position_id ","person.position!='1' ORDER BY person_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","person left join position on person.position = position.position_id","person.position!='1'");
 		}
		
	$showpage = ceil($result_page->num_rows / $perpage);


 ?>

 	

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" placeholder="Username หรือ ชื่อ-นามสกุล" name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>

	
	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='manage_line.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='manage_line.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>



<table class="table table"> 

  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">ID</th>
      <th style="border-top-width: 0;" scope="col">Username</th>
      <th style="border-top-width: 0;" scope="col">ชื่อ-นามสกุล</th>
      <th style="border-top-width: 0;" scope="col">ตำแหน่ง</th>
      <!-- <th style="border-top-width: 0;" scope="col">สถานะ</th> -->
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
					?> 
		<input type="hidden" name="id" value="<?php echo $row['person_id']; ?>">
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
			<th scope="row"><?php echo $row['person_id']; ?></th>	
			<th scope="row"><?php echo $row['username']; ?></th>
			<th scope="row"><?php echo $row['name']."  ".$row['surname']; ?></th>
			<th scope="row"><?php echo $row['position']; ?></th>
		<!-- 	<th scope="row"><?php if( $row['status']=="on"){echo "<span style='color:green'>เปิดใช้งานแล้ว</span>";}else{echo"<span style='color:red'>ไม่ได้เปิดใช้งาน</span>";} ?></th> -->
			<th scope="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['person_id'] ?>">
  จัดการข้อมูล</button>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['person_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> Line Token คุณ <?php echo $row['name']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        	<input type="hidden" name="person_id" value="<?php echo $row['person_id'];?>">
			        	<tr><td>ชื่อ</td><td><center><input disabled type="text" value="<?php echo $row['name']; ?>"></td></tr>
			        	<tr><td>นามสกุล</td><td><center><input disabled type="text" value="<?php echo $row['surname']; ?>"></td></tr>
			        	<tr><td>LineToken</td><td><center><input type="text" name="linetoken" value="<?php echo $row['line_token'];?>"></td></tr>
			        		<input type="hidden" name="LineTarget" value="<?php echo $row['line_token'];?>">
			        		<input type="hidden" class="" name="LineMessage" value="ทดสอบการเชื่อมต่อ"> 
					</table>
      		  </div>
		      <div class="modal-footer">
		      	<input class="btn btn-warning" type="submit" name="btn_test" value="ทดสอบข้อความ">
				<input class="btn btn-primary" type="submit" name="btn_edit" value="บันทึกข้อมูล">
			    <input class="btn btn-danger" type="submit" name="btn_del" value="ลบข้อมูล">
			    <input class="btn btn-second" type="reset" name=""value="ล้าง">
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
		if(isset($_POST['btn_del'])){
			$person_id  = $_POST['person_id'];
			$result = $sql->uodate("person","line_token=''","person_id = '$person_id'");
			$alert->status('20');
			$alert->link('0','manage_line.php');
		}
		if(isset($_POST['btn_edit'])){
			$linetoken=$_POST['linetoken'];
			$person_id=$_POST['person_id'];
			$result = $sql->update("person","line_token ='$linetoken'","person_id= '$person_id'");
			if($result){
				$alert->status("30");
				$alert->link("0","manage_line.php");
			}
			else{
				$alert->status("31");
				$alert->link("0","manage_line.php");
			}
		} 
	?>