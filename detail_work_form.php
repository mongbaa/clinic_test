<?php include "header.php";
?>


<?php
if (!isset($_SESSION['Login_clinic_test'])) {
    //echo "<META http-equiv=refresh content=0;url=login.php>"; 	
    //exit;
}

if (isset($_SESSION['do'])) {

    $do = $_SESSION['do'];

    echo "<script>";
    echo " Swal.fire({";
    echo "  title: 'สำเร็จ!',"; 
    echo "  text: '$do',";
    echo "  icon: 'success',";
    echo "  })";
    echo " </script>";
    unset($_SESSION['do']);
}


if (isset($_SESSION['error'])) {

    echo   $error = $_SESSION['error'];

    echo "<script>";
    echo " Swal.fire({";
    echo "  title: 'ไม่สำเร็จ!',";
    echo "  text: '$error',";
    echo "  icon: 'error',";
    echo "  })";
    echo " </script>";
    unset($_SESSION['error']);
}
?>

      
<?php

if($loginname == 'mongkol.th'){ 
    $student_id = '5510810060';
   }else{
    $student_id = $_SESSION["user_id"];
   }
?>


<?php
$type_work_id = $_SESSION['type_work_id'];

if (!empty($_GET['form_main_id'])) {

    $form_main_id = $_GET['form_main_id'];
    $form_main_name = $_GET['form_main_name'];

    $_SESSION['form_main_id'] = $form_main_id;
    //$_SESSION['do'] = 'ใบงาน :'.$form_main_name;

    echo "<script type='text/javascript'>";
    echo "window.location='detail_add.php';";
    echo "</script>";
}

include "config.inc.php";
$sql_work    = " SELECT * FROM tbl_type_work as type_work ";
$sql_work   .= " where type_work.type_work_id = $type_work_id ";
$query_work  = $conn->query($sql_work);
$result_work = $query_work->fetch_assoc();
$type_work_name = $result_work['type_work_name'];
$conn->close();
?>



<?php
if (!empty($_GET['del']) && !empty($_GET['check']) && ($_GET['check'] == md5($_GET['del'] . 'del7505'))) {
    include "config.inc.php";
    echo $sql_del = "DELETE FROM tbl_detail WHERE md5(detail_id) = '$_GET[del]' ";
    // $date_log = date('Y-m-d H:i:s');
    // $UserLogin_id = $_SESSION['UserLogin_id'];
    // $detail_log  =  ",DELETE|$date_log|$UserLogin_id/";
    //$sql_del = " UPDATE tbl_detail SET   detail_status = '0', detail_log = replace(detail_log, '/','$detail_log') WHERE md5(detail_id) = '$_GET[del]' ";
    $conn->query($sql_del);
    $conn->close();
    $_SESSION['do'] = 'ลบข้อมูลสำเร็จ';
    echo "<script type='text/javascript'>";
    echo "window.location='detail_work_form.php';";
    echo "</script>";
}
?>










<div class="pagetitle">
    <h1>สร้างใบงานสอบ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="detail_work.php">อนุสาขาวิชา</a></li>
            <li class="breadcrumb-item active"> <?php echo $type_work_name; ?> </li>
        </ol>
    </nav>
</div><!-- End Page Title -->





<section class="section dashboard">
    <div class="col-12">
        <div class="row">
            <?PHP
            include "config.inc.php";
            $sql  = " SELECT * FROM tbl_form_main as form_main ";
            // $sql .= " where  form_main.type_work_id = $type_work_id and form_main_confirm = 1";
            $sql .= " where  form_main.type_work_id = $type_work_id ";

            $sql .= " ORDER BY form_main.form_main_id ASC ";
            $query = $conn->query($sql);
            $i = 0;
            while ($result = $query->fetch_assoc()) {
                $i++;
                $form_main_name = $result['form_main_name'];
                $form_main_id = $result['form_main_id'];

                $form_main_detail = $result['form_main_detail'];
                $array_form_main_detail = json_decode($form_main_detail, true);
            ?>

                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card">
                        <div class="card-body">
                            <h5 class="card-title"> <?php echo $form_main_name; ?> </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <img src="image/7Pqg.gif" alt="unit_" class="rounded-circle" width="100%">
                                </div>
                                <div class="ps-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create<?php echo $form_main_id; ?>">
                                        สร้างใบงานสอบ
                                    </button>
                                    <form name="myForm" id="myForm" action="" method="post">
                                        <input name="type_work_id" type="hidden" value="<?php echo $type_work_id; ?>" />
                                        <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />
                                        <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                                        <div class="modal fade" id="create<?php echo $form_main_id; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> สร้างใบงานสอบ <?php echo $form_main_name; ?> <?php //echo $form_main_id; 
                                                                                                                                ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <?php if (in_array("hn", $array_form_main_detail)) { ?>
                                                            <br>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </label>
                                                                    <select name="HN" id="HN" class="form-control select2" required>
                                                                        <option value=""> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </option>

                                                                        <?php

                                                                        include "config.inc_clinic.php";
                                                                        $sql_order = " SELECT *  FROM tbl_order WHERE  student_id = $student_id and ";
                                                                        $sql_order .= "  causes_of_pay_id = '0' ";
                                                                        $query_order = $conn_clinic->query($sql_order);
                                                                        while ($result_order = $query_order->fetch_assoc()) {
                                                                        ?>

                                                                            <option value="<?php echo $result_order['HN']; ?>">
                                                                                HN : <?php echo $result_order['HN']; ?> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?></option>

                                                                        <?php
                                                                        }
                                                                        $conn_clinic->close();
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>


                                                        <?php  } else { ?>
                                                            <input name="HN" type="hidden" value="" />
                                                        <?php  } ?>


                                                        <?php if (in_array("s", $array_form_main_detail)) { ?>
                                                            <br>
                                                            <div class="col-md-12">


                                                                <div class="form-group">
                                                                    <label> Surface </label>
                                                                    <div class="row g-3">
                                                                        <?php for ($r = 0; $r <= 4; $r++) { ?>
                                                                            <div class="col-md-4">
                                                                                <select name="detail_surface[]" class="form-select select2">
                                                                                    <option value="">---</option>
                                                                                    <?php
                                                                                    include "config.inc_clinic.php";
                                                                                    $sql_surf = "SELECT * FROM tbl_surface";
                                                                                    $query_surf = $conn_clinic->query($sql_surf);
                                                                                    while ($row_surf = $query_surf->fetch_assoc()) {

                                                                                        $surface_shortname =  $row_surf['surface_shortname'];
                                                                                    ?>
                                                                                        <option value="<?php echo $row_surf['surface_shortname']; ?>">
                                                                                            <?php echo $row_surf['surface_shortname']; ?></option>
                                                                                    <?php }
                                                                                    $conn_clinic->close(); ?>

                                                                                </select>
                                                                            </div>

                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php  } else { ?>
                                                            <br>
                                                            <input name="surface_id" type="hidden" value="" />
                                                        <?php  } ?>







                                                        <?php if (in_array("r", $array_form_main_detail)) { ?>
                                                            <br>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label> Root </label>
                                                                    <select name="detail_root" class="form-select select2" required>
                                                                        <option value="">--เลือก--</option>
                                                                        <option value="1"> 1</option>
                                                                        <option value="2"> 2</option>
                                                                        <option value="3"> 3</option>
                                                                        <option value="4"> 4</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php  } else { ?>
                                                            <input name="detail_root" type="hidden" value="" />
                                                        <?php  } ?>






                                                        <?php if (in_array("t", $array_form_main_detail)) { ?>
                                                            <br>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label> Tooth </label>
                                                                    <select name="detail_tooth[]" id="e1<?php echo $form_main_id; ?>" class="form-select select2" multiple="multiple" data-placeholder=" Tooth" required>
                                                                        <!-- <select name="detail_tooth[]" size="10" multiple="multiple" class="duallistbox">-->



                                                                        <?php  //ซี่ที่ 11 - 18
                                                                        for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>

                                                                        <?php } ?>

                                                                        <?php  //ซี่ที่ 21 - 28
                                                                        for ($a = 21, $b = 9; $a <= 28, $b <= 16; $a++, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>


                                                                        <?php  //ซี่ที่ 41 - 48
                                                                        for ($a = 48, $b = 17; $a >= 41, $b <= 24; $a--, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>


                                                                        <?php //ซี่ที่ 31 - 38
                                                                        for ($a = 31, $b = 25; $a <= 38, $b <= 32; $a++, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>


                                                                        <?php  //ซี่ที่ 51 - 55
                                                                        for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>

                                                                        <?php } ?>

                                                                        <?php  //ซี่ที่ 61 - 65
                                                                        for ($a = 61, $b = 6; $a <= 65, $b <= 10; $a++, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>

                                                                        <?php  //ซี่ที่ 85 - 81
                                                                        for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>


                                                                        <?php  //ซี่ที่ $1 - $5
                                                                        for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
                                                                        ?>
                                                                            <option><?php echo $a; ?></option>
                                                                        <?php } ?>



                                                                    </select>


                                                                </div>
                                                            </div>

                                                        <?php  } else { ?>

                                                            <input name="detail_tooth[]" type="hidden" value="" />

                                                        <?php  } ?>






                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button name="submit" type="submit" value="submit" class="btn btn-primary"> <i class='ri-save-2-line'></i> สร้างใบงานสอบ</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Basic Modal-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sales Card -->








            <?php } ?>

        </div>
    </div>




    <div class="row">

        <div class="col-xxl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ข้อมูลใบประเมินการสอบ </h5>
                    <!-- Table with stripped rows -->
                    <table id="DataTable1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>อนุสาขาวิชา</th>
                                <th> HN</th>
                                <th> รายละเอียด </th>
                                <th>สถานะ</th>
                                <th width="15%">จัดการข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP
                            $detail_array = array();
                            include "config.inc.php";
                            $sql = " SELECT * FROM tbl_detail as d ";
                            $sql .= " INNER JOIN tbl_type_work as tw on d.type_work_id  = tw.type_work_id ";
                            $sql .= " INNER JOIN tbl_form_main as fm on  d.form_main_id  = fm.form_main_id ";
                            $sql .= " WHERE d.type_work_id = $type_work_id and d.student_id = $student_id ORDER BY d.detail_id ASC ";
                            $query = $conn->query($sql);

                            $i = 0;
                            while ($result = $query->fetch_assoc()) {
                            $i++;

                                $detail_id = $result['detail_id'];
                                $student_id = $result['student_id'];
                                $type_work_status = $result['type_work_status'];
                                $detail_tooth = $result['detail_tooth'];
                                $detail_surface = $result['detail_surface'];
                                $array_detail_surface = json_decode($detail_surface, true);
                                $array_detail_tooth = json_decode($detail_tooth, true);
                                $detail_array[] = array(
                                    'detail_id' => $result['detail_id'],
                                    'student_id' => $result['student_id'],
                                    'HN' => $result['HN'],
                                    'detail_tooth' => $result['detail_tooth'],
                                    'detail_surface' => $result['detail_surface'],
                                    'detail_root' => $result['detail_root']
                                );

                            ?>
                                <tr>
                                    <th scope="row">
                                        <?php echo $i; ?>
                                    </th>
                                    <td>(<?php echo $result['detail_id']; ?>) <?php echo $result['type_work_name']; ?> <br> <?php echo $result['form_main_name']; ?> </td>
                                    <td>
                                    ชื่อผู้ป่วย : <?php echo $result['patient_titel']; ?> <?php echo $result['patient_name']; ?> <?php echo $result['patient_lastname']; ?>
                                    <br>
                                    เลขที่บัตร : <?php echo $result['HN']; ?>
                                   </td>

                                    <td>
                                        <?php
                                        foreach ($array_detail_tooth as $id => $value) {
                                            if (!empty($value)) {
                                                echo $value . ", ";
                                            }
                                        }
                                        ?>

                                        |

                                        <?php
                                        foreach ($array_detail_surface as $id => $value) {
                                            if (!empty($value)) {
                                                echo $value . ", ";
                                            }
                                        }
                                        ?>

                                        <?php
                                        if (!empty($detail_root)) {
                                            echo "|";
                                            echo $result['detail_root'];
                                        }
                                        ?>

                                    </td>
                        <!--
                                    <td>
                                        <?php
                                            $detail_status = $result['detail_status'];
                                            switch ($detail_status) { // Harder page
                                                case 0:
                                                    echo " <a href='#' class='btn btn-secondary rounded-pill btn-sm'>รอประเมิน</a> ";
                                                    break;
                                                case 1:
                                                    echo " <a href='#' class='btn btn-success rounded-pill btn-sm'>ประเมินแล้ว</a>";
                                                    break;
                                                case 2:
                                                    echo " <a href='#' class='btn btn-danger rounded-pill btn-sm'> ไม่ประเมิน </a>";
                                                    break;
                                                default:
                                                    echo  "";
                                            }
                                        ?>
                                   </td>
                        -->



                                    <td>
                                    <?php
                                        switch ($result['detail_complete']) { // Harder page
                                            case 0:
                                                echo " <a href='#' class='btn btn-danger rounded-pill btn-sm'> ยังไม่ผ่าน </a>";
                                                break;
                                            case 1:
                                                echo " <a href='#' class='btn btn-success rounded-pill btn-sm'> ผ่าน </a>";
                                                break;
                                            default:
                                                echo  "";
                                        }
                                    ?>
                                    </td> 
                                    <td>


                                    <?php
                                     $sql_arrange = " SELECT * FROM tbl_arrange  WHERE detail_id = $detail_id";
                                     $query_arrange = $conn->query($sql_arrange);
                                     if($result_arrange = $query_arrange->fetch_assoc()){
                                   ?>

                                        <a href='evaluate_view.php?detail_id=<?php echo $detail_id; ?>' target='_blank' class='btn btn-primary btn-sm'> <i class="bx bxs-file"></i> View</a>



                                    <?php
                                      }else{ 
                                    ?>
                                        <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $detail_id; ?>"> <i class="bx bxs-edit"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#del<?php echo $detail_id; ?>"> <i class="bx bxs-trash"></i></a>
                                  
                                  

                                  
                                        <?php }?>
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#send<?php echo $detail_id; ?>"> <i class="bx bxs-send"></i></a>

                                        
                                       <?php
                                                if($loginname == 'mongkol.th'){ 
                                       ?>
                                        
                                     
                                        <a href='pdf.php?detail_id=<?php echo $detail_id; ?>' target='_blank' class='btn btn-success btn-sm'> PDF</a>
                                            
                                        <?php } ?>
                                    </td>
                                </tr>


                            <?php
                            }
                            $conn->close();
                            ?>

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->





                    <?php

                    foreach ($detail_array as $values => $data) {

                        $detail_id = $data['detail_id'];
                        $HN = $data['HN'];
                        $detail_tooth = $data['detail_tooth'];
                        $detail_surface = $data['detail_surface'];
                        $detail_root = $data['detail_root'];

                        $array_detail_surface = json_decode($detail_surface, true);
                        $array_detail_tooth = json_decode($detail_tooth, true);

                    ?>

                        <form name="myFormsend<?php echo $detail_id; ?>" id="myForm" action="" method="post">
                            <div class="modal fade" id="send<?php echo $detail_id; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning">
                                            <h5 class="modal-title"> ส่งใบงานประเมิน <?php echo md5($detail_id); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />

                                            <?php //echo $detail_id; ?>
                                            

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <select name="teacher_id" class="form-control select2" style="width: 100%;" required>
                                                        <option value="" selected="selected">
                                                            เลือกอาจารย์ผู้ประเมิน</option>

                                                        <?PHP
                                                        // include "config.inc.php";
                                                        // $sql_t =  "SELECT * FROM tbl_teacher where type_work_id = $detail_type_work_id";
                                                        // $query_t = $conn->query($sql_t);
                                                        // while ($result_t = $query_t->fetch_assoc()) {
                                                        ?>

                                                        <?PHP
                                                        echo $type_work_id;
                                                        $type_work_idss = sprintf("%02d", $type_work_id);
                                                        include "config.inc_clinic.php";
                                                        echo $sql_tt =  "SELECT * FROM tbl_teacher where  teacher_status = 1 and type_work_id_array like '%$type_work_idss%'";
                                                        $query_tt = $conn_clinic->query($sql_tt);
                                                        while ($result_tt = $query_tt->fetch_assoc()) {
                                                        ?>

                                                            <option value="<?php echo $result_tt['teacher_id']; ?>">
                                                                <?php echo $result_tt['teacher_name']; ?>
                                                                <?php echo $result_tt['teacher_surname']; ?>
                                                            </option>

                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>




                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button name="submit_send" type="submit" value="submit_send" class="btn btn-warning"> <i class='ri-save-2-line'></i> ส่งใบงานประเมิน </button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
                        </form>


                        <form name="myFormdel<?php echo $detail_id; ?>" id="myForm" action="" method="post">
                            <div class="modal fade" id="del<?php echo $detail_id; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h5 class="modal-title">Del <?php echo md5($detail_id); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />

                                            <h3>
                                                <font color="red">ยืนยันการลบอีกครั้ง</font>
                                            </h3>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button name="submit_del" type="submit" value="submit_del" class="btn btn-danger"> <i class='ri-save-2-line'></i> ลบใบงานสอบ</button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
                        </form>


                        <form name="myFormedit<?php echo $detail_id; ?>" id="myForm" action="" method="post">
                            <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />

                            <div class="modal fade" id="edit<?php echo $detail_id; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">แก้ไข <?php echo $detail_id; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">




                                            <?php if (!empty($HN)) { ?>

                                                <br>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </label>
                                                        <select name="HN" id="HN" class="form-control select2" required>
                                                            <option value=""> เลือกผู้ป่วยที่ต้องการเพิ่มงาน </option>

                                                            <?php
                                                            include "config.inc_clinic.php";
                                                            $sql_order = " SELECT *  FROM tbl_order WHERE  student_id = $student_id and ";
                                                            $sql_order .= "  causes_of_pay_id = '0' ";
                                                            $query_order = $conn_clinic->query($sql_order);
                                                            while ($result_order = $query_order->fetch_assoc()) {
                                                            ?>

                                                                <option value="<?php echo $result_order['HN']; ?>" <?php if (!(strcmp($result_order['HN'], $HN))) {
                                                                                                                        echo "selected=\"selected\"";
                                                                                                                    } ?>>
                                                                    HN : <?php echo $result_order['HN']; ?> <?php echo $result_order['fname']; ?> <?php echo $result_order['lname']; ?></option>

                                                            <?php
                                                            }
                                                            $conn_clinic->close();
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>


                                            <?php  } else { ?>
                                                <input name="HN" type="hidden" value="" />
                                            <?php  } ?>



                                            <?php
                                            $detail_surface =  $array_detail_surface[0];



                                            if (!empty($detail_surface)) { ?>
                                                <br>
                                                <div class="col-md-12">


                                                    <div class="form-group">
                                                        <label> Surface </label>
                                                        <div class="row g-3">
                                                            <?php for ($r = 0; $r <= 4; $r++) { ?>
                                                                <div class="col-md-4">
                                                                    <select name="detail_surface[]" class="form-select select2">
                                                                        <option value="">---</option>
                                                                        <?php
                                                                        include "config.inc_clinic.php";
                                                                        $sql_surf = "SELECT * FROM tbl_surface";
                                                                        $query_surf = $conn_clinic->query($sql_surf);
                                                                        while ($row_surf = $query_surf->fetch_assoc()) {
                                                                            $surface_shortname =  $row_surf['surface_shortname'];
                                                                        ?>
                                                                            <option value="<?php echo $row_surf['surface_shortname']; ?>" <?php if ($surface_shortname == $array_detail_surface["{$r}"]) {
                                                                                                                                                echo "selected=\"selected\"";
                                                                                                                                            } ?>>
                                                                                <?php echo $row_surf['surface_shortname']; ?></option>
                                                                        <?php }
                                                                        $conn_clinic->close(); ?>
                                                                    </select>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php  } else { ?>
                                                <br>
                                                <input name="surface_id[]" type="hidden" value="" />
                                            <?php  } ?>







                                            <?php if (!empty($detail_root)) { ?>
                                                <br>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label> Root </label>
                                                        <select name="detail_root" class="form-select select2" required>
                                                            <option value="">--เลือก--</option>
                                                            <option value="1" <?php if (!(strcmp(1, $detail_root))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>> 1</option>
                                                            <option value="2" <?php if (!(strcmp(2, $detail_root))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>> 2</option>
                                                            <option value="3" <?php if (!(strcmp(3, $detail_root))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>> 3</option>
                                                            <option value="4" <?php if (!(strcmp(4, $detail_root))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>> 4</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php  } else { ?>
                                                <input name="detail_root" type="hidden" value="" />
                                            <?php  } ?>






                                            <?php if (in_array("t", $array_form_main_detail)) { ?>
                                                <br>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label> Tooth </label>
                                                        <select name="detail_tooth[]" id="e1<?php echo $detail_id; ?>" class="form-select select2" multiple="multiple" data-placeholder=" Tooth" required>
                                                            <!-- <select name="detail_tooth[]" size="10" multiple="multiple" class="duallistbox">-->




                                                            <?php  //ซี่ที่ 11 - 18
                                                            for ($a = 18, $b = 1; $a >= 11, $b <= 8; $a--, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>

                                                            <?php } ?>

                                                            <?php  //ซี่ที่ 21 - 28
                                                            for ($a = 21, $b = 9; $a <= 28, $b <= 16; $a++, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>


                                                            <?php  //ซี่ที่ 41 - 48
                                                            for ($a = 48, $b = 17; $a >= 41, $b <= 24; $a--, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>


                                                            <?php //ซี่ที่ 31 - 38
                                                            for ($a = 31, $b = 25; $a <= 38, $b <= 32; $a++, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>


                                                            <?php  //ซี่ที่ 51 - 55
                                                            for ($a = 55, $b = 1; $a >= 51, $b <= 5; $a--, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>

                                                            <?php } ?>

                                                            <?php  //ซี่ที่ 61 - 65
                                                            for ($a = 61, $b = 6; $a <= 65, $b <= 10; $a++, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>

                                                            <?php  //ซี่ที่ 85 - 81
                                                            for ($a = 85, $b = 11; $a >= 81, $b <= 15; $a--, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>


                                                            <?php  //ซี่ที่ $1 - $5
                                                            for ($a = 71, $b = 16; $a <= 75, $b <= 20; $a++, $b++) {
                                                            ?>
                                                                <option <?php if (in_array($a, $array_detail_tooth)) {
                                                                            echo "selected=\"selected\"";
                                                                        } ?>><?php echo $a; ?></option>
                                                            <?php } ?>



                                                        </select>


                                                    </div>
                                                </div>

                                            <?php  } else { ?>

                                                <input name="detail_tooth[]" type="hidden" value="" />

                                            <?php  } ?>






                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button name="submit" type="submit" value="submit" class="btn btn-primary"> <i class='ri-save-2-line'></i> แก้ไขใบงานสอบ</button>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->

                        </form>

                    <?php

                    }
                    ?>









                </div>
            </div>
        </div><!-- End Card -->



        <div class="col-xxl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ประวัติการส่ง </h5>
                    <!-- Table with stripped rows -->
                    <table id="DataTable1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> ใบงานสอบ </th>
                                <th> วันที่</th>
                                <th> เวลา </th>
                                <th> อาจารย์ </th>
                                <th> สถานะ</th>
                                <th> วันที่ประเมิน </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP
                            $detail_array = array();
                            include "config.inc.php";
                            $sql_arrange = " SELECT * FROM tbl_arrange as a ";
                            $sql_arrange .= " INNER JOIN tbl_detail as d on  a.detail_id  = d.detail_id ";
                            $sql_arrange .= " INNER JOIN tbl_form_main as fm on d.form_main_id  = fm.form_main_id ";
                            $sql_arrange .= " INNER JOIN tbl_type_work as tw on d.type_work_id  = tw.type_work_id ";
                            $sql_arrange .= " WHERE d.type_work_id = $type_work_id and d.student_id = $student_id ORDER BY a.arrange_id ASC ";
                            $query_arrange = $conn->query($sql_arrange);
                            $i = 0;
                            while ($result_arrange = $query_arrange->fetch_assoc()) {
                            $i++;
                            $arrange_id = $result_arrange['arrange_id'];
                            ?>
                                <tr>
                                    <th> <?php echo $i; ?></th>
                                    <td> (<?php echo $result_arrange['detail_id']; ?>) <?php echo $result_arrange['form_main_name']; ?></td> 
                                    <td> <?php echo $result_arrange['arrange_date']; ?></td> 
                                    <td> <?php echo $result_arrange['arrange_time']; ?></td> 
                                    <td> <?php echo $result_arrange['teacher_id']; ?></td> 
                                    <td> 
                                    <?php
                                        switch ($result_arrange['arrange_check_eval']) { // Harder page
                                            case 0:
                                                echo " <a href='#' class='btn btn-secondary rounded-pill btn-sm'>รอประเมิน</a>";
                                                break;
                                            case 1:
                                                echo " <a href='#' class='btn btn-success rounded-pill btn-sm'> ประเมินแล้ว </a>";
                                                break;
                                            default:
                                                echo  "";
                                        }
                                    ?>
                                   </td> 
                                    <td> <?php echo $result_arrange['arrange_check_date_eval']; ?>
                                    <?php if($result_arrange['arrange_check_eval']==0){ ?>
                                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delsend<?php echo $arrange_id; ?>"> <i class="bx bxs-trash"></i></a>
                                    <?php } ?>
                                    </td> 

                                    
                                
                                
                               
                                </tr>


                                <?php if($result_arrange['arrange_check_eval']==0){ ?>
                                    <form name="myFormdelarrange<?php echo $detail_id; ?>" id="myForm" action="" method="post">
                                        <div class="modal fade" id="delsend<?php echo $arrange_id; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title">Del <?php echo md5($arrange_id); ?> / <?php echo $arrange_id; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <input name="arrange_id" type="hidden" value="<?php echo $arrange_id; ?>" />

                                                        <h3>
                                                            <font color="red">ยืนยันการยกเลิกอีกครั้ง</font>
                                                        </h3>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button name="submit_del_arrange" type="submit" value="submit_del_arrange" class="btn btn-danger"> <i class='ri-save-2-line'></i> ยกเลิกส่งใบงานสอบ</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Basic Modal-->
                                    </form>
                                <?php } ?>


                            <?php
                            }
                            $conn->close();
                            ?>

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->




                </div>
            </div>
        </div><!-- End Card -->


        <?PHP
        /*
        $detail_array = array();
        include "config.inc.php";
        $sql = " SELECT * FROM db_clinic_test.tbl_arrange as a ";
        $sql .= " INNER JOIN db_clinic_test.tbl_detail as d on a.detail_id  = d.detail_id ";
        $sql .= " INNER JOIN db_clinic_test.tbl_form_main as f on d.form_main_id  = f.form_main_id ";
        $sql .= " INNER JOIN db_clinic.tbl_teacher as t on a.teacher_id  = t.teacher_id ";
        $sql .= " ORDER BY a.arrange_id DESC ";
        $query = $conn->query($sql);
        $ii = 0;
        while ($result = $query->fetch_assoc()) {
            $ii++;

            $detail_id = $result['detail_id'];
            $arrange_id = $result['arrange_id'];
            $teacher_id = $result['teacher_id'];
            $detail_tooth = $result['detail_tooth'];
            $detail_surface = $result['detail_surface'];
            $array_detail_surface = json_decode($detail_surface, true);
            $array_detail_tooth = json_decode($detail_tooth, true);
            $arrange_date = $result['arrange_date'];
            $form_main_id = $result['form_main_id'];


                $sql_form_main  = " SELECT * FROM tbl_form_main as fm ";
                $sql_form_main  .= " INNER JOIN  tbl_type_work AS tw  on fm.type_work_id = tw.type_work_id ";
                $sql_form_main  .= " WHERE fm.form_main_id = '$form_main_id' ";
                $sql_form_main  .= " ORDER BY fm.form_main_id ASC ";
                $query_form_main  = $conn->query($sql_form_main);
                $result_form_main  = $query_form_main->fetch_assoc();

              
                $type_work_id = $result_form_main['type_work_id'];
                $form_main_name = $result_form_main['form_main_name'];
                $form_main_status = $result_form_main['form_main_status'];
                $form_main_detail = $result_form_main['form_main_detail'];
                $array_form_main_detail = json_decode($form_main_detail, true);
                $form_main_detail_step = $result_form_main['form_main_detail_step'];
                $array_form_main_detail_step = json_decode($form_main_detail_step, true);
                $form_main_confirm = $result_form_main['form_main_confirm'];
                $tbl = $result_form_main['form_main_table'];
              

                            $sql_check_ = " SELECT * FROM tbl_{$tbl} ";
                            $sql_check_ .= " WHERE  detail_id = $detail_id and arrange_id = $arrange_id";
                            $query_check_ = $conn->query($sql_check_);
                            if ($result_check_ = $query_check_->fetch_assoc()) {
                                $edit_id = $result_check_["{$tbl}_id"];
                                $edit_comment = $result_check_['comment'];
                                $edit_last_date = $result_check_['last_date'];
                                $edit_time_start = $result_check_['time_start'];
                                $edit_time_end = $result_check_['time_end'];
                            } else {
                                $edit_id = '';
                                $edit_comment = '';
                                $edit_last_date = $arrange_date;
                                $edit_time_start = '';
                                $edit_time_end = '';
                            }

                            */
        ?>


            <div class="col-xxl-6 col-md-12">
             
            </div>

        <?php
      //  }
      //  $conn->close();
        ?>






    </div>




    <?php

    if (isset($_POST['submit_send'])) {


        include "config.inc.php";



        if (isset($_POST['detail_id'])  && !empty($_POST['detail_id'])) {
            $detail_id = $conn->real_escape_string($_POST['detail_id']);
        } else {
            $detail_id = 0;
        }


        if (isset($_POST['teacher_id'])  && !empty($_POST['teacher_id'])) {
            $teacher_id = $conn->real_escape_string($_POST['teacher_id']);
        } else {
            $teacher_id = 0;
        }

        $arrange_date = date('Y-m-d');
        $arrange_time = date('H:i:s');
        $arrange_check_eval = 0;
        $arrange_check_date_eval = '0000-00-00';

        $sql = "INSERT INTO tbl_arrange (arrange_id, detail_id, arrange_date, arrange_time, teacher_id, arrange_check_eval, arrange_check_date_eval) VALUES (NULL, '$detail_id', '$arrange_date', '$arrange_time', '$teacher_id', '0', '0000-00-00');";
        $conn->query($sql);

        $_SESSION['do'] = 'ลบสำเร็จ';

        $conn->close();
        echo "<script type='text/javascript'>";
        //echo "alert('[บันทึกข้อมูสำเร็จ]');";
        echo "window.location='detail_work_form.php';";
        echo "</script>";
    }


    if (isset($_POST['submit_del_arrange'])) {


        include "config.inc.php";



        if (isset($_POST['arrange_id'])  && !empty($_POST['arrange_id'])) {
            $arrange_id = $conn->real_escape_string($_POST['arrange_id']);
        } else {
            $arrange_id = 0;
        }


        $sql_del = "DELETE FROM tbl_arrange WHERE arrange_id = $arrange_id";
        $conn->query($sql_del);

        $_SESSION['do'] = 'ลบสำเร็จ';

        $conn->close();
        echo "<script type='text/javascript'>";
        //echo "alert('[บันทึกข้อมูสำเร็จ]');";
        echo "window.location='detail_work_form.php';";
        echo "</script>";
    }


    if (isset($_POST['submit_del'])) {

        include "config.inc.php";
        if (isset($_POST['detail_id'])  && !empty($_POST['detail_id'])) {
            $detail_id = $conn->real_escape_string($_POST['detail_id']);
        } else {
            $detail_id = 0;
        }

        $sql_del = "DELETE FROM tbl_detail WHERE detail_id = $detail_id";
        $conn->query($sql_del);
        $_SESSION['do'] = 'ลบสำเร็จ';
        $conn->close();
        echo "<script type='text/javascript'>";
        echo "window.location='detail_work_form.php';";
        echo "</script>";
    }



    if (isset($_POST['submit_del_arrange'])) {

        include "config.inc.php";
        if (isset($_POST['arrange_id'])  && !empty($_POST['arrange_id'])) {
            $arrange_id = $conn->real_escape_string($_POST['arrange_id']);
        } else {
            $arrange_id = 0;
        }

        $sql_del = "DELETE FROM tbl_arrange WHERE arrange_id = $arrange_id";
        $conn->query($sql_del);
        $_SESSION['do'] = 'ยกเลิกสำเร็จ';
        $conn->close();
        echo "<script type='text/javascript'>";
        echo "window.location='detail_work_form.php';";
        echo "</script>";
    }


    


    if (isset($_POST['submit'])) {

        include "config.inc.php";

        if (isset($_POST['detail_id'])  && !empty($_POST['detail_id'])) {
            $detail_id = $conn->real_escape_string($_POST['detail_id']);
        } else {
            $detail_id = 0;
        }


        if (isset($_POST['type_work_id'])  && !empty($_POST['type_work_id'])) {
            $type_work_id = $conn->real_escape_string($_POST['type_work_id']);
        } else {
            $type_work_id = 0;
        }


        if (isset($_POST['form_main_id'])  && !empty($_POST['form_main_id'])) {
            $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
        } else {
            $form_main_id = 0;
        }


        if (isset($_POST['student_id'])  && !empty($_POST['student_id'])) {
            $student_id = $conn->real_escape_string($_POST['student_id']);
        } else {
            $student_id = 0;
        }


        if (isset($_POST['HN'])  && !empty($_POST['HN'])) {
            $HN = $conn->real_escape_string($_POST['HN']);
        } else {
            $HN = 0;
        }

        include "config.inc_clinic.php";
        $sql_order = " SELECT *  FROM tbl_order WHERE  HN = $HN ";
        $query_order = $conn_clinic->query($sql_order);
        $result_order = $query_order->fetch_assoc();

        $patient_titel    = $result_order['pname'];
        $patient_name     = $result_order['fname'];
        $patient_lastname = $result_order['lname'];


        if (isset($_POST['detail_tooth'])) {
            $detail_tooth = json_encode($_POST['detail_tooth']);
        } else {
            $detail_tooth = json_encode([]);
        }

        if (isset($_POST['detail_surface'])) {
            $detail_surface = json_encode($_POST['detail_surface']);
        } else {
            $detail_surface = json_encode([]);
        }

        if (isset($_POST['detail_root'])  && !empty($_POST['detail_root'])) {
            $detail_root = $conn->real_escape_string($_POST['detail_root']);
        } else {
            $detail_root = 0;
        }



        $detail_status = 0;
        $detail_date_last = date('Y-m-d');
        $id_user = $_SESSION['session_clinic_test'];
        $ipp = $_SERVER['REMOTE_ADDR'];

        if (!empty($detail_id)) {


            $detail_log  = ",UP|" . date('Y-m-d H:s:i') . "|" . $ipp . "|$id_user/";
            $sql_up = " UPDATE  tbl_detail SET ";
            $sql_up .= "  HN = '$HN', ";
            $sql_up .= "  patient_titel = '$patient_titel', ";
            $sql_up .= "  patient_name = '$patient_name', ";
            $sql_up .= "  patient_lastname = '$patient_lastname', ";
            $sql_up .= "  detail_tooth = '$detail_tooth', ";
            $sql_up .= "  detail_surface = '$detail_surface', ";
            $sql_up .= "  detail_root = '$detail_root', ";
            $sql_up .= " detail_log = replace(detail_log, '/','$detail_log')";
            $sql_up .= " WHERE  detail_id = '$detail_id' ";
            $conn->query($sql_up);

            $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';
        } else {


            $detail_log = "IN|" . date('Y-m-d H:s:i') . "|" . $ipp . "|$id_user/";
            $sql_in = " INSERT INTO tbl_detail (detail_id, type_work_id, form_main_id, student_id, HN,  patient_titel, patient_name, patient_lastname, detail_tooth, detail_surface, detail_root, detail_log, detail_date_last, detail_status) VALUES ";
            echo   $sql_in .= " (NULL, '$type_work_id', '$form_main_id', '$student_id', '$HN', '$patient_titel', '$patient_name', '$patient_lastname', '$detail_tooth', '$detail_surface', '$detail_root', '$detail_log', '$detail_date_last', '$detail_status') ";
            $conn->query($sql_in);

            $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
        }



        $conn->close();

        echo "<script type='text/javascript'>";
        //echo "alert('[บันทึกข้อมูสำเร็จ]');";
        echo "window.location='detail_work_form.php';";
        echo "</script>";
    }


    ?>





</section>




<?php include "footer.php"; ?>