<?php 
    require_once('code/class.sql.php'); 
    $sql = new sql(); 
    $step = $_POST['step'];
    $version = $_POST['version'];
    $id = $_POST['id'];
    $name = $_FILES['upload']['name'];
    $result = $sql->select("*","step_detail","step='$step' AND document_name='$name' AND version='$version'");
    $check  = $result->num_rows;
    if($check==0){
        $id = $id."s";
    	copy($_FILES['upload']['tmp_name'],"file_upload/".$name);
        $ch = $name;
        date_default_timezone_set("Asia/Bangkok");
        $time1 = date("d/m/"); $time2=date(" H:i:s");
        $year = date("Y")+543;
        $date_now =  $time1.$year.$time2;
        $rs = $sql->insert('step_detail','step,document_name,version,date,document_status',"'$step','$ch','$version','$date_now','off'");
    }else if($check >0){
        $id = $id."u";
    }
    echo $id;//////////return id
 ?>