<?php 
    require_once('code/class.sql.php'); 
    $sql = new sql(); 
    $activity_id = $_POST['activity_id'];
    $step = $_POST['step'];
    $version = $_POST['version'];
    $type = $_POST['type'];

    $rsActivityDetail = $sql->select('*','activity_detail',"activity_id = '$activity_id' AND step ='$step' ");
    $rwActivityDetail = $rsActivityDetail->fetch_assoc();
    if($rwActivityDetail!=null){
    	$id = $rsActivityDetail->num_rows;
    }else{
    	$id = 0;
    }
    $id++;
    $document_name = $activity_id."_".$id;

	copy($_FILES['upload']['tmp_name'],"file_upload/".$document_name.".pdf");
    $ch = $document_name.".pdf";
    
    date_default_timezone_set("Asia/Bangkok");
     $time1 = date("d/m/"); $time2=date(" H:i:s");
     $year = date("Y")+543;
     $date_now =  $time1.$year.$time2;

    $rs = $sql->insert('activity_detail','activity_id,step,document_name,version,step_detail_id,date',"'$activity_id','$step','$ch','$version','$type','$date_now'");
   
    echo $activity_id;
 ?>