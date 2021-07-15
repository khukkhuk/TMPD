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
    $alert = new alert();?>
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
        #background{
            position:absolute;
            z-index:0;
            background:white;
            display:block;
            min-height:50%; 
            min-width:50%;
            color:yellow;
        }
    </style>
</head>
<?php 
    $sidebar_color = "#118DA3" ;
    $sub_sidebar_color = "#01A4C0" ;
    $button_menu = "#F37430";
 ?>
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
                    <a href="index.php">หน้าหลัก</a>
                </li> 
                <?php 
                    $rsPos = $sql->select("*","position","");
                    $rsPer = $sql->select("*","person","");
                 ?>
                <li class="active">
                    <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"  style="background-color:<?php echo $sidebar_color; ?>">จัดการข้อมูลผู้ใช้</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu1">
                    <?php if($rsPos->num_rows>1){ ?>
                        <li>
                            <a href="manage_user.php" style="background-color:<?php echo $sub_sidebar_color; ?>">บุคลากร</a>
                        </li>
                    <?php } ?>
                        <li>
                            <a href="manage_title.php" style="background-color:<?php echo $sub_sidebar_color; ?>">คำนำหน้า</a>
                        </li> 
                        <li>
                            <a href="manage_position.php" style="background-color:<?php echo $sub_sidebar_color; ?>">ตำแหน่งบุคลากร</a>
                        </li>
                    <?php if($rsPos->num_rows>1){ ?>
                        <li>
                            <a href="manage_position_type.php" style="background-color:<?php echo $sub_sidebar_color; ?>">กลุ่มตำแหน่งบุคลากร</a>
                        </li> 
                    <?php } ?>

                    <?php if($rsPer->num_rows>1){ ?>
                        <li>
                            <a href="manage_line.php" style="background-color:<?php echo $sub_sidebar_color; ?>">LineNotify</a>
                        </li> 
                    <?php } ?>
                    </ul>
                </li>

                <?php 
                    $rsAT = $sql->select('*',"activity_type","");
                    $rsVs = $sql->select('*',"version",""); 
                    
                 ?>

                <li class="active">
                    <a href="#homeSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"style="background-color:<?php echo $sidebar_color; ?>">จัดการการดำเนินการ</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu2">
                        <li>
                            <a href="manage_activity_type.php" style="background-color:<?php echo $sub_sidebar_color; ?>">ประเภทการดำเนินการ</a>
                        </li>
                    <?php if($rsVs->num_rows>0){ ?>
                        <li>
                            <a href="manage_step.php" style="background-color:<?php echo $sub_sidebar_color; ?>">ขั้นตอนการดำเนินการ</a>
                        </li>
                    <?php } ?>
                    <?php if($rsAT->num_rows>0){ ?>
                        <li>
                            <a href="manage_version.php" style="background-color:<?php echo $sub_sidebar_color; ?> ">เวอร์ชั่น</a>
                        </li>
                    <?php } ?>
                        <li>
                            <a href="manage_status.php" style="background-color:<?php echo $sub_sidebar_color; ?> ">สถานะ</a>
                        </li>
                    </ul>
                </li>

                
                <li>
                    <a href="finish_activity.php">ตรวจสอบการดำเนินการ</a>
                </li> 

                <li>
                    <a href="../document_house.php" target="_blank">คลังเอกสารต้นแบบ</a>
                </li> 

               <!--  <li>
                    <a href="alert_setting.php">ตั้งค่าการแจ้งเตือน</a>
                </li>  -->
            </ul>

            <ul class="list-unstyled" style="background-color: white">
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
                    <button type="button" id="sidebarCollapse" class="btn_menu" >
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
                            	ยินดีต้อนรับคุณ <?php echo $_SESSION['name']." ".$_SESSION['surname']; ?>
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
                <input type="hidden" name="status" value="a">
                <input type="hidden" name="person_id" value="<?php echo $_SESSION['person_id']; ?>">
                <input type="reset" name="" class="btn btn-secondary" value="Clear">
                <input type="submit" name="btn_add" class="btn btn-primary" value="Save Change">
                </form>
                
              </div>
            </div>
          </div>
        </div>
        <center>
<!-- <img style="position: fixed;opacity: 0.1;height: 70%" src="../login/hos.png"> -->
<img style="position: fixed;opacity: 0.1;height: 50%;top: 22%;transform: translate(-50%, 0);" src="../login/hos.png">
</center>

    <?php 
        $rsStep = $sql->select('*','step',"");
        if($rsStep->num_rows>0){
            $rsVersion = $sql->select('*','version',"status='on'");///////////get version status = on
            if($rsVersion->num_rows>0){
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
            $Str ="";
                for($i=1;$i>$CountType;$i++){
                    $key = $_SESSION['key'][$i];
                    $Str = " (type='".$key."' AND version ='".$_SESSION['type'][$key]."') OR".$Str;
                }
            $Str = substr($Str, 0,-2);
            $rsStep = $sql->select('*','step',"$Str"); //step has been Calculated (Show only status = on)
            }
        }
    ?>