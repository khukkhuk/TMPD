<?php
require_once('top.php');
?>

		<center><h4>จัดการบุคลากร</h4></center>

 <?php 
	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
 		if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
			$result=$sql->select("person_email,user_status,title.title_name,person_id,status,position_id, name ,surname,username,password,position.position","person LEFT JOIN position ON person.position = position.position_id LEFT JOIN title on person.title_id = title.title_id","(username like '%".$_GET['txt_search']."%' OR position.position like '%".$_GET['txt_search']."%' ) ORDER BY person_id DESC LIMIT $start , $perpage");
			$result_page=$sql->select("*","person LEFT JOIN position ON person.position = position.position_id","(username like '%".$_GET['txt_search']."%' OR position.position like '%".$_GET['txt_search']."%' ) ");
 		}else{
			$result=$sql->select("person_email,user_status,title.title_name,person_id,status,position_id, name ,surname,username,password,position.position","person LEFT JOIN position ON person.position = position.position_id LEFT JOIN title on person.title_id = title.title_id ORDER BY person_id DESC LIMIT $start , $perpage","");
			$result_page=$sql->select("*","person LEFT JOIN position ON person.position = position.position_id","");
 		}
		
	$showpage = ceil($result_page->num_rows / $perpage);

	?>

	<form style="margin-left: 3%;" action="" method="GET">
		<input type="text" class="txt_search" name="txt_search" placeholder="Username หรือ ตำแหน่ง" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
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
						echo "<a href='manage_user.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='manage_user.php?page=$i' style='margin-right:20px'>$i</a>";
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
		        <center><h2> เพิ่มข้อมูลผู้ใช้</h2>
			        <table>
			        	<form action="" method="POST">
			        	<tr>
			        		<td>คำนำหน้า</td>
			        		<td>

			        		<select name="title" style="width: 80%;margin-left: 10%;">
			        		<?php 
			        		$rsTitle = $sql->select("*","title","");
			        		while($rwTitle = $rsTitle->fetch_assoc()){
			        			?>
			        			<option value="<?php echo $rwTitle['title_id']; ?>"><?php echo $rwTitle['title_name']; ?></option>
			        			<?php
			        		}
			        		?>
			        		</select>
			        	</td>
			        	</tr>
			        	<tr><td>ชื่อ</td><td><center><input style="width: 80%" type="text" name="name" value=""></td></tr>
			        	<tr><td>นามสกุล</td><td><center><input style="width: 80%" type="text" name="surname" value=""></td></tr>
			        	<tr><td>Email</td><td><center><input style="width: 80%" type="email" name="email" value=""></td></tr>
			        	<tr><td>Username</td><td><center><input style="width: 80%" type="text" name="username" value=""></td></tr>
			        	<tr><td>Password</td><td><center><input style="width: 80%" type="password" name="password" value=""></td></tr>
			        	<tr><td>Confirm Password</td><td><center><input style="width: 80%" type="password" name="confirm_password" value=""></td></tr>
			        	<tr>
			        		<td>ตำแหน่ง</td>
			        		<td>

			        		<select name="position" style="width: 80%;margin-left: 10%;">
			        		<?php 
			        		$rsPos = $sql->select("*","position","");
			        		while($rwPos = $rsPos->fetch_assoc()){
			        			?>
			        			<option value="<?php echo $rwPos['position_id']; ?>"><?php echo $rwPos['position']; ?></option>
			        			<?php
			        		}
			        		?>
			        		</select>
			        		</td>
			        	</tr>
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
      <th style="border-top-width: 0;" scope="col">ชื่อ-นามสกุล</th>
      <th style="border-top-width: 0;" scope="col">Username</th> 
      <th style="border-top-width: 0;" scope="col">ตำแหน่ง</th>
      <th style="border-top-width: 0;" scope="col">การทำงาน</th>
      <th style="border-top-width: 0;"></th>
    </tr>
  </thead>
  <tbody>

    <tr><?php
         
			if($result->num_rows>0){
			while($row=mysqli_fetch_assoc($result)){
					?>  
		<tr> 
			<th scope="row"><?php echo $row['person_id']; ?></th>	
			<th scope="row" style=""><?php echo $row['title_name'].$row['name']." ".$row['surname']; ?></th>
			<th scope="row"><?php echo $row['username']; ?></th> 
			<th scope="row"><?php echo $row['position']; ?></th>
			<th scope="row">
				<?php 
					if($row['user_status']=="unactivated"){
  						echo "<span style='color:red'>ยังไม่เปิดการใช้งาน</span>";
  					}else if($row['status']=="on"){?>
  		<button type="button" style="width: 140px;background-color:#afafaf;border-color: #afafaf" disabled class="btn btn-primary" >กำลังใช้งาน</button>
  				<?php
  					}else{
  						if($row['position_id']!=1){
  				?>
  							<button type="button" style="width: 140px" class="btn btn-warning" data-toggle="modal" data-target="#Modal<?php echo $row['person_id'] ?>">ปรับใช้งาน</button>
  					<?php 
  						}else{
  							echo "<span style='color:#6f6f6f'>ผู้ดูแลระบบ</span>";
  						}
  					}
  					
  				?>


<!-- Modal -->
		<div class="modal fade" id="Modal<?php echo $row['person_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		      </div>
		      <div class="modal-body">
		        <center>
		        	<h4>ชื่อ <?php echo $row['name']." ".$row['surname']; ?></h4>
		        	<h4>ตำแหน่ง <?php echo $row['position']; ?></h4>
			        	<form action="" method="POST"> 
			        		<input type="hidden" name="position_id" value="<?php echo $row['position_id']; ?>">
			        		<input type="hidden" name="person_id" value="<?php echo $row['person_id']; ?>">
			        	
		        <input type="submit" name="btn_go_on" class="btn btn-primary" value="เรียกใช้งาน">
      		  </div>
		      <div class="modal-footer"> 
			    </form>
				
		      </div>
		    </div>
		  </div>
		</div>

			</th>
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
		        <center><h2> จัดการข้อมูลคุณ <?php echo $row['name']; ?></h2>
			        <table>
			        	<form action="" method="POST">
			        	<tr>
			        		<td>คำนำหน้า</td>
			        		<td>

			        		<select name="title" style="width: 205px;">
			        		<?php 
			        		$rsTitle = $sql->select("*","title","");
			        		while($rwTitle = $rsTitle->fetch_assoc()){
			        			$title = $row['title_name'];
			        			?>
			        			<option <?php if($title==$rwTitle['title_name']){echo "selected";} ?>  value="<?php echo $rwTitle['title_id']; ?>"><?php echo $rwTitle['title_name']; ?></option>
			        			<?php
			        		}
			        		?>
			        		</select>
			        	</td>
			        	</tr>
			        	<tr><td>ชื่อ</td><td><center><input type="text" name="name" value="<?php echo $row['name']; ?>"></td></tr>
			        	<tr><td>นามสกุล</td><td><center><input type="text" name="surname" value="<?php echo $row['surname']; ?>"></td></tr>
			        	<tr><td>Username</td><td><center><input type="text" name="username" value="<?php echo $row['username']; ?>"></td></tr>
			        	<tr><td>Email</td><td><center><input type="email" name="email" value="<?php echo $row['person_email']; ?>"></td></tr>
			        	<tr><td>Password</td><td><center><input type="password" name="password" value="<?php echo $row['password']; ?>"></td></tr>
			        	<tr><td>เลือกสถานะ</td>
			        		<td><select style="width: 205px;" name="position">
				        			<?php 
					        			$result2 = $sql->select("*","position","");
						        			while($row2 = $result2->fetch_assoc()){	
						        				$position_id = $row2['position_id'];
						        				$position = $row2['position'];
						        				if($row2['position']==$row['position']){ $selected='selected';}else{$selected='';};
						        				echo "<option $selected value='$position_id'>$position</option>";
				        			} ?>
			        			</select>
			        		</td>
			        	</tr>
					</table>
      		  </div>
		      <div class="modal-footer">
			    <input type="hidden" name="person_id" value="<?php echo $row['person_id'];?>">
			    <input type="hidden" name="status" value="<?php echo $row['user_status'];?>">
		      	<input type="submit" name="btn_change" class="btn btn-warning" value="<?php if($row['user_status']=="activated"){
  						echo "ปิดการใช้งาน";}else{echo "เปิดการใช้งาน";} ?>">
		      	<input type="reset" name="" class="btn btn-secondary" value="ล้าง"> 
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

	
	if(isset($_POST['btn_go_on'])){		
		$position_id = $_REQUEST['position_id'];
		$person_id = $_REQUEST['person_id'];
		$result = $sql->update("person"," status='off'","position ='$position_id'");
		$result = $sql->update("person"," status='on' ","position ='$position_id' AND person_id ='$person_id'");
			if($result){ 
				$alert->status("30");
				$alert->link("0","manage_user.php");
			}else{ $alert->status("09");}	

	}
	if(isset($_POST['btn_change'])){
		$person_id=$_POST['person_id'];
		$status = $_POST['status'];
		$working_on='';
		if($status=="unactivated"){
			$status = "activated";
		}else{
			$status = "unactivated";
			$working_on = ", status = 'off'";
		}
		$result = $sql->update("person","user_status='$status' $working_on","person_id='$person_id'");
		$rsperson = $sql->select("*","person","person_id='$person_id'");
		$rsperson = $rsperon->fetch_assoc();
		$email = $rsperon['person_email'];
		$subject = "TMPD";
		if($status=="activated"){
			$body = "Your account is active.";
			$alert->sendMail($email,$body,$subject);
			$alert->status("60");	
		}else{
			$body = "Your account is disabled.";
			$alert->sendMail($email,$body,$subject);
			$alert->status("61");
		}
		$alert->link('0',"manage_user.php");

	}
	if(isset($_POST['btn_del'])){
		$person_id = $_POST['person_id'];
		$result = $sql->delete('person',"person_id='$person_id'");
		if($result){
			$alert->status("20");	
		}else{
			$alert->status("21");
		}
		$alert->link('0',"manage_user.php");
	}
	if(isset($_POST['btn_edit'])){
		$title=$_POST['title'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$position=$_POST['position'];
		$person_id=$_POST['person_id'];
		$email=$_POST['email'];
		$txt = "TMPD_KMUTNB";
		if($name!=''&&$surname!=''&&$username!=''&&$password!=''&&$title!=''&&$email!=''){
			$result = $sql->update("person","name='$name',surname='$surname'
				,username='$username',password=md5('$password$txt'),position='$position',title_id='$title',person_email='$email'","person_id='$person_id'");
		
			if($result){
				$alert->status("30");
		 	}else{
		 		$alert->status("99");
		 	}
	 		$alert->link("1","manage_user.php");
	 	}else{
	 		$alert->status("08");	
	 	}

	}

	if(isset($_POST['btn_add'])){
		$title=$_POST['title'];
		$name=$_POST['name'];
		$surname=$_POST['surname'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$position=$_POST['position'];
		$email=$_POST['email'];
		$confirm_password=$_POST['confirm_password'];
		if($email!=''&&$title!=''&&$name!=''&&$surname!=''&&$username!=''&&$password!=''&&$confirm_password!=''){
			$result=$sql->select("*","person","username='$username'");
			if($result->num_rows==0){
				if($password==$confirm_password){
					$txt = "TMPD_KMUTNB";
					$result = $sql->insert("person","name,surname,username,password,position,title_id,user_status,status,person_email","'$name','$surname','$username',md5('$password$txt'),'$position','$title','unactivated','off','$email'");
					if($result){
						$alert->status("10");
						$alert->link("1","manage_user.php");
					}
				}else{
					$alert->status("06");}					
			}else{ 
				$alert->status("05");}
		}else{
			$alert->status("08");}
	}
	

?>