<?php 
require_once('top.php'); 

function changmouth($id){
	if($id==1){
		return "มกราคม";
	}
	else if($id==2){
		return "กุมภาพันธ์";
	}
	else if($id==3){
		return "มีนาคม";
	}
	else if($id==4){
		return "เมษายน";
	}
	else if($id==5){
		return "พฤษภาคม";
	}
	else if($id==6){
		return "มิถุนายน";
	}
	else if($id==7){
		return "กรกฏาคม";
	}
	else if($id==8){
		return "สิงหาคม";
	}
	else if($id==9){
		return "กันยายร";
	}
	else if($id==10){
		return "ตุลาคม";
	}
	else if($id==11){
		return "พฤษจิกายน";
	}
	else if($id==12){
		return "ธันว่าคม";
	}
}
function checkMouth($id){
	return date('t',strtotime($id));
}
function setDate($date,$day){
	$day_date = substr($date,8,2);
	$mouth_date = substr($date,5,2);
	$year_date = substr($date,0,4);
	if($day!="0"){
		$day_date +=$day;
		if($day_date>checkMouth($date)){
		$day_date-=30;
		$mouth_date+=1;
		}
	}
	$date1 = $day_date."/".$mouth_date."/".$year_date;
	$date1=date('w', strtotime($date1));
	// echo $date1;
	if($date1==0){
		$day_date+=1;
		// echo "+1";
	}else if($date1==6){
		$day_date+=2;
		// echo "+2";
	}
	return $date=$day_date." ".changmouth($mouth_date)." ".$year_date;
}


$id = $_REQUEST['id'];
$result=$sql->select('*','activity',"id='$id'");
$row=$result->fetch_assoc();
$date = $row['date_create'];
$advertise = $row['advertise'];
$day_advertise = $row['day_advertise'];
$day_contract = $row['day_contract']; 
$contract = $row['contract']; 
$Deliver = $row['Deliver'];
?>

<style type="text/css">
	td{
		width: 200px;
		text-align: left;
	}
</style>
<h3>กำหนดการของแผนเร่งรัดการสั่งจ่ายงบประมาณ</h3>
<table class="table table-striped">
	<tr>
		<td>กำหนดการ</td>
		<td>วันที่เริ่ม</td>
		<td>วันสิ้นสุด</td>
	</tr>
	<tr>
		<td>กำหนดวันดำเนินการ</td>
		<td><?php echo setDate($date,0); ?></td>
	</tr>
	<tr>
		<td>จัดทำประกาศดำเนินการเผยแพร่</td>
		<td><?php if($advertise!=""){echo /*setDate($advertise,0)*/ $advertise;}else{echo"ยังไม่มีข้อมูล";}?></td>
		<td><?php if($advertise!=""){echo setDate($advertise,$day_advertise)."(รวม ".$day_advertise." วัน)";}else{echo "ยังไม่มีข้อมูล";} ?></td>
	</tr>
	<tr>
		<td>จัดทำสัญญากำหนดวันลงนามในสัญญา</td>
		<td><?php if($contract!=""){echo setDate($contract,0);}else{echo "ยังไม่มีข้อมูล";} ?></td>
		<td></td>
	</tr>
	<tr>
		<td>ต้องส่งมอบงานของอย่างช้าก่อนหรือภายใน</td>
		<td><?php if($contract!=""){echo setDate($contract,$day_contract)." (".$day_contract." วันหลังจากจัดทำสัญญา)";}else{echo "ยังไม่มีข้อมูล";} ?></td>
		<td></td>
	</tr>
	<tr>
		<td>วันที่ส่งมอบจริง</td>
		<td><?php if($Deliver!=""){echo setDate($Deliver,0);}else{echo "ยังไม่มีข้อมูล";} ?></td>
		<td></td>
	</tr>
	<tr>
		<td>วันที่เบิกจ่ายอย่างช้าสุด</td>
		<td><?php if($Deliver!=""){echo setDate($Deliver,7)."(7 วันหลังจากส่งมอบ)";}else{echo "ยังไม่มีข้อมูล";}?></td>
		<td></td>
	</tr>

</table> 
<?php 
require_once('../bottom.php'); ?>