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


$tbl = $result['form_main_table'];


$sql_form_detail_rows = "SELECT * FROM tbl_form_detail where  form_main_id = $form_main_id ";
$query_form_detail_rows = $conn->query($sql_form_detail_rows);
$row_form_detail_rows = $query_form_detail_rows->fetch_assoc();
$row_cnt = $query_form_detail_rows->num_rows;
$numstep = $row_cnt + 1;


$form_detail_field_rows = "step" . $numstep;

$conn->close();
?>





<div class="pagetitle">
    <h1>ตัวอย่างใบประเมินการสอบ <?php echo $form_main_name; ?> (<?php echo $result['type_work_name']; ?>)</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">ใบประเมินการสอบ</li>
        </ol>


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

        <div class="row justify-content-md-center">
            <div class="col-xxl-10 col-md-12">
                <form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">



                <input name="tbl" type="hidden" value="<?php echo $tbl; ?>" />
              


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Datatables ข้อมูล ใบประเมินการสอบ </h5>
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

                                                        <div class="invalid-feedback"> กรุณากรอก <?php echo $form_detail_name; ?></div>

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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button name="submit_insert_form" type="submit" value="submit_insert_form" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div> 
        </div>   




        <?php 
        
        if (isset($_POST['submit_insert_form']))
         { 
            include "insert_form.php";
         }   

        ?>

    </div>
</section>




        <?php include "footer.php"; ?>