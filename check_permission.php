<?PHP include "header.php";

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$username = $_SESSION['loginname'];

include "config.inc_clinic.php";

$doctorcode = $_SESSION["doctorcode"];

// ตรวจสอบ ระดับ

$sql_teacher = "SELECT * FROM tbl_teacher where teacher_doctorcode ='$doctorcode' and teacher_status = 1 ";
$query_teacher = $conn_clinic->query($sql_teacher);

$sql_student = "SELECT * FROM tbl_student where student_doctorcode = '$doctorcode'  ";
$query_student = $conn_clinic->query($sql_student);

$sql_staff = "SELECT * FROM tbl_staff where staff_doctorcode = '$doctorcode' and staff_status = 1 ";
$query_staff = $conn_clinic->query($sql_staff);


if ($result_teacher  = $query_teacher->fetch_assoc()) {

 $_SESSION["type_work_id"] = $result_teacher['type_work_id'];
 $_SESSION["teacher"] = 1;
 $_SESSION["user_id"] = $result_teacher['teacher_id'];
 $level = "Teacher";
 $permission = "Y";
 

} else if ($result_student  = $query_student->fetch_assoc()) {
  
 $_SESSION["student"] = 1;
 $_SESSION["user_id"] = $result_student['student_id'];
 $level = "Student";
 $permission = "Y";


} else if ($result_staff = $query_staff->fetch_assoc()) {


 $_SESSION["staff"] = 1;
 $_SESSION["user_id"] = $result_staff['staff_id'];
 $_SESSION["level_user"] = "Staff";
 $level = "Staff";
 $permission = "Y";
 $_SESSION["staff_level"] = $result_staff['staff_level'];

} else {

 $level = "N";
 $permission = "N";

}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Check Permission </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active"> <?php echo date('d-m-Y'); ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->






<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}



?>




<!-- Main content -->
<section class="content">
    <div class="container-fluid">



        <!-- Small boxes (Stat box) -->
        <div class="row">

            <div class="card card-default color-palette-box">


                <div class="card-header">
                    <h3 class="card-title"> <i class="fas fa-check-circle"></i> ตรวจสอบสิทธิเข้าใช้งานระบบ </h3>
                </div>
                <div class="card-body">

                    <h1>
                    <?php echo  $_SESSION['loginname']; ?> :
                    <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname'];?> -->>
                    <?php echo  $level;?>
                    </h1>
                 

                    <?PHP if ($permission == "Y") { ?>  

                        <span class="glyphicon glyphicon-flag"></span> 

                        <B>
                        <?php // อนุญาติให้เข้าใช้ระบบ
                              $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; 
                              echo "<b>IP Address :</b> ".$REMOTE_ADDR; 
                              echo " >> ";
                              $REMOTE_ADDR_substr = substr($REMOTE_ADDR, 0,6);
                          ?>

                              <?php if( $REMOTE_ADDR_substr == "10.151"){ ?>
                              ท่านเข้าระบบภายนอกโรงพยาบาล
                              <?php }else{ ?>
                              ท่านเข้าระบบภายในโรงพยาบาล
                              <?php } ?>
                        </B>

                        

                    <?PHP
                        echo "<META http-equiv=refresh content=6;url=index.php>";
                    }

                    ?>

                    กรุณารอสักครู่....!! 
                    

                      <!-- Growing Color spinnersr -->
              <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-secondary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-success" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-warning" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-info" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-light" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
              <div class="spinner-grow text-dark" role="status">
                <span class="visually-hidden">Loading...</span>
              </div><!-- End Growing Color spinners -->


            <?PHP if ($permission != "Y") { ?>  

            <p><span class="style1"> 

            <?php echo  $_SESSION['loginname']; ?> :
            <?php echo  $_SESSION['fname']; ?> <?php echo  $_SESSION['lname'];?> -->>
            <?php echo  $level;?>

            </font></span></p>
            <a href="logout.php" class="btn btn-outline-danger" >ออกจากระบบ</a>
            <?php echo "<META http-equiv=refresh content=3;url=logout.php>";?>

            <?PHP } ?>


                </div>
            </div>


        </div>


    </div>
</section>



<?php include "footer.php"; ?>