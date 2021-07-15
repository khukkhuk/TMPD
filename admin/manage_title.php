<?php
require_once('top.php');
?>

		<center><h4>จัดการคำนำหน้า</h4></center>

 <?php 

		

	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("*","title","(title_name like '%".$_GET['txt_search']."%' OR title_id like '%".$_GET['txt_search']."%' ) ORDER BY title_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","title","(title_id like '%".$_GET['txt_search']."%' OR title_name like '%".$_GET['txt_search']."%' ) ");
 		}else{
			$result=$sql->select("*","title ORDER BY title_id DESC LIMIT $start , $perpage","");
			$result_page=$sql->select("*","title","");
 		}
		
	$showpage = ceil($result_page->num_rows / $perpage);

	?>

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" name="txt_search" placeholder="คำนำหน้า" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button> 

		<button type="button" class="btn" data-toggle="modal" data-target="#openModalAdd">
  <i class="fa fa-plus-square" aria-hidden="true"></i></button>  

	</form>

	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='manage_title.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='manage_title.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>
<div class="modal fade" id="openModalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2>เพิ่มคำนำหน้า</h2>
			        <table>
			        	<form action="" method="POST">
			        	<tr><td>คำนำหน้า</td><td><center><input style="width: 80%" type="text" name="name" value=""></td></tr>
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
      <th style="border-top-width: 0;" scope="col">คำนำหน้า</th>
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
					?>  
		<tr> 
			<th scope="row"><?php echo $row['title_id']; ?></th>
			<th scope="row"><?php echo $row['title_name']; ?></th>
			<th scope="row">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $row['title_id'] ?>">
  จัดการข้อมูล</button>
<!-- Modal -->
		<div class="modal fade" id="exampleModal<?php echo $row['title_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center><h2> จัดการคำนำหน้า</h2>
			        <table>
			        	<form action="" method="POST">
			        	<tr><td>ชื่อ</td><td><center><input type="text" name="name" value="<?php echo $row['title_name']; ?>"></td></tr>
					</table>
      		  </div>
		      <div class="modal-footer">
			    <input type="hidden" name="title_id" value="<?php echo $row['title_id'];?>">
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
			echo "<tr><th colspan='6'><center>ไม่พบข้อมูลที่เกี่ยวกับ \" ".$_GET['txt_search']." \"</center></th></tr>";
		}else{
			echo "<tr><th colspan='6'><center>ไม่พบข้อมูล</center></th></tr>";
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
		$title_id=$_POST['title_id'];
		$result = $sql->delete('title',"title_id='$title_id'");
		if($result){
			$alert->status("20");	
		}else{
			$alert->status("21");
		}
		$alert->link('0',"manage_title.php");
	}

	if(isset($_POST['btn_edit'])){
		$title_id=$_POST['title_id'];
		$title_name=$_POST['name'];
		$rsTitle = $sql->select("*","title","title_name = '$title_name'");
		if($rsTitle->num_rows==0){
			if($title_name!=''){
				$result = $sql->update("title","title_name='$title_name'","title_id='$title_id'");
				if($result){
					$alert->status("30");
			 	}
		 		$alert->link("0","manage_title.php");
		 	}else{
		 		$alert->status("08");	
		 	}
		}else{
		 	$alert->status("09");
		}

	}

	if(isset($_POST['btn_add'])){
		$title_name=$_POST['name'];
		if($title_name!=''){
			$result=$sql->select("*","title","title_name='$title_name'");
			if($result->num_rows==0){
				$result = $sql->insert("title","title_name","'$title_name'");
				$alert->status("10");
				$alert->link("1","manage_title.php");
			}else{
					$alert->status("09");}					
		}else{ 
			$alert->status("08");
		}
	}
?>