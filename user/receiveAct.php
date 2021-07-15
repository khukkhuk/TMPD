<?php 
	$id = $_POST['id'];
	$step = $_POST['step'];
	$version = $_POST['version']; 
	$count = $_POST['count'];
	$topic = $_POST['topic'];
	$status = $_POST['status'];
	$type = $_POST['type'];
	if($step==0){
		$step = $type."01";
		$rsActD = $sql->select('person_id',"activity","activity_id ='$id'");
		$rwActD = $rsActD->fetch_assoc();
		$person_id = $rwActD['person_id'];//last owner
		$alert->sendLine($person_id,"","ฝ่ายรับยืนยันการดำเนินการแล้ว",$topic);
	}else{
		$step = $step + 1;
		$rsActD = $sql->select('*',"activity_detail","activity_id ='$id' ORDER BY activity_detail_id DESC");
		$rwActD = $rsActD->fetch_assoc();
		$person_id = $rwActD['person_id'];//last owner
		$alert->sendLine($person_id,"","ฝ่ายรับยืนยันการดำเนินการแล้ว",$topic);
	}
	if($status=='8'){$step = $step -1 ;}
	// echo "person_id:".$person_id;
	$person_id = $_SESSION['person_id']; ///my id
	$count = (int)$count;
	$count = $count + 1;
	$sql->insert('activity_detail','activity_id,step,version,status_id,date,person_id,count',"'$id','$step','$version','3','$date_now','$person_id','$count'");
	$sql->update('activity',"status_id='3' ,step = '$step' , count ='$count'","activity_id ='$id'");
	$alert->link("0","index.php");
?>