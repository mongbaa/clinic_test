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

$arrange_id_s = (!empty($_GET['arrange_id_s'])) ?  $_GET['arrange_id_s'] : 0;

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




        <?php if (!empty($arrange_id_s)) { ?>


            <?PHP
            include "config.inc.php";
            $sql = " SELECT * FROM db_clinic_test.tbl_arrange as a ";
            $sql .= " INNER JOIN db_clinic_test.tbl_detail    as d on a.detail_id     = d.detail_id ";
            $sql .= " INNER JOIN db_clinic_test.tbl_form_main as f on d.form_main_id  = f.form_main_id ";
            $sql .= " INNER JOIN db_clinic.tbl_teacher as t on a.teacher_id  = t.teacher_id ";
            $sql .= " INNER JOIN db_clinic.tbl_student as s on d.student_id  = s.student_id ";
            $sql .= " where  a.arrange_id = $arrange_id_s ";
            $sql .= " ORDER BY a.arrange_id DESC ";
            $query = $conn->query($sql);
            $result = $query->fetch_assoc();

            $detail_id = $result['detail_id'];
            $arrange_id = $result['arrange_id'];
            $teacher_id = $result['teacher_id'];
            $student_id = $result['student_id'];
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
            $sql_check_ .= " WHERE  detail_id = $detail_id and arrange_id = $arrange_id_s";
            $query_check_ = $conn->query($sql_check_);
            if ($result_check_ = $query_check_->fetch_assoc()) {
                $edit_id = $result_check_["{$tbl}_id"];
                $edit_comment = $result_check_['comment'];
                $edit_last_date = $result_check_['last_date'];
                $edit_time_start = $result_check_['time_start'];
                $edit_time_end = $result_check_['time_end'];
                if (in_array('ct', $array_form_main_detail)) {
                    $edit_count = $result_check_['count'];
                }
            } else {
                $edit_id = '';
                $edit_comment = '';
                $edit_last_date = $arrange_date;
                $edit_time_start = '';
                $edit_time_end = '';
                if (in_array('ct', $array_form_main_detail)) {
                    $edit_count = 1;
                }
            }

            ?>




        <div class="d-flex justify-content-center">
            <div class="col-xxl-8 col-md-12">

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
                                        <img src="http://10.151.127.78/pic_students/<?php echo $result['student_id']; ?>.jpg" width="120" height="120" style="border-radius:50%;" class="img-circle responsive" alt="<?php echo $result['student_id']; ?>">
                                    </div>
                                </div>
                            </div>

                            <h3> ใบประเมินการปฏิบัติงาน <B><?php echo $form_main_name; ?></B> </h3>
                            <hr>


                            <div class="row">

                                <div class="col-12">
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



                                <div class="col-12">
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

                                    </div>
                                </div>
                            </div>



                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="last_date" class="form-label">วันที่ <?php echo $edit_last_date; ?></label>
                                    </div>
                                </div>

                                <?php if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง 
                                ?>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="count" class="form-label">ครั้งที่ <?php echo $edit_count; ?> </label>
                                        </div>
                                    </div>

                                <?php  } ?>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="time_start" class="form-label">เวลาเริ่มสอบ <?php echo $edit_time_start; ?></label>
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="time_end" class="form-label">เวลายุติการสอบ <?php echo $edit_time_end; ?></label>
                                    </div>
                                </div>





                            </div>






                            <input name="edit_id" type="hidden" value="<?php echo $edit_id; ?>" />
                            <input name="student_id" type="hidden" value="<?php echo $student_id; ?>" />
                            <input name="arrange_id" type="hidden" value="<?php echo $arrange_id_s; ?>" />
                            <input name="detail_id" type="hidden" value="<?php echo $detail_id; ?>" />
                            <input name="arrange_date" type="hidden" value="<?php echo $arrange_date; ?>" />
                            <input name="teacher_id" type="hidden" value="<?php echo $teacher_id; ?>" />
                            <input name="tbl" type="hidden" value="<?php echo $tbl; ?>" />
                            <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />







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
                            $col = 3 + $w + $f;
                            $form_detail_array = array();
                            ?>

                            <div style="overflow-x:auto;">

                                <table id="DataTable1" class="table table-bordered table-striped">
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
                                        </tr>
                                    </thead>




                                    <?php if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน   
                                    ?>

                                        <tbody>
                                            <?PHP
                                            $form_group_array = array();

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
                                                        'field_name' => $tbl . "_" . $result_detail['form_detail_field']

                                                    );

                                                    $field_name = $tbl . "_" . $result_detail['form_detail_field'];
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
                                                               echo $grade =  $result_check_["{$field_name}_grade"];
                                                          
                                                             } ?>
                                                        </td>


                                                    </tr>

                                                <?php }   ?>


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
                                                $form_detail_name       = $result_detail['form_detail_name'];
                                                $form_detail_weight      = $result_detail['form_detail_weight'];
                                                $form_detail_score       = $result_detail['form_detail_score'];
                                                $form_detail_score_full  = $result_detail['form_detail_score_full'];
                                                $form_detail_field       = $result_detail['form_detail_field'];

                                                $form_detail_array[] = array(
                                                    'form_group_id' => '',
                                                    'form_main_id' => $form_main_id,
                                                    'form_group_order' => '',
                                                    'form_group_name' => '',
                                                    'form_detail_id' => $result_detail['form_detail_id'],
                                                    'form_detail_order' => $result_detail['form_detail_order'],
                                                    'form_detail_name' => $result_detail['form_detail_name'],
                                                    'form_detail_weight' => $result_detail['form_detail_weight'],
                                                    'form_detail_score' => $result_detail['form_detail_score'],
                                                    'form_detail_score_full' => $result_detail['form_detail_score_full']
                                                );
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

                                                    <td><?php echo $form_detail_score; ?> </td>

                                                </tr>

                                            <?php
                                            }
                                            ?>

                                        </tbody>

                                    <?php } ?>

                                </table>

                            </div>

                            <br>
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
        include "insert_form.php";
    }

    ?>


    </div>
</section>









<?php include "footer.php"; ?>s