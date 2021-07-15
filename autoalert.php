<?php 
	require_once("code/class.sql.php");
	require_once("code/class.alert.php");
	$sql = new sql();
	$alert = new alert();
	$result = $sql->select("*","activity","finish=''");
	while($result = $result->fetch_assoc()){
		$type = $result['type'];
		$version = $result['version'];
		$step = $result['step'];
		$topic = $result['topic'];

		$rs1 = $sql->select("*","step","version = '$version' AND type_id = '$type' AND step = '$step'");
		$rs1 =$rs1->fetch_assoc();
		$pos = $rs1['position_id'];

		$alert->sendLine("",$pos,"มีการดำเนินการค้างอยู่ในระบบ",$topic);
	}
?>