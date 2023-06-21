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
    echo "  imageUrl: 'https://unsplash.it/400/200',";
    echo "  imageWidth: 400,";
    echo "  imageHeight: 200,";
    echo "  imageAlt: 'Custom image',";
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
    echo "  imageUrl: 'https://unsplash.it/400/200',";
    echo "  imageWidth: 400,";
    echo "  imageHeight: 200,";
    echo "  imageAlt: 'Custom image',";
    echo "  })";
    echo " </script>";
    unset($_SESSION['error']);

}
?>



<?PHP

$form_main_id = $_GET['form_main_id'];
include "config.inc.php";
$sql = " SELECT * FROM tbl_form_main as fm ";
$sql .= " INNER JOIN  tbl_type_work AS tw  on fm.type_work_id = tw.type_work_id ";
$sql .= " WHERE md5(fm.form_main_id) = '$form_main_id' ";
$sql .= " ORDER BY fm.form_main_id ASC ";
$query = $conn->query($sql);
$result = $query->fetch_assoc();
$form_main_id = $result['form_main_id'];
$type_work_id = $result['type_work_id'];
$form_main_name = $result['form_main_name'];
$form_main_status = $result['form_main_status'];
$form_main_table = $result['form_main_table'];
$form_main_detail = $result['form_main_detail'];
$form_main_detail_step = $result['form_main_detail_step'];
$form_main_confirm = $result['form_main_confirm'];
$array_form_main_detail_step = json_decode($form_main_detail_step, true);





$sql_form_detail_rows = "SELECT * FROM tbl_form_detail where  form_main_id = $form_main_id ";
$query_form_detail_rows = $conn->query($sql_form_detail_rows);
$row_form_detail_rows = $query_form_detail_rows->fetch_assoc();
$row_cnt = $query_form_detail_rows->num_rows;
$numstep = $row_cnt + 1;


$form_detail_field_rows = "step" . $numstep;

$conn->close();
?>





<div class="pagetitle">
    <h1>ข้อมูล ใบประเมินการสอบ <?php echo $form_main_name; ?> (<?php echo $result['type_work_name']; ?>) 
    <a href="form_view.php?form_main_id=<?php echo $_GET['form_main_id']; ?>" class="btn btn-success btn-sm btn-block"> << ตัวอย่าง >> </a>
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">ใบประเมินการสอบ</li>
        </ol>

        <?php if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
        ?>

            <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_add_group">
                <i class="ri-add-circle-fill"></i> เพิ่ม แบ่งหัวข้อรายการประเมิน
            </button>

        <?php } else { ?>


            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_add_detail">
                <i class="ri-add-circle-fill"></i> เพิ่มขั้นตอนการประเมินคะแนน
            </button>


        <?php } ?>

    </nav>


</div><!-- End Page Title -->



<?php

$form_main_detail = $result['form_main_detail'];
$array_form_main_detail = json_decode($form_main_detail, true);
$map_detail = [
    "hn" => "ผู้ป่วย HN",
    "t" => "ซี่ฟัน",
    "s" => "ด้าน",
    "r" => "ราก",
    "c" => "คลาส"
];

foreach ($map_detail as $id => $name) {

    if (in_array($id, $array_form_main_detail)) {
        echo " <a href='#' class='btn btn-secondary rounded-pill btn-sm'>$name</a>";
    }
}
?>





<?php

$form_main_detail_step = $result['form_main_detail_step'];
$array_form_main_detail_step = json_decode($form_main_detail_step, true);

$map_step = [
    "G" => "แบ่งหัวข้อ",
    "W" => "น้ำหนัก",
    "F" => "คะแนนเต็ม"
];

foreach ($map_step as $id => $name) {

    if (in_array($id, $array_form_main_detail_step)) {
        echo " <a href='#' class='btn btn-secondary rounded-pill btn-sm'>$name</a>";
    }
}
?>




<?php
switch ($form_main_confirm) { // Harder page
    case 0:
        //$tools_stock_status = "<h5><span class='badge bg-success'>เปิดใช้งาน <i class='ri-checkbox-circle-line'></i>  </span></h5>";
        echo " <a href='#' class='btn btn-secondary rounded-pill btn-sm'>รอยืนยัน</a>";
        break;
    case 1:
        //$tools_stock_status = "<h5><span class='badge bg-success'>เปิดใช้งาน <i class='ri-checkbox-circle-line'></i>  </span></h5>";
        echo " <a href='#' class='btn btn-success rounded-pill btn-sm'>ยืนยันแล้ว</a>";
        break;
    case 2:
        //$tools_stock_status =  "<h5><span class='badge bg-danger'>ปิดใช้งาน <i class='ri-close-circle-line'></i> </span></h5>";
        echo " <a href='#' class='btn btn-danger rounded-pill btn-sm'> ไม่ยืนยัน </a>";
        break;
    default:
        echo  "";
}
?>



<?php
switch ($form_main_status) { // Harder page
    case 1:
        //$tools_stock_status = "<h5><span class='badge bg-success'>เปิดใช้งาน <i class='ri-checkbox-circle-line'></i>  </span></h5>";
        echo " <a href='#' class='btn btn-success rounded-pill btn-sm'>เปิดใช้งาน</a>";
        break;
    case 2:
        //$tools_stock_status =  "<h5><span class='badge bg-danger'>ปิดใช้งาน <i class='ri-close-circle-line'></i> </span></h5>";
        echo " <a href='#' class='btn btn-danger rounded-pill btn-sm'> ปิดใช้งาน </a>";
        break;
    default:
        echo  "";
}
?>



<a href='#' class='btn btn-info rounded-pill btn-sm'><?php echo $result['form_main_table']; ?> </a>



<P></P>







<form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
    <div class="modal fade" id="modal_add_group" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class=" ri-add-circle-fill"></i> เพิ่ม แบ่งหัวข้อรายการประเมิน </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="form_group_order" class="form-label">ลำดับ</label>
                            <input type="number" name="form_group_order" class="form-control rounded-pill" placeholder="ลำดับ" value="" required>
                            <div class="invalid-feedback"> กรุณากรอก ลำดับ </div>
                        </div>
                    </div>

                    <br>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="form_group_name" class="form-label">ชื่อหมวด / กลุ่ม </label>
                            <input type="text" name="form_group_name" class="form-control rounded-pill" placeholder="ชื่อหมวด / กลุ่ม" value="" required>
                            <div class="invalid-feedback"> กรุณากรอก ชื่อหมวด / กลุ่ม </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="submit_group" type="submit" value="submit_group" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </div>
    </div><!-- End Vertically centered Modal-->
</form><!-- End General Form Elements -->








<form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
    <div class="modal fade" id="modal_add_detail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <i class='ri-edit-line'></i> รายการประเมิน </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                <input name="form_group_id" type="hidden" value="<?php echo $form_group_id; ?>" />
                                    <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_order" class="form-label">ลำดับ</label>
                                            <input type="number" name="form_detail_order" class="form-control rounded-pill" placeholder="ลำดับ" value="" required>
                                            <div class="invalid-feedback"> กรุณากรอก ลำดับ </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_name" class="form-label">หัวข้อการประเมิน</label>
                                            <textarea name="form_detail_name" id="form_detail_name<?php echo $form_group_id; ?>" class="tinymce-editor" rows="" style="max-height: 100px;"></textarea>
                                            <div class="invalid-feedback"> กรุณากรอก หัวข้อการประเมิน</div>
                                            <!-- End Quill Editor Default -->
                                        </div>
                                    </div>
                                    <br>


                                    <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="form_detail_weight" class="form-label">น้ำหนัก</label>
                                                <input type="number" name="form_detail_weight" step="0.01" class="form-control rounded-pill" placeholder="น้ำหนัก" value="" required>
                                                <div class="invalid-feedback"> กรุณากรอก น้ำหนัก</div>
                                            </div>
                                        </div>
                                        <br>
                                    <?php } ?>




                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_score" class="form-label">คะแนน</label>
                                            <input type="text" name="form_detail_score" class="form-control rounded-pill" placeholder="คะแนน" value="" required>
                                            <div class="invalid-feedback"> กรุณากรอก คะแนน</div>
                                        </div>
                                    </div>
                                    <br>


                                    <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="form_detail_score_full" class="form-label">คะแนนเต็ม</label>
                                                <input type="text" name="form_detail_score_full" class="form-control rounded-pill" placeholder="คะแนนเต็ม" value="" required>
                                                <div class="invalid-feedback"> กรุณากรอก คะแนนเต็ม</div>
                                            </div>
                                        </div>
                                        <br>
                                    <?php } ?>


                                    <br>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_field" class="form-label">field</label>
                                            <input type="text" name="form_detail_field" class="form-control rounded-pill" placeholder="field" value="" required>
                                            <div class="invalid-feedback"> กรุณากรอก field</div>
                                        </div>
                                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="submit_detail" type="submit" value="submit_detail" class="btn btn-primary">Submit</button>
                </div>

            </div>
        </div>
    </div><!-- End Vertically centered Modal-->
</form><!-- End General Form Elements -->



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




<section class="section dashboard">

    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Datatables ข้อมูล ใบประเมินการสอบ </h5>

                <!-- Table with stripped rows -->

                <table id="DataTable1" class="table table-bordered table-striped">
                    <thead>
                        <tr>

                            <th width="2">ลำดับ</th>
                            <th width="15">ขั้นตอนการประเมิน</th>

                            <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                            ?>
                                <th width="5">น้ำหนัก</th>
                            <?php } ?>

                            <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
                            ?>
                                <th width="5">คะแนนเต็ม</th>
                            <?php } ?>


                            <th width="5">คะแนน</th>
                            <th width="10">จัดการข้อมูล</th>
                        </tr>
                    </thead>




                    <?php if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน   
                    ?>

                        <tbody>
                            <?PHP
                            $form_group_array = array();
                            include "config.inc.php";
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



                                        <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_edit_group<?php echo $form_group_id; ?>">
                                            <i class='ri-edit-line'></i> จัดการข้อมูล
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_del_group<?php echo $form_group_id; ?>">
                                            <i class="bx bxs-trash"></i> ยกเลิก
                                        </button>


                                    </th>
                                    <td>

                                    <?php if($form_main_confirm!=1){?>

                                        <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_add_detail<?php echo $form_group_id; ?>">
                                            <i class="ri-add-circle-fill"></i> เพิ่มขั้นตอนการประเมินคะแนน
                                        </button>

                                    <?php } ?>

                                    </td>
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
                                        'form_detail_score_full' => $result_detail['form_detail_score_full']


                                    );

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

                                           



                                            <select name="form_main_status" id="form_main_status" class="form-select rounded-pill" style="border-color: pink; background-color: pink  !important;" required>
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




                                            <?php echo $form_detail_field; ?>




                                        </td>






                                        <td>

                                            <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_edit_detail<?php echo $form_detail_id; ?>">
                                                <i class='ri-edit-line'></i> จัดการข้อมูล
                                            </button>


                                            <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_del_detail<?php echo $form_detail_id; ?>">
                                                <i class="bx bxs-trash"></i> ยกเลิก
                                            </button>
                                        </td>
                                    </tr>

                                <?php }   ?>






                            <?php
                            }
                            $conn->close();
                            ?>
                        </tbody>








                    <?php } else { ?>





                        <tbody>
                            <?PHP
                            include "config.inc.php";
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
                                    <td>

                                        <button type="button" class="btn btn-warning btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_edit_detail<?php echo $form_detail_id; ?>">
                                            <i class='ri-edit-line'></i> จัดการข้อมูล
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#modal_del_detail<?php echo $form_detail_id; ?>">
                                            <i class="bx bxs-trash"></i> ยกเลิก
                                        </button>

                                    </td>
                                </tr>

                            <?php
                            }
                            $conn->close();
                            ?>

                        </tbody>




                    <?php } ?>










                </table>
                <!-- End Table with stripped rows -->

            </div>
        </div>


















        <!-- แก้ไข Group  -->

        <?php

        if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 


            foreach ($form_group_array as $values => $data) {

                $form_group_id = $data['form_group_id'];
                $form_main_id = $data['form_main_id'];
                $form_group_order = $data['form_group_order'];
                $form_group_name = $data['form_group_name'];
        ?>


                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="modal fade" id="modal_edit_group<?php echo $form_group_id; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"> <i class='ri-edit-line'></i> แก้ไข แบ่งหัวข้อรายการประเมิน <?php echo $form_group_id; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input name="form_group_id" type="hidden" value="<?php echo $form_group_id; ?>" />
                                    <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_group_order" class="form-label">ลำดับ</label>
                                            <input type="number" name="form_group_order" class="form-control rounded-pill" placeholder="ลำดับ" value="<?php echo $form_group_order; ?>" required>
                                            <div class="invalid-feedback"> กรุณากรอก ลำดับ </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_group_name" class="form-label">ชื่อหมวด / กลุ่ม </label>
                                            <input type="text" name="form_group_name" class="form-control rounded-pill" placeholder="ชื่อหมวด / กลุ่ม" value="<?php echo $form_group_name; ?>" required>
                                            <div class="invalid-feedback"> กรุณากรอก ชื่อหมวด / กลุ่ม </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button name="submit_group" type="submit" value="submit_group" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Vertically centered Modal-->
                </form><!-- End General Form Elements -->







                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="modal fade" id="modal_add_detail<?php echo $form_group_id; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"> <i class='ri-edit-line'></i> เพิ่ม แบ่งหัวข้อรายการประเมิน <?php echo $form_group_id; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <input name="form_group_id" type="hidden" value="<?php echo $form_group_id; ?>" />
                                    <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />


                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_order" class="form-label">ลำดับ</label>
                                            <input type="number" name="form_detail_order" class="form-control rounded-pill" placeholder="ลำดับ" value="" required>
                                            <div class="invalid-feedback"> กรุณากรอก ลำดับ </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_name" class="form-label">หัวข้อการประเมิน</label>
                                            <textarea name="form_detail_name" id="form_detail_name<?php echo $form_group_id; ?>" class="tinymce-editor" rows="" style="max-height: 100px;"></textarea>
                                            <div class="invalid-feedback"> กรุณากรอก หัวข้อการประเมิน</div>
                                            <!-- End Quill Editor Default -->
                                        </div>
                                    </div>
                                    <br>


                                    <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="form_detail_weight" class="form-label">น้ำหนัก</label>
                                                <input type="number" name="form_detail_weight" step="0.01" class="form-control rounded-pill" placeholder="น้ำหนัก" value="" required>
                                                <div class="invalid-feedback"> กรุณากรอก น้ำหนัก</div>
                                            </div>
                                        </div>
                                        <br>
                                    <?php } ?>




                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_score" class="form-label">คะแนน</label>
                                            <input type="text" name="form_detail_score" class="form-control rounded-pill" placeholder="คะแนน" value="" required>
                                            <div class="invalid-feedback"> กรุณากรอก คะแนน</div>
                                        </div>
                                    </div>
                                    <br>


                                    <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                    ?>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="form_detail_score_full" class="form-label">คะแนนเต็ม</label>
                                                <input type="text" name="form_detail_score_full" class="form-control rounded-pill" placeholder="คะแนนเต็ม" value="" required>
                                                <div class="invalid-feedback"> กรุณากรอก คะแนนเต็ม</div>
                                            </div>
                                        </div>
                                        <br>
                                    <?php } ?>


                                    <br>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_field" class="form-label">field</label>
                                            <input type="text" name="form_detail_field" class="form-control rounded-pill" placeholder="field" value="<?php echo $form_detail_field_rows; ?>" required>
                                            <div class="invalid-feedback"> กรุณากรอก field</div>
                                        </div>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button name="submit_detail" type="submit" value="submit_detail" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Vertically centered Modal-->
                </form><!-- End General Form Elements -->








                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                    <div class="modal fade" id="modal_del_group<?php echo $form_group_id; ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="bx bxs-trash"></i> ยืนยันการลบ <?php echo $form_group_name; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">


                                    <input name="form_group_id" type="hidden" value="<?php echo $form_group_id; ?>" />
                                    <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />

                                    ยืนยันการลบอีกครั้ง
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button name="submit_group_del" type="submit" value="submit_group_del" class="btn btn-danger"> <i class="bx bxs-trash"></i> ยืนยันการลบอีกครั้ง</button>
                                </div>

                            </div>
                        </div>
                    </div><!-- End Vertically centered Modal-->
                </form><!-- End General Form Elements -->



        <?php }
        } ?>
















        <?php

        foreach ($form_detail_array as $values => $data) {

            $form_group_name = $data['form_group_name'];
            $form_detail_id = $data['form_detail_id'];
            $form_detail_order = $data['form_detail_order'];
            $form_detail_name = $data['form_detail_name'];
            $form_detail_weight = $data['form_detail_weight'];
            $form_detail_score = $data['form_detail_score'];
            $form_detail_score_full = $data['form_detail_score_full'];

            $form_main_id = $data['form_main_id'];


        ?>



            <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                <div class="modal fade" id="modal_edit_detail<?php echo $form_detail_id; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"> <i class='ri-edit-line'></i> แก้ไข <?php echo $form_detail_id; ?> <?php echo $form_group_name; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">


                                <input name="form_detail_id" type="hidden" value="<?php echo $form_detail_id; ?>" />
                                <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="form_detail_order" class="form-label">ลำดับ</label>
                                        <input type="number" name="form_detail_order" class="form-control rounded-pill" placeholder="ลำดับ" value="<?php echo $form_detail_order; ?>" required>
                                        <div class="invalid-feedback"> กรุณากรอก ลำดับ </div>
                                    </div>
                                </div>
                                <br>



                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="form_detail_name" class="form-label">หัวข้อการประเมิน</label>
                                        <textarea name="form_detail_name" id="form_detail_name<?php echo $form_group_id; ?>" class="tinymce-editor"><?php echo $form_detail_name; ?></textarea>
                                        <div class="invalid-feedback"> กรุณากรอก หัวข้อการประเมิน</div>
                                        <!-- End Quill Editor Default -->
                                    </div>
                                </div>
                                <br>





                                <?php if (in_array('W', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_weight" class="form-label">น้ำหนัก</label>
                                            <input type="number" name="form_detail_weight" step="0.01" class="form-control rounded-pill" placeholder="น้ำหนัก" value="<?php echo $form_detail_weight; ?>" required>
                                            <div class="invalid-feedback"> กรุณากรอก น้ำหนัก</div>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="form_detail_score" class="form-label">คะแนน</label>
                                        <input type="text" name="form_detail_score" class="form-control rounded-pill" placeholder="คะแนน" value="<?php echo $form_detail_score; ?>" required>
                                        <div class="invalid-feedback"> กรุณากรอก คะแนน</div>
                                    </div>
                                </div>
                                <br>



                                <?php if (in_array('F', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน  
                                ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="form_detail_score_full" class="form-label">คะแนนเต็ม</label>
                                            <input type="text" name="form_detail_score_full" class="form-control rounded-pill" placeholder="คะแนนเต็ม" value="<?php echo $form_detail_score_full; ?>" required>
                                            <div class="invalid-feedback"> กรุณากรอก คะแนนเต็ม</div>
                                        </div>
                                    </div>
                                    <br>
                                <?php } ?>



                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="form_detail_field" class="form-label">field</label>
                                        <input type="text" name="form_detail_field" class="form-control rounded-pill" placeholder="field" value="<?php echo $form_detail_field_rows; ?>" disabled>
                                        <div class="invalid-feedback"> กรุณากรอก field</div>
                                    </div>
                                </div>



                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="submit_detail" type="submit" value="submit_detail" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </div>
                </div><!-- End Vertically centered Modal-->
            </form><!-- End General Form Elements -->




 



            <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                <div class="modal fade" id="modal_del_detail<?php echo $form_detail_id; ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bx bxs-trash"></i> ยืนยันการลบ <?php echo $form_detail_name; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input name="form_detail_id" type="hidden" value="<?php echo $form_detail_id; ?>" />
                                <input name="form_main_id" type="hidden" value="<?php echo $form_main_id; ?>" />

                                ยืนยันการลบอีกครั้ง

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button name="submit_detail_del" type="submit" value="submit_detail_del" class="btn btn-danger"> <i class="bx bxs-trash"></i> ยืนยันการลบอีกครั้ง</button>
                            </div>

                        </div>
                    </div>
                </div><!-- End Vertically centered Modal-->
            </form><!-- End General Form Elements -->


        <?php
        }
        ?>





        <?php


        if (isset($_POST['submit_group_del'])) {

            include "config.inc.php";


            if (isset($_POST['form_group_id']) && !empty($_POST['form_group_id'])) {
                $form_group_id = $conn->real_escape_string($_POST['form_group_id']);
            } else {
                $form_group_id = 0;
            }


            if (isset($_POST['form_main_id']) && !empty($_POST['form_main_id'])) {
                $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
            } else {
                $form_main_id = 0;
            }


            $sql_detail = " DELETE FROM tbl_form_detail  WHERE form_group_id = '$form_group_id' ";
            $conn->query($sql_detail);


            $sql_group = " DELETE FROM tbl_form_group   WHERE form_group_id = '$form_group_id' ";
            $conn->query($sql_group);






            $_SESSION['do'] = 'ยกเลิกสำเร็จสำเร็จ';
            $conn->close();

            $form_main_id = md5($form_main_id);
            echo "<script type='text/javascript'>";
            //echo "alert('[บันทึกข้อมูสำเร็จ]');";
            echo "window.location='form_detail.php?form_main_id=$form_main_id';";
            echo "</script>";
        }






        if (isset($_POST['submit_detail_del'])) {

            include "config.inc.php";


            if (isset($_POST['form_detail_id']) && !empty($_POST['form_detail_id'])) {
                $form_detail_id = $conn->real_escape_string($_POST['form_detail_id']);
            } else {
                $form_detail_id = 0;
            }


            if (isset($_POST['form_main_id']) && !empty($_POST['form_main_id'])) {
                $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
            } else {
                $form_main_id = 0;
            }

            $sql_del = " DELETE FROM tbl_form_detail WHERE  form_detail_id = '$form_detail_id' ";
            $conn->query($sql_del);

            $_SESSION['do'] = 'ยกเลิกสำเร็จสำเร็จ';
            $conn->close();

            $form_main_id = md5($form_main_id);
            echo "<script type='text/javascript'>";
            //echo "alert('[บันทึกข้อมูสำเร็จ]');";
            echo "window.location='form_detail.php?form_main_id=$form_main_id';";
            echo "</script>";
        }








        if (isset($_POST['submit_group'])) {

            include "config.inc.php";

            if (isset($_POST['form_main_id'])  && !empty($_POST['form_main_id'])) {
                $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
            } else {
                $form_main_id = 0;
            }

            if (isset($_POST['form_group_id'])  && !empty($_POST['form_group_id'])) {
                $form_group_id = $conn->real_escape_string($_POST['form_group_id']);
            } else {
                $form_group_id = '';
            }

            if (isset($_POST['form_group_order'])  && !empty($_POST['form_group_order'])) {
                $form_group_order = $conn->real_escape_string($_POST['form_group_order']);
            } else {
                $form_group_order = '';
            }

            if (isset($_POST['form_group_name'])  && !empty($_POST['form_group_name'])) {
                $form_group_name = $conn->real_escape_string($_POST['form_group_name']);
            } else {
                $form_group_name = '';
            }




            if (!empty($form_group_id)) {


                $sql_up = " UPDATE tbl_form_group SET ";
                $sql_up .= "  form_group_order = '$form_group_order', ";
                $sql_up .= "  form_group_name = '$form_group_name' ";
                $sql_up .= " WHERE  form_group_id = '$form_group_id' ";
                $conn->query($sql_up);

                $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';
            } else {

                $sql_in = " INSERT INTO tbl_form_group (form_group_id, form_main_id, form_group_order, form_group_name ) VALUES ";
                $sql_in .= " ( NULL, '$form_main_id', '$form_group_order', '$form_group_name' ) ";
                $conn->query($sql_in);

                $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
            }


            $form_main_id = md5($form_main_id);
            echo "<script type='text/javascript'>";
            //echo "alert('[บันทึกข้อมูสำเร็จ]');";
            echo "window.location='form_detail.php?form_main_id=$form_main_id';";
            echo "</script>";
        }




        if (isset($_POST['submit_detail'])) {

            include "config.inc.php";

            if (isset($_POST['form_detail_id'])  && !empty($_POST['form_detail_id'])) {
                $form_detail_id = $conn->real_escape_string($_POST['form_detail_id']);
            } else {
                $form_detail_id = 0;
            }

            if (isset($_POST['form_main_id'])  && !empty($_POST['form_main_id'])) {
                $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
            } else {
                $form_main_id = 0;
            }

            if (isset($_POST['form_group_id'])  && !empty($_POST['form_group_id'])) {
                $form_group_id = $conn->real_escape_string($_POST['form_group_id']);
            } else {
                $form_group_id = 0;
            }


            if (isset($_POST['form_detail_order'])  && !empty($_POST['form_detail_order'])) {
                $form_detail_order = $conn->real_escape_string($_POST['form_detail_order']);
            } else {
                $form_detail_order = 0;
            }

            if (isset($_POST['form_detail_name'])  && !empty($_POST['form_detail_name'])) {
                $form_detail_name = $conn->real_escape_string($_POST['form_detail_name']);
            } else {
                $form_detail_name = '';
            }


            if (isset($_POST['form_detail_weight'])  && !empty($_POST['form_detail_weight'])) {
                $form_detail_weight = $conn->real_escape_string($_POST['form_detail_weight']);
            } else {
                $form_detail_weight = 0;
            }


            if (isset($_POST['form_detail_score'])  && !empty($_POST['form_detail_score'])) {
                $form_detail_score = $conn->real_escape_string($_POST['form_detail_score']);
            } else {
                $form_detail_score = 0;
            }


            if (isset($_POST['form_detail_score_full'])  && !empty($_POST['form_detail_score_full'])) {
                $form_detail_score_full = $conn->real_escape_string($_POST['form_detail_score_full']);
            } else {
                $form_detail_score_full = 0;
            }


            if (isset($_POST['form_detail_field'])  && !empty($_POST['form_detail_field'])) {
                $form_detail_field = $conn->real_escape_string($_POST['form_detail_field']);
            } else {
                $form_detail_field = '';
            }




            if (!empty($form_detail_id)) {

                $sql_up = " UPDATE tbl_form_detail SET ";
                $sql_up .= "  form_detail_order = '$form_detail_order', ";
                $sql_up .= "  form_detail_name = '$form_detail_name', ";
                $sql_up .= "  form_detail_weight = '$form_detail_weight', ";
                $sql_up .= "  form_detail_score = '$form_detail_score', ";
                $sql_up .= "  form_detail_score_full = '$form_detail_score_full' ";
                $sql_up .= " WHERE  form_detail_id = '$form_detail_id' ";
                $conn->query($sql_up);

                $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';
            } else {

                $sql_in =  " INSERT INTO tbl_form_detail (form_detail_id, form_detail_order, form_group_id, form_main_id, form_detail_name, form_detail_weight, form_detail_score, form_detail_score_full, form_detail_field) ";
                $sql_in .= " VALUES (NULL, '$form_detail_order', '$form_group_id', '$form_main_id', '$form_detail_name', '$form_detail_weight', '$form_detail_score', '$form_detail_score_full', '$form_detail_field') ";
                $conn->query($sql_in);

                $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
            }


            $form_main_id = md5($form_main_id);
            echo "<script type='text/javascript'>";
            //echo "alert('[บันทึกข้อมูสำเร็จ]');";
            echo "window.location='form_detail.php?form_main_id=$form_main_id';";
            echo "</script>";
        }
        ?>


    </div>
</section>





<div class="card ">
        <div class="card-header bg-danger">
          <h3 class="card-title"> SQL CREATE TABLE

            <?php if ($form_main_confirm == 1) {
              
            } else {
                
             echo   $form_main_id = md5($form_main_id);
                
           ?>
            <a href="?confirm=1&form_main_id=<?php echo $form_main_id; ?>" class="btn btn-success" onClick="return confirm('กรุณายืนยัน การสร้าง Table อีกครั้ง...!!!')"> <i class="fab fa-angellist"></i> Confirm </i> </a>
            <?php } ?>
          </h3>


        </div>
        <!-- /.card-header -->
        <div class="card-body">

        <?php



          $tbl = "tbl_" . $form_main_table; //ชื่อตาราง
          $id =  "id"; //ชื่อ ID ของตาราง
          $table = $form_main_table;

          $create  = " CREATE TABLE $tbl ( "; //ชื่อตารางเก็บข้อมูล
          $create .= " $id INT NOT NULL AUTO_INCREMENT , "; //ID
          $create .= " arrange_id INT NOT NULL , "; //รหัสส่งงาน
          $create .= " student_id  VARCHAR(20) NOT NULL , "; //รหัสนักศึกษา
          $create .= " detail_id  INT(20) NOT NULL , "; //รหัสงาน

          include "config.inc.php";
          $sql_form_detail = "SELECT * FROM tbl_form_detail where  md5(form_main_id) = '$form_main_id' ORDER BY form_detail_id ASC";
          $query_form_detail = $conn->query($sql_form_detail);
          while ($row_form_detail = $query_form_detail->fetch_assoc()) {

            $field =  $row_form_detail['form_detail_field']; //  ชื่อฟิลด์
            $create .= " $field" . "_grade VARCHAR(20) NOT NULL ,"; //คะแนนที่ได้รับ
            $create .= " $field" . "_teacher INT NOT NULL , ";  //รหัสอาจารย์ผู้ประเมิน
            $create .= " $field" . "_date DATE NOT NULL , ";  //วันที่บันทึก // เวลาที่บันทึก

          }
          $conn->close();

          $create .= "comment TEXT  NOT NULL , "; // commint

          if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง

            for ($x = 1; $x <= 4; $x++) {

            $create .= " count{$x} INT NOT NULL , "; // count
            $create .= " last_date{$x} DATE NOT NULL , time_start{$x} TIME DEFAULT NULL , time_end{$x} TIME DEFAULT NULL , "; // นับครั้ง1

            }

          }else{

            $create .= " last_date DATE NOT NULL , time_start TIME NOT NULL , time_end TIME NOT NULL , "; // วันที่ล่าสุด

          }

          


          $create .= " log TEXT NOT NULL , "; // log
          $create .= " PRIMARY KEY ($id)";
          $create .= ") ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";


         
        ?>
        <code> <?php echo $create; ?> </code>

        <?php
          if (isset($_GET['confirm'])) {
            include "config.inc.php";
            $form_main_id = $_GET['form_main_id'];

            $sql_create = "{$create}";
            $conn->query($sql_create);

            $sql_update = "UPDATE tbl_form_main SET form_main_confirm = '1' WHERE md5(form_main_id) = '$form_main_id' ";
            $conn->query($sql_update);

            $conn->close();
            $_SESSION['do'] = 'สร้างฟอร์มสำเร็จ';
           
            echo "<script type='text/javascript'>";
            echo "window.location='form_detail.php?form_main_id=$form_main_id';";
            echo "</script>";

          }
          ?>







        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->









<?php include "footer.php"; ?>


