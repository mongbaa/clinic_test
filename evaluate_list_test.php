<?php include "header.php"; ?>


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

    $error = $_SESSION['error'];
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
// รูปแบบของเวลาที่ใช้คำนวณ แบบ 
// อยู่ในรูปแบบ 00:00:00 ถึง 23:59:59

function diff2time($time_a, $time_b)
{
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    $time_diff_h = floor($time_diff / 3600); // จำนวนชั่วโมงที่ต่างกัน
    $time_diff_m = floor(($time_diff % 3600) / 60); // จำวนวนนาทีที่ต่างกัน
    $time_diff_s = ($time_diff % 3600) % 60; // จำนวนวินาทีที่ต่างกัน
    //return $time_diff_h . " ชั่วโมง " . $time_diff_m . " นาที " . $time_diff_s . " วินาที";
    return $time_diff_h . "." . $time_diff_m;
}


function diff2time_short($time_a, $time_b)
{
    $now_time1 = strtotime(date("Y-m-d " . $time_a));
    $now_time2 = strtotime(date("Y-m-d " . $time_b));
    $time_diff = abs($now_time2 - $now_time1);
    $time_diff_h = floor($time_diff / 3600); // จำนวนชั่วโมงที่ต่างกัน
    $time_diff_m = floor(($time_diff % 3600) / 60); // จำวนวนนาทีที่ต่างกัน
    $time_diff_s = ($time_diff % 3600) % 60; // จำนวนวินาทีที่ต่างกัน
    return $time_diff_h . "." . $time_diff_m;
}

// การใช้งาน
//echo diff2time("17:42:51","16:37:56");
// ผลลัพธิ์
// 1 ชั่วโมง 4 นาที 55 วินาที 

//////////////////////////////////
/*$time_a="17:42:51";
$time_b="16:37:56";
echo diff2time($time_a,$time_b);
*/
// ผลลัพธิ์
// 1 ชั่วโมง 4 นาที 55 วินาที 
?>



<?php

$detail_id = (!empty($_GET['detail_id'])) ?  $_GET['detail_id'] : 0;

?>


<style>


</style>



<div class="pagetitle">
    <h1>ประเมินการสอบ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="detail_work.php">อนุสาขาวิชา</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->









<section class="section">

    <div class="row">




        <?php if (!empty($detail_id)) { ?>


            <?PHP
            include "config.inc.php";
            $sql = " SELECT * FROM db_clinic_test.tbl_arrange as a ";
            $sql .= " INNER JOIN db_clinic_test.tbl_detail    as d on a.detail_id     = d.detail_id ";
            $sql .= " INNER JOIN db_clinic_test.tbl_form_main as f on d.form_main_id  = f.form_main_id ";
            $sql .= " INNER JOIN db_clinic.tbl_teacher as t on a.teacher_id  = t.teacher_id ";
            $sql .= " INNER JOIN db_clinic.tbl_student as s on d.student_id  = s.student_id ";
            $sql .= " where  a.detail_id = $detail_id ";
            $sql .= " ORDER BY a.arrange_id DESC ";
            $query = $conn->query($sql);
            $result = $query->fetch_assoc();

            $detail_id = $result['detail_id'];
            $arrange_id = $result['arrange_id'];
            $teacher_id = $result['teacher_id'];
            $student_id = $result['student_id'];
            $detail_tooth = $result['detail_tooth'];
            $detail_surface = $result['detail_surface'];
            $arrange_check_eval = $result['arrange_check_eval'];
            $detail_complete = $result['detail_complete'];




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
            $type_work_name = $result_form_main['type_work_name'];
            $form_main_name = $result_form_main['form_main_name'];
            $form_main_status = $result_form_main['form_main_status'];


            $form_main_detail = $result_form_main['form_main_detail'];
            $array_form_main_detail = json_decode($form_main_detail, true);

            $form_main_detail_step = $result_form_main['form_main_detail_step'];
            $array_form_main_detail_step = json_decode($form_main_detail_step, true);

            $form_main_confirm = $result_form_main['form_main_confirm'];
            $tbl = $result_form_main['form_main_table'];


            $sql_check_ = " SELECT * FROM tbl_{$tbl} ";
            $sql_check_ .= " WHERE  detail_id = $detail_id ";
            $query_check_ = $conn->query($sql_check_);

            if ($result_check_ = $query_check_->fetch_assoc()) {
                $edit_id = $result_check_["id"];
                $edit_comment = $result_check_['comment'];

                if (in_array('ct', $array_form_main_detail)) {

                    for ($x = 1; $x <= 4; $x++) {
                        $edit_count[$x] = $result_check_["count{$x}"];
                        $edit_last_date[$x] = $result_check_["last_date{$x}"];
                        $edit_time_start[$x] = $result_check_["time_start{$x}"];
                        $edit_time_end[$x] = $result_check_["time_end{$x}"];
                    }

                    // if (isset($result_check_["count1"]) && !empty($result_check_["count1"])) { $edit_count1 = $result_check_["count1"]; } else { $edit_count1 = '';  }
                    // if (isset($result_check_["last_date1"]) && !empty($result_check_["last_date1"])) { $edit_last_date1 = $result_check_["last_date1"]; } else { $edit_last_date1 = '0000-00-00';  }
                    // if (isset($result_check_["time_start1"]) && !empty($result_check_["time_start1"])) { $edit_time_start1 = $result_check_["time_start1"]; } else { $edit_time_start1 = '00:00:00';  }
                    // if (isset($result_check_["time_end1"])   && !empty($result_check_["time_end1"])) {   $edit_time_end1   = $result_check_["time_end1"];   } else { $edit_time_end1 = '00:00:00';  }

                    // if (isset($result_check_["count2"]) && !empty($result_check_["count2"])) { $edit_count2 = $result_check_["count2"]; } else { $edit_count2 = ''; }
                    // if (isset($result_check_["last_date2"]) && !empty($result_check_["last_date2"])) { $edit_last_date2 = $result_check_["last_date2"]; } else { $edit_last_date2 = '0000-00-00'; }
                    // if (isset($result_check_["time_start2"]) && !empty($result_check_["time_start2"])) { $edit_time_start2 = $result_check_["time_start2"]; } else { $edit_time_start2 = '00:00:00'; }
                    // if (isset($result_check_["time_end2"]) && !empty($result_check_["time_end2"])) { $edit_time_end2 = $result_check_["time_end2"]; } else { $edit_time_end2 = '00:00:00'; }

                    // if (isset($result_check_["count3"]) && !empty($result_check_["count3"])) { $edit_count3 = $result_check_["count3"]; } else { $edit_count3 = ''; }
                    // if (isset($result_check_["last_date3"]) && !empty($result_check_["last_date3"])) { $edit_last_date3 = $result_check_["last_date3"]; } else { $edit_last_date3 = '0000-00-00'; }
                    // if (isset($result_check_["time_start3"]) && !empty($result_check_["time_start3"])) { $edit_time_start3 = $result_check_["time_start3"]; } else { $edit_time_start3 = '00:00:00'; }
                    // if (isset($result_check_["time_end3"]) && !empty($result_check_["time_end3"])) { $edit_time_end3 = $result_check_["time_end3"]; } else { $edit_time_end3 = '00:00:00'; }

                    // if (isset($result_check_["count4"]) && !empty($result_check_["count4"])) { $edit_count4 = $result_check_["count4"]; } else { $edit_count4 = ''; }
                    // if (isset($result_check_["last_date4"]) && !empty($result_check_["last_date4"])) { $edit_last_date4 = $result_check_["last_date4"]; } else { $edit_last_date4 = '0000-00-00'; }
                    // if (isset($result_check_["time_start4"]) && !empty($result_check_["time_start4"])) { $edit_time_start4 = $result_check_["time_start4"]; } else { $edit_time_start4 = '00:00:00'; }
                    // if (isset($result_check_["time_end4"]) && !empty($result_check_["time_end4"])) { $edit_time_end4 = $result_check_["time_end4"]; } else { $edit_time_end4 = '00:00:00'; }



                } else {
                    $edit_last_date = $result_check_['last_date'];
                    $edit_time_start = $result_check_['time_start'];
                    $edit_time_end = $result_check_['time_end'];
                }
            } else {

                $edit_id = '';
                $edit_comment = '';

                if (in_array('ct', $array_form_main_detail)) {

                    for ($x = 1; $x <= 4; $x++) {

                        $edit_count[$x] = $x;

                        if ($x == 1) {
                            $edit_last_date[$x] = $arrange_date;
                        } else {
                            $edit_last_date[$x] = '';
                        }

                        $edit_time_start[$x] = '';
                        $edit_time_end[$x] = '';
                    }
                } else {

                    $edit_last_date = $arrange_date;
                    $edit_time_start = '';
                    $edit_time_end = '';
                }
            }

            ?>






            <div class="d-flex justify-content-center">
                <div class="col-xxl-10 col-md-12">

                    <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                        <div class="card">


                            <div class="card-body">
                                <h5 class="card-title"> </h5>

                                <div class="row">
                                    <div class="col-6">
                                        <div align="left">
                                            <img src="image/LOGO-TDC-NEW.png" alt="LOGO-TDC-NEW" width="320">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div align="right">
                                            <img src="../pic_students/<?php echo $result['student_id']; ?>.jpg" width="120" height="120" style="border-radius:50%;" class="img-circle responsive" alt="<?php echo $result['student_id']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <h3> ใบประเมินการปฏิบัติงาน <B><?php echo $form_main_name; ?></B> </h3>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div align="left">
                                            <h5>
                                                ชื่อผู้สอบ : <?php echo $result['student_name']; ?> <?php echo $result['student_lastname']; ?>
                                                เลขที่ : <?php echo $result['student_id']; ?>
                                            </h5>
                                            <hr>
                                            <h5>
                                                ชื่อผู้ป่วย : <?php echo $result['patient_titel']; ?> <?php echo $result['patient_name']; ?> <?php echo $result['patient_lastname']; ?>
                                                เลขที่บัตร : <?php echo $result['HN']; ?>
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div align="right">
                                            <h5>
                                                <?php
                                                if (!empty($array_detail_tooth)) {
                                                    echo "ฟันซี่ ";
                                                }
                                                foreach ($array_detail_tooth as $id => $value) {
                                                    if (!empty($value)) {
                                                        echo '<a href="#" class="btn btn-warning rounded-pill btn-sm"><B>' . $value . '</B></a> ' . " ";
                                                    }
                                                }
                                                if (!empty($array_detail_surface)) {
                                                    echo "ด้าน ";
                                                }
                                                foreach ($array_detail_surface as $id => $value) {
                                                    if (!empty($value)) {
                                                        echo '<a href="#" class="btn btn-info rounded-pill btn-sm"><B>' . $value . '</B></a> ' . " ";
                                                    }
                                                }
                                                if (!empty($detail_root)) {
                                                    echo "ราก";
                                                    echo $result['detail_root'];
                                                }
                                                ?>
                                            </h5>
                                            <?php
                                            $arrange_check_eval = $result['arrange_check_eval'];
                                            switch ($arrange_check_eval) { // Harder page
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
                                            <?php
                                            echo '<a href="#" class="btn btn-success rounded-pill btn-sm"> <i class="ri ri-user-2-fill"></i> อ.' . $result['teacher_name'] . ' ' . $result['teacher_surname'] . '</a> ' . " ";
                                            echo '<a href="#" class="btn btn-secondary rounded-pill btn-sm">   <i class="ri ri-time-line"></i> Date:' . $result['arrange_date'] . ' ' . $result['arrange_time'] . '</a> ' . " ";
                                            ?>
                                            <br>
                                        </div>
                                    </div>
                                </div>


                                <br>


                                <div class="row">
                                   


                                    <?php if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง 
                                    ?>



                                        <?php
                                        for ($xx = 1; $xx <= 4; $xx++) {
                                            $edit_count[$xx];
                                            $edit_last_date[$xx];
                                            $edit_time_start[$xx];
                                            $edit_time_end[$xx];
                                        ?>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="count" class="form-label">ครั้งที่ </label>
                                                    <input type="number" name="count<?php echo $x; ?>" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_count[$xx]; ?>">
                                                    <div class="invalid-feedback"> กรุณากรอก ครั้งที่ </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="last_date" class="form-label">วันที่</label>
                                                    <input type="date" name="last_date<?php echo $x; ?>" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_last_date[$xx]; ?>">
                                                    <div class="invalid-feedback"> กรุณากรอก วันที่ประเมินการสอบ </div>
                                                </div>
                                            </div>




                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_start" class="form-label">เวลาเริ่มสอบ </label>
                                                    <input type="time" name="time_start<?php echo $x; ?>" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_time_start[$xx]; ?>">
                                                    <div class="invalid-feedback"> กรุณากรอก เวลาเริ่มสอบ </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_end" class="form-label">เวลายุติการสอบ </label>
                                                    <input type="time" name="time_end<?php echo $x; ?>" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_time_end[$xx]; ?>">
                                                    <div class="invalid-feedback"> กรุณากรอก เวลายุติการสอบ </div>
                                                </div>
                                            </div>




                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                    <?php
                                                    $time_a= $edit_time_start[$xx];
                                                    $time_b= $edit_time_end[$xx];
                                                    $time_number = diff2time($time_a,$time_b);
                                                    ?>
                                                    <label for="time_end" class="form-label"> <B><?php // echo diff2time($edit_time_start,$edit_time_end);
                                                                                                    ?></B></label>
                                                    <input type="number" name="time_number" class="form-control rounded-pill" step="0.01" value="<?php echo $time_number; ?>" disabled>
                                                </div>
                                            </div>


                                        <?php } ?>





                                    <?php   } else {  ?>



                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="last_date" class="form-label">วันที่</label>
                                                <input type="date" name="last_date" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_last_date; ?>" required>
                                                <div class="invalid-feedback"> กรุณากรอก วันที่ประเมินการสอบ </div>
                                            </div>
                                        </div>




                                        <?php if ($type_work_id == 4) { ?>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_start" class="form-label">เวลาเริ่มสอบ </label>
                                                    <input type="time" name="time_start" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_time_start; ?>" required>
                                                    <div class="invalid-feedback"> กรุณากรอก เวลาเริ่มสอบ </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_end" class="form-label">เวลายุติการสอบ</label>
                                                    <input type="time" name="time_end" class="form-control rounded-pill" placeholder="วันที่ประเมินการสอบ" value="<?php echo $edit_time_end; ?>" required>
                                                    <div class="invalid-feedback"> กรุณากรอก เวลายุติการสอบ </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="time_end" class="form-label"> <B><?php echo diff2time($edit_time_start, $edit_time_end); ?></B></label>
                                                    <input type="number" name="time_number" class="form-control rounded-pill" step="0.01" value="<?php echo diff2time_short($edit_time_start, $edit_time_end); ?>" disabled>
                                                </div>
                                            </div>
                                        <?php } else { ?>




                                            <input name="time_start" type="hidden" value="<?php echo date('H:i:s'); ?>" />



                                        <?php } ?>



                                    <?php } ?>


                                </div>




                                <input name="edit_id" type="hidden" value="<?php echo $edit_id; ?>" />
                                <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                                <input name="arrange_id" type="hidden" value="<?php echo $arrange_id; ?>" />
                                <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
                                <input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />
                                <input name="teacher_id" type="hidden" value="<?php echo $teacher_id; ?>" />
                                <input name="tbl" type="hidden" value="<?php echo $tbl; ?>" />
                                <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />

                                <HR>

                                <?php
                                if (in_array('W', $array_form_main_detail_step)) {
                                    $w = 1;
                                } else {
                                    $w = 0;
                                }
                                if (in_array('F', $array_form_main_detail_step)) {
                                    $f = 1;
                                } else {
                                    $f = 0;
                                }
                                $col = 4 + $w + $f;
                                $form_detail_array = array();
                                ?>

                                <div style="overflow-x:auto;">

                                    <table id="DataTable22" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>

                                                <th width="5%">ลำดับ</th>
                                                <th width="30%">ขั้นตอนการประเมิน</th>

                                                <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                ?>
                                                    <th width="10%">น้ำหนัก</th>
                                                <?php } ?>

                                                <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                ?>
                                                    <th width="10%">คะแนนเต็ม</th>
                                                <?php } ?>
                                                <th width="20%">คะแนน</th>
                                                <th width="5%">Sum</th>
                                            </tr>
                                        </thead>


                                        <?php if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน   
                                        ?>

                                            <tbody>
                                                <?PHP
                                                $form_group_array = array();
                                                $total = 0;
                                                $sql_group = " SELECT * FROM tbl_form_group as fg ";
                                                $sql_group .= " WHERE fg.form_main_id = '$form_main_id' ";
                                                $sql_group .= " ORDER BY fg.form_group_order ASC ";
                                                $query_group = $conn->query($sql_group);

                                                while ($result_group = $query_group->fetch_assoc()) {


                                                    $form_group_id      = $result_group['form_group_id'];
                                                    $form_main_id       = $result_group['form_main_id'];
                                                    $form_group_order   = $result_group['form_group_order'];
                                                    $form_group_name    = $result_group['form_group_name'];

                                                    $form_group_array[] = array(
                                                        'form_group_id' => $result_group['form_group_id'],
                                                        'form_main_id' => $result_group['form_main_id'],
                                                        'form_group_order' => $result_group['form_group_order'],
                                                        'form_group_name' => $result_group['form_group_name']
                                                    );

                                                ?>

                                                    <tr>
                                                        <th colspan="<?php echo $col; ?>">
                                                            <?php echo  $form_group_order; ?>. <?php echo $form_group_name; ?>
                                                        </th>
                                                    </tr>

                                                    <?PHP

                                                    //$sum_grade = 0;
                                                    $sql_detail = " SELECT * FROM tbl_form_detail as fd ";
                                                    $sql_detail .= " WHERE form_main_id = '$form_main_id' and  form_group_id = $form_group_id";
                                                    $sql_detail .= " ORDER BY fd.form_detail_order ASC ";
                                                    $query_detail = $conn->query($sql_detail);
                                                    $i = 0;
                                                    while ($result_detail = $query_detail->fetch_assoc()) {
                                                        $i++;
                                                        $form_detail_id          = $result_detail['form_detail_id'];
                                                        $form_detail_order       = $result_detail['form_detail_order'];
                                                        $form_main_id            = $result_detail['form_main_id'];
                                                        $form_detail_name        = $result_detail['form_detail_name'];
                                                        $form_detail_weight      = $result_detail['form_detail_weight'];
                                                        $form_detail_score       = $result_detail['form_detail_score'];
                                                        $form_detail_score_full  = $result_detail['form_detail_score_full'];
                                                        $form_detail_field       = $result_detail['form_detail_field'];


                                                        $form_detail_array[] = array(

                                                            'form_group_id' => $result_group['form_group_id'],
                                                            'form_main_id' => $result_group['form_main_id'],
                                                            'form_group_order' => $result_group['form_group_order'],
                                                            'form_group_name' => $result_group['form_group_name'],
                                                            'form_detail_id' => $result_detail['form_detail_id'],
                                                            'form_detail_order' => $result_detail['form_detail_order'],
                                                            'form_detail_name' => $result_detail['form_detail_name'],
                                                            'form_detail_weight' => $result_detail['form_detail_weight'],
                                                            'form_detail_score' => $result_detail['form_detail_score'],
                                                            'form_detail_score_full' => $result_detail['form_detail_score_full'],
                                                            'field_name' => $result_detail['form_detail_field']

                                                        );

                                                        $field_name     = $result_detail['form_detail_field'];
                                                        $form_detail_id = $result_detail['form_detail_id'];

                                                    ?>

                                                        <tr>
                                                            <th scope="row">
                                                                <?php echo  $form_group_order; ?>.<?php echo $form_detail_order; ?>
                                                            </th>

                                                            <td><?php echo $form_detail_name; ?> </td>

                                                            <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                            ?>
                                                                <td><?php echo $form_detail_weight; ?> </td>
                                                            <?php } ?>

                                                            <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                            ?>
                                                                <td><?php echo $form_detail_score_full; ?> </td>
                                                            <?php } ?>
                                                            <td>


                                                                <?php
                                                                if (isset($result_check_["{$field_name}_grade"])) {
                                                                    $grade =  $result_check_["{$field_name}_grade"];
                                                                ?>

                                                                    <select name="<?php echo $field_name; ?>_grade" id="<?php echo $field_name; ?>_grade" class="form-select rounded-pill">
                                                                        <option value=""> เลือก คะแนน </option>
                                                                        <?php
                                                                        $step1 = explode(",", $form_detail_score); // แยก   
                                                                        $step2 = count($step1);
                                                                        for ($ct = 0; $ct <= $step2; $ct++) {
                                                                            $step = $step1[$ct];
                                                                            if ($step != "") {
                                                                        ?>
                                                                                <option value="<?php echo $step; ?>" <?php if (!(strcmp($step, $grade))) {
                                                                                                                            echo "selected=\"selected\"";
                                                                                                                        } ?>><?php echo $step; ?></option>
                                                                        <?php
                                                                            } //if
                                                                        } //for
                                                                        ?>
                                                                    </select>

                                                                    <input name="<?php echo $field_name; ?>_grade_s" type="hidden" value="<?php echo $grade; ?>" />



                                                                <?php } else { ?>


                                                                    <select name="<?php echo $field_name; ?>_grade" id="<?php echo $field_name; ?>_grade" class="form-select rounded-pill">
                                                                        <option value=""> เลือก คะแนน </option>
                                                                        <?php
                                                                        $step1 = explode(",", $form_detail_score); // แยก   
                                                                        $step2 = count($step1);
                                                                        for ($ct = 0; $ct <= $step2; $ct++) {
                                                                            $step = $step1[$ct];
                                                                            if ($step != "") {
                                                                        ?>
                                                                                <option value="<?php echo $step; ?>"><?php echo $step; ?></option>
                                                                        <?php
                                                                            } //if
                                                                        } //for
                                                                        ?>
                                                                    </select>

                                                                <?php } ?>
                                                                <div class="invalid-feedback"> กรุณากรอก <?php echo $form_detail_name; ?></div>
                                                            </td>



                                                            <td>
                                                                <?php
                                                                if (in_array('W', $array_form_main_detail_step)) {

                                                                    if (!empty($grade)) {
                                                                        $sum_grade = $grade * $form_detail_weight;
                                                                        echo $sum_grade;
                                                                    } else {
                                                                        $sum_grade = 0;
                                                                    }
                                                                }
                                                                ?>
                                                            </td>


                                                        </tr>

                                                    <?php
                                                        if (in_array('W', $array_form_main_detail_step)) {
                                                            $total  = $total + $sum_grade;
                                                        }
                                                    }   ?>


                                                <?php
                                                }
                                                ?>



                                                <?php
                                                if (in_array('W', $array_form_main_detail_step)) {
                                                ?>


                                                    <tr>
                                                        <th colspan="<?php echo $col - 2; ?>"> </th>
                                                        <th>
                                                            <h3 Align=right> ผลรวมคะแนน </h3>
                                                        </th>
                                                        <th>
                                                            <h3><B><?php echo $total; ?><B></h3>
                                                        </th>
                                                    </tr>


                                                <?php
                                                }
                                                ?>


                                            </tbody>





                                        <?php } else { ?>








                                            <tbody>
                                                <?PHP

                                                $sql_detail = " SELECT * FROM tbl_form_detail as fd ";
                                                $sql_detail .= " WHERE fd.form_main_id = '$form_main_id' ";
                                                $sql_detail .= " ORDER BY fd.form_main_id ASC ";
                                                $query_detail = $conn->query($sql_detail);
                                                $i = 0;
                                                while ($result_detail = $query_detail->fetch_assoc()) {
                                                    $i++;
                                                    $form_detail_id          = $result_detail['form_detail_id'];
                                                    $form_detail_order       = $result_detail['form_detail_order'];
                                                    $form_main_id            = $result_detail['form_main_id'];
                                                    $form_detail_name        = $result_detail['form_detail_name'];
                                                    $form_detail_weight      = $result_detail['form_detail_weight'];
                                                    $form_detail_score       = $result_detail['form_detail_score'];
                                                    $form_detail_score_full  = $result_detail['form_detail_score_full'];
                                                    $form_detail_field       = $result_detail['form_detail_field'];


                                                    $form_detail_array[] = array(


                                                        'form_detail_id' => $result_detail['form_detail_id'],
                                                        'form_detail_order' => $result_detail['form_detail_order'],
                                                        'form_detail_name' => $result_detail['form_detail_name'],
                                                        'form_detail_weight' => $result_detail['form_detail_weight'],
                                                        'form_detail_score' => $result_detail['form_detail_score'],
                                                        'form_detail_score_full' => $result_detail['form_detail_score_full'],
                                                        'field_name' => $result_detail['form_detail_field']

                                                    );

                                                    $field_name     = $result_detail['form_detail_field'];
                                                    $form_detail_id = $result_detail['form_detail_id'];
                                                ?>



                                                    <tr>

                                                        <td><?php echo $form_detail_order; ?> </td>
                                                        <td><?php echo $form_detail_name; ?> </td>

                                                        <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                        ?>
                                                            <td><?php echo $form_detail_weight; ?> </td>
                                                        <?php } ?>

                                                        <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                                                        ?>
                                                            <td><?php echo $form_detail_score_full; ?> </td>
                                                        <?php } ?>


                                                        <td>

                                                            <?php
                                                            if (isset($result_check_["{$field_name}_grade"])) {
                                                                $grade =  $result_check_["{$field_name}_grade"];
                                                            ?>

                                                                <select name="<?php echo $field_name; ?>_grade" id="<?php echo $field_name; ?>_grade" class="form-select rounded-pill">
                                                                    <option value=""> เลือก คะแนน </option>
                                                                    <?php
                                                                    $step1 = explode(",", $form_detail_score); // แยก   
                                                                    $step2 = count($step1);
                                                                    for ($ct = 0; $ct <= $step2; $ct++) {
                                                                        $step = $step1[$ct];
                                                                        if ($step != "") {
                                                                    ?>
                                                                            <option value="<?php echo $step; ?>" <?php if (!(strcmp($step, $grade))) {
                                                                                                                        echo "selected=\"selected\"";
                                                                                                                    } ?>><?php echo $step; ?></option>
                                                                    <?php
                                                                        } //if
                                                                    } //for
                                                                    ?>
                                                                </select>

                                                                <input name="<?php echo $field_name; ?>_grade_s" type="hidden" value="<?php echo $grade; ?>" />



                                                            <?php } else { ?>


                                                                <select name="<?php echo $field_name; ?>_grade" id="<?php echo $field_name; ?>_grade" class="form-select rounded-pill">
                                                                    <option value=""> เลือก คะแนน </option>
                                                                    <?php
                                                                    $step1 = explode(",", $form_detail_score); // แยก   
                                                                    $step2 = count($step1);
                                                                    for ($ct = 0; $ct <= $step2; $ct++) {
                                                                        $step = $step1[$ct];
                                                                        if ($step != "") {
                                                                    ?>
                                                                            <option value="<?php echo $step; ?>"><?php echo $step; ?></option>
                                                                    <?php
                                                                        } //if
                                                                    } //for
                                                                    ?>
                                                                </select>

                                                            <?php } ?>
                                                            <div class="invalid-feedback"> กรุณากรอก <?php echo $form_detail_name; ?></div>

                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (in_array('W', $array_form_main_detail_step)) {

                                                                if (!empty($grade)) {
                                                                    $sum_grade = $grade * $form_detail_weight;
                                                                    echo $sum_grade;
                                                                } else {
                                                                    $sum_grade = 0;
                                                                }
                                                            }
                                                            ?>
                                                        </td>



                                                    </tr>


                                                <?php
                                                    if (in_array('W', $array_form_main_detail_step)) {
                                                        $total  = $total + $sum_grade;
                                                    }
                                                }   ?>



                                                <?php
                                                if (in_array('W', $array_form_main_detail_step)) {
                                                ?>


                                                    <tr>
                                                        <th colspan="<?php echo $col - 2; ?>"> </th>
                                                        <th>
                                                            <h3 Align=right> ผลรวมคะแนน </h3>
                                                        </th>
                                                        <th>
                                                            <h3><B><?php echo $total; ?><B></h3>
                                                        </th>
                                                    </tr>


                                                <?php
                                                }
                                                ?>



                                            </tbody>

                                        <?php } ?>





                                    </table>

                                </div>






                                <?php

                                $sql_check_complete = "SELECT * FROM tbl_detail where detail_id = $detail_id and detail_complete = 1";
                                $query_check_complete = $conn->query($sql_check_complete);
                                if ($row_check_complete = $query_check_complete->fetch_assoc()) {
                                    $detail_complete = $row_check_complete['detail_complete'];
                                } else {
                                    $detail_complete = 0;
                                }
                                ?>


                                <center>
                                    <h3>
                                        <input name="detail_complete" class="form-check-input" type="radio" value="1" id="invalidCheck1" <?php if ($detail_complete == '1') {
                                                                                                                                                echo "checked ";
                                                                                                                                            } else {
                                                                                                                                            } ?> required>
                                        <label class="form-check-label" for="invalidCheck1"> ผ่าน </label>
                                        &nbsp;&nbsp;
                                        <input name="detail_complete" class="form-check-input" type="radio" value="0" id="invalidCheck2" <?php if ($detail_complete == '0') {
                                                                                                                                                echo "checked ";
                                                                                                                                            } else {
                                                                                                                                            } ?> required>
                                        <label class="form-check-label" for="invalidCheck2"> ไม่ผ่าน</label>
                                    </h3>
                                </center>






                                <?php if ($type_work_id == 4) { ?>
                                    <br>
                                    <?php include "form_evaluate_ck.php"; ?>
                                    <br>
                                <?php } ?>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="comment" class="form-label">Comment</label>
                                        <textarea name="comment" id="comment" class="tinymce-editor"><?php echo $edit_comment; ?></textarea>
                                        <div class="invalid-feedback"> กรุณากรอก หัวข้อการประเมิน</div>
                                        <!-- End Quill Editor Default -->
                                    </div>
                                </div>



                            </div>






                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="submit_insert_form" type="submit" value="submit_insert_form" class="btn btn-primary">Submit</button>
                            </div>




                    </form>
                </div>
            </div>

            <?PHP $conn->close(); ?>

        <?php } ?>


    </div><!-- End Card -->




    <?php

    if (isset($_POST['submit_insert_form'])) {
        //include "insert_evaluate.php";
        include "insert_form_test.php";
    }

    ?>


    </div>
</section>









<?php include "footer.php"; ?>s