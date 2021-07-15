<?php
if(session_status()==PHP_SESSION_NONE){
  session_start();
}
header('Content-Type: text/html; charset=utf-8');
if(empty($_SESSION['person_id'])){
    echo "<script type=\"text/javascript\">";
    echo "alert(\"กรุณาเข้าสู่ระบบ \");"; 
    echo "</script>"; 
    echo "<META HTTP-EQUIV='Refresh' CONTENT='1;URL= ../index.php'>";
}
?>
<?php  
    require_once('../code/class.sql.php'); 
    require_once('../code/class.alert.php'); 
    $sql = new sql(); 
    $alert = new alert();
    date_default_timezone_set("Asia/Bangkok");
    
    $time1 = date("d/m/"); $time2=date(" H:i:s"); ///convert year form Anno Domini to Buddhist calendar
    $year = date("Y")+543;
    $date_now =  $time1.$year.$time2;

    $sidebar_color = "#118DA3" ;
    $sub_sidebar_color = "#01A4C0" ;
    $button_menu = "#F37430"; 
    $show_comingwork = $sql->select("*","activity","(status_id='1' OR status_id='8') AND person_id='{$_SESSION['person_id']}'")->num_rows;
    $rsPerson = $sql->select("*","person","person_id='".$_SESSION['person_id']."'");
    $rsPerson = $rsPerson->fetch_assoc();
    if($rsPerson['status']=="off"){
        $_SESSION['status'] = "disabled";
    }else{

        $_SESSION['status'] = "";
    } 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href ="https://www.thaicreate.com/images/icon.ico" />

    <title>ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"> -----------------offline--------------- -->
    
    <style type="text/css">
        th{
            text-align: center;
        }
        .circle_text{
            color:white;
            padding:1px 7px;
            font-size:14px;
            background-color:red;
            border-radius:120px;
        }
        table tr:nth-child(even){
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" style="background-color: <?php echo $sidebar_color; ?>">
            <div class="sidebar-header" style="background-color: <?php echo $sidebar_color; ?>">
            <center> 
            <img style="height: 80px;" src="../login/hos.png">
            <img style="height: 80px;" src="../login/kmutnb_2.png">
            <img style="height: 100px;" src="../login/fitm_t.png">
            <div style="margin-top:15px;"><h5>ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5></div>
            </div>
            <ul class="list-unstyled components">

                <li>
                    <a href="index.php"  id="coming_work">หน้าหลัก</a>
                </li> 
                 <?php 
                 if($_SESSION['status']!='disabled'){

                ?>
                <li>
                    <a href="my_activity.php">รอดำเนินการ <?php if($show_comingwork>0){ echo "<span class='circle_text'>".$show_comingwork."</span>";} ?> </a>
                </li>
                <?php } ?>
                        
                <li>
                    <a href="follow_activity.php">ติดตามการดำเนินการ</a>
                </li> 

                <li>
                    <a href="success_activity.php">ข้อมูลเอกสารที่จบการดำเนินการ</a>
                </li> 
                <li>
                    <a href="../document_house.php" target="_blank">คลังเอกสารต้นแบบ</a>
                </li> 
 
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                	<!-- Credit -->
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <style type="text/css">
                        .btn_menu {
                            background-color: <?php echo $button_menu;?>;
                            border:none;
                            color:white;
                            display: inline-block;
                            font-weight: 400;
                            text-align: center;
                            white-space: nowrap;
                            vertical-align: middle;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            border: 1px solid transparent;
                            padding: .375rem .75rem;
                            font-size: 1rem;
                            line-height: 1.5;
                            border-radius: .25rem;
                            transition: color .15s cubic-bezier(0, 0.79, 0.58, 1),background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                        }
                    </style>
                    <button type="button" id="sidebarCollapse" class="btn_menu">
                        <i class="fas fa-align-left"></i>
                        <span> MENU</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                            	<?php  
                            	if(empty($_SESSION['person_id'])){
                            	 ?>
                            	<form>
                            		<input type="text" name="" placeholder="Username">
                            		<input type="text" name="" placeholder="Password">
                            		<input type="submit" name="" value="เข้าสู่ระบบ"> 
                            	</form>
                            	<?php 
                            		}else{ 
                            	?>
                            	ยินดีต้อนรับคุณ <?php echo $_SESSION['name']." ".$_SESSION['surname']." (".$_SESSION['position'].") "; ?>
                                <button type="button" style="border-width: 0;background-color:#f8f9fa;text-decoration-line: underline" data-toggle="modal" data-target="#edit_profile">
                          <i class="fas fa-user-circle" aria-hidden="true"></i>แก้ไขข้อมูล</button>
                                <a href="logout.php" style="text-decoration: underline;">ออกจากระบบ</a>
                            	<?php
                            		}
                            	 ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

<div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ระบบจัดการและติดตามเอกสารจัดซื้อจัดจ้าง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <center><h2>แก้ไขข้อมูล</h2>
                    <?php 
                        $person_data=$sql->select("*","person","person_id = '".$_SESSION['person_id']."'");
                        $person_data = $person_data->fetch_assoc();
                    ?>
                    <table>
                        <form id="form_edit">
                            <tr><td colspan="2"><center>แก้ไขชื่อ-นามสกุล</td></tr>
                            <tr>
                                <td>คำนำหน้า</td>
                                <td>
                                    <select name="title" style="width: 100%;">
                                        <?php 
                                            $rsTitle = $sql->select("*","title","");
                                            while($rwTitle = $rsTitle->fetch_assoc()){ 
                                            ?>
                                            <option <?php if($person_data['title_id']==$rwTitle['title_id']){echo "selected";} ?> value="<?php echo $rwTitle['title_id'] ?>"><?php echo $rwTitle['title_name'] ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>ชื่อจริง</td>
                                <td><input type="text" name="name" value="<?php echo $person_data['name']; ?>"></td>
                            </tr>
                            <tr>
                                <td>นามสกุล</td>
                                <td><input type="text" name="surname" value="<?php echo $person_data['surname']; ?>"></td>
                            </tr>
                            <tr>
                                <td>email</td>
                                <td><input type="email" name="email" value="<?php echo $person_data['person_email']; ?>"></td>
                            </tr>
                            <hr>
                            <tr><td colspan="2"><center>แก้ไขรหัสผ่าน</td></tr>
                            <tr><td>Password</td><td><center><input type="password" name="pass" value=""></td></tr>
                            <tr><td>Confirm Password</td><td><center><input type="password" name="passcon" value=""></td></tr> 
                            <tr><td>Old Password</td><td><center><input type="password" name="oldpass" value=""></td></tr>
                    </table>
              </div>
              <div class="modal-footer">
                <input type="hidden" name="status" value="u">
                <input type="hidden" name="person_id" value="<?php echo $_SESSION['person_id']; ?>">
                <input type="reset" name="" class="btn btn-secondary" value="Clear">
                <input type="submit" name="btn_add" class="btn btn-primary" value="Save Change">
                </form>
                
              </div>
            </div>
          </div>
        </div>




        <?php 
            $rsStep = $sql->select('*','step',"");
            $rsVersion = $sql->select('*','version',"status='on'");///////////get version status = on
                while($rwVersion = $rsVersion->fetch_assoc()){
                    $type_id = $rwVersion['type_id'];
                    $version = $rwVersion['version'];
                    $_SESSION["type"][$type_id] = $rwVersion['version']; /////save version to session
                } 
            $i=1;
                while($element = current($_SESSION['type'])) { ///////loop for get key from session type
                    $_SESSION['key'][$i]= key($_SESSION['type']);
                    next($_SESSION['type']);
                    $i++;
                }
            $CountType = count($_SESSION['type']);////////// count the session
            
            $Str_2 ="";
                for($i=1;$i<$CountType;$i++){
                    $key = $_SESSION['key'][$i];
                    $Str_2 = " (type_id='".$key."' AND version ='".$_SESSION['type'][$key]."')  OR".$Str_2;
                }
            $Str_2 = substr($Str_2, 0,-2);


            //$rsStep = $sql->select('*','step',"$Str"); //step has been Calculated (Show only status = on)
         ?>