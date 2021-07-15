<?php
require_once('top.php');
?>

		<center><h4> การดำเนินการ </h4></center>

 <?php 

	$perpage = 7;
	$start = 0;
	if(isset($_GET['page'])AND($_GET['page'])!=''){
		$start = $perpage * ($_GET['page']-1);
	}
	$acttype = "";
	if(isset($_GET['activity_type'])AND $_GET['activity_type']!='all'){
		$acttype = "AND activity.type = '".$_GET['activity_type']."'";
	}
	if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
		$result=$sql->select("*","activity left join activity_type on activity.type = activity_type.activity_type_id","topic like '%".$_GET['txt_search']."%' AND finish='' $acttype LIMIT $start , $perpage");

		$result_page=$sql->select("*","activity left join activity_type on activity.type = activity_type.activity_type_id","topic like '%".$_GET['txt_search']."%' AND finish='' $acttype");
	}else{
		$result=$sql->select("*","activity left join activity_type on activity.type = activity_type.activity_type_id","finish='' $acttype LIMIT $start, $perpage");
		$result_page=$sql->select("*","activity left join activity_type on activity.type = activity_type.activity_type_id","finish='' $acttype");
	}
		
	$showpage = ceil($result_page->num_rows / $perpage);


?>

	<form style="margin-left: 3%;float: left" action="" method="GET">
		<input type="text" class="txt_search" placeholder="หัวข้อ" name="txt_search" style="border-radius: 7px;padding: 2px;border-width: 1px;" > 
		<select name="activity_type">
			<option selected disabled>เลือกประเภทการดำเนินการ</option>
			<option value="all">ดูทั้งหมด</option>
			<?php 
				$rsAcT = $sql->select("*","activity_type","");
				while($rwAcT = $rsAcT->fetch_assoc()){
					if($_GET['activity_type']==$rwAcT['activity_type_id']){
						$show_type = $rwAcT['type'];
					}
					echo "<option value='".$rwAcT['activity_type_id']."'>".$rwAcT['type']."</option>";
				}
			 ?>
		</select>
		<button  class="btn_search" style="border:none;background-color: #fafafa">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>
<div style="float: right;margin-right: 5%;"><?php if(isset($show_type)) echo $show_type; ?> มี <?php echo $result_page->num_rows; ?> การดำเนินการที่ยังไม่สิ้นสุด</div>
	
	<div style="float: right;margin-right: 18px;">
		<?php 
			if($showpage>1){
				for ($i=1; $i <= $showpage ; $i++) { 
					if(isset($_GET['txt_search'])AND($_GET['txt_search'])!=''){
						echo "<a href='index.php?page=$i&txt_search=".$_GET['txt_search']."' style='margin-right:20px'>$i</a>";
					}else{
						echo "<a href='index.php?page=$i' style='margin-right:20px'>$i</a>";
					}
				} 
			}
		?>
	</div>



<table class="table table"> 
  <thead>
    <tr>
      <th style="border-top-width: 0;" scope="col">ID</th>
      <th style="border-top-width: 0;" scope="col">หัวข้อ</th>
      <th style="border-top-width: 0;" scope="col">วันที่ยื่นเรื่อง</th>
      <th style="border-top-width: 0;" scope="col">ประเภทงาน</th> 
      <th style="border-top-width: 0;">ติดตามการดำเนินการ</th>
    </tr>
  </thead>
  <tbody>
	<tr>
    	<?php
			if($result->num_rows>0){
				while($row=mysqli_fetch_assoc($result)){
		?> 
		<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
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
			<th scope="row"><?php echo $row['activity_id']; ?></th>	
			<th scope="row"><?php echo $row['topic']; ?></th>	
			<th scope="row"><?php echo $row['date_create']; ?></th>
			<th scope="row"><?php echo $row['type']; ?></th> 
			<th scope="row"><a target="_blank" href="../track.php?id=<?php echo $row['activity_id']; ?>"><i class="fas fa-list-alt"></i></a></th>
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
		?></tr>
  </tbody>
</table>

<?php
require_once('../bottom.php');
?>