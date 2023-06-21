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

    echo   $error = $_SESSION['error'];

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




<div class="pagetitle">
    <h1>ข้อมูล ใบประเมินการสอบ </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">ใบประเมินการสอบ</li>
        </ol>

        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#verticalycentered">
            <i class="ri-add-circle-fill"></i> เพิ่ม ใบประเมินการสอบ
        </button>
    </nav>
</div><!-- End Page Title -->




<?php


if (!empty($_GET['edit']) && !empty($_GET['check']) && ($_GET['check'] == md5($_GET['edit'] . 'edit108'))) {

    include "config.inc.php";
    $sql_edit = "SELECT * FROM tbl_form_main WHERE md5(form_main_id) = '$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();

    $form_main_id = $result_edit['form_main_id'];
    $type_work_id = $result_edit['type_work_id'];
    $form_main_name = $result_edit['form_main_name'];
    $form_main_status = $result_edit['form_main_status'];
    $form_main_table = $result_edit['form_main_table'];
    $form_main_detail = $result_edit['form_main_detail'];
    $form_main_confirm = $result_edit['form_main_confirm'];

    $conn->close();
} else {

    $form_main_id = "";
    $type_work_id = "";
    $form_main_name = "";
    $form_main_status = "";
    $form_main_table = "";
    $form_main_detail = "";
    $form_main_confirm = "";
}




if (isset($_POST['submit_del'])) {

    $form_main_id  = $_POST['form_main_id'];
    $user_id_clinic_test = $_SESSION["user_id_clinic_test"];
    $ipp = $_SERVER['REMOTE_ADDR'];
    $form_main_log  = ",DE|" . date('Y-m-d H:s:i') . "|$user_id_clinic_test|" . $ipp . "/";

    include "config.inc.php";
    $sql_del = "DELETE FROM tbl_form_main WHERE form_main_id = $form_main_id  ";
    $conn->query($sql_del);
    $conn->close();

    $_SESSION['do'] = 'ลบข้อมูลสำเร็จ';

    echo "<script type='text/javascript'>";
    // echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='form_main.php';";
    echo "</script>";
}


?>





<form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
    <div class="modal fade" id="verticalycentered" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class=" ri-add-circle-fill"></i> เพิ่ม ใบประเมินการสอบ </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">





                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="table_name" class="form-label">อนุสาขาวิชา</label>
                            <select name="type_work_id" id="type_work_id" class="form-select rounded-pill" required>
                                <option value=""> เลือกอนุสาขาวิชา </option>
                                <?php
                                include "config.inc.php";
                                $sql_type_work = "SELECT * FROM  tbl_type_work where type_work_status = 1";
                                $query_type_work = $conn->query($sql_type_work);
                                while ($result_type_work  = $query_type_work->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $result_type_work['type_work_id']; ?>"> <?php echo $result_type_work['type_work_name']; ?></option>
                                <?php
                                }
                                $conn->close();
                                ?>
                            </select>
                            <div class="invalid-feedback"> กรุณาเลือก อนุสาขาวิชา </div>
                        </div>
                    </div>
                    <br>





                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="form_main_name" class="form-label">ชื่อใบประเมินการสอบ</label>
                            <input type="text" name="form_main_name" class="form-control rounded-pill" placeholder="ชื่อใบประเมินการสอบ" value="" required>
                            <div class="invalid-feedback"> กรุณากรอก ชื่อใบประเมินการสอบ </div>
                        </div>
                    </div>




                    <br>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="form_main_table" class="form-label">ชื่อตาราง</label>
                            <input type="text" name="form_main_table" class="form-control rounded-pill" placeholder="ชื่อตาราง" value="" required>
                            <div class="invalid-feedback"> กรุณากรอก ชื่อตาราง </div>
                        </div>
                    </div>


                    <?php
                    //$array_form_main_detail = json_decode($form_main_detail, true);
                    $map_detail = [
                        "hn" => "ผู้ป่วย HN",
                        "t" => "ซี่ฟัน",
                        "s" => "ด้าน",
                        "r" => "ราก",
                        "c" => "คลาส",
                        "ct" => "นับครั้งที่"
                    ];
                    ?>
                    <br>


                    <!--
                    <div class="col-sm-12">
                        <div class="row">
                            <?php
                            foreach ($map_detail as $id => $name) {
                            ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-check form-switch">
                                            <input name="form_main_detail[]" class="form-check-input" type="checkbox" id="form_main_detail<?php echo $id; ?>" value="<?php echo $id; ?>" style="height: 24px; width: 48px; border-color: pink ; background-color: pink  !important;">
                                            <label class="form-check-label" for="form_main_detail<?php echo $id; ?>"> &nbsp;<?php echo $name; ?></label>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    -->



                    <div class="col-sm-12">
                        <div class="row">
                            <label>รายละเอียดใบประเมิน</label>
                            <?php
                            foreach ($map_detail as $id => $name) {
                            ?>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" name="form_main_detail[]" type="checkbox" id="form_main_detail<?php echo $id; ?>" style="width: 2em; height: 2em;" value="<?php echo $id; ?>">
                                            <label class="form-check-label" for="form_main_detail<?php echo $id; ?>">
                                                &nbsp; <?php echo $name; ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                            <?php
                            }
                            ?>
                        </div>
                    </div>


                    <hr>




                    <?php
                    //$array_form_main_detail = json_decode($form_main_detail, true);
                    $map_step = [
                        "G" => "แบ่งหัวข้อ",
                        "W" => "น้ำหนัก",
                        "F" => "คะแนนเต็ม"
                    ];
                    ?>


                    <div class="col-sm-12">
                        <div class="row">
                            <label>หัวคอลัมการประเมิน</label>
                            <?php
                            foreach ($map_step as $id => $name) {
                            ?>
                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" name="form_main_detail_step[]" type="checkbox" id="form_main_detail_step<?php echo $id; ?>" style="width: 2em; height: 2em;" value="<?php echo $id; ?>">
                                            <label class="form-check-label" for="form_main_detail_step<?php echo $id; ?>">
                                                &nbsp; <?php echo $name; ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                            <?php
                            }
                            ?>
                        </div>
                    </div>







                    <br>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select name="form_main_status" id="form_main_status" class="form-select rounded-pill" style="border-color: pink; background-color: pink  !important;" required>
                                <option value="" style="border-color: red; background-color: red  !important;"> เลือก สถานะ </option>
                                <option value="0">ปิดการใช้งาน</option>
                                <option value="1">เปิดการใช้งาน</option>
                            </select>
                            <div class="invalid-feedback"> กรุณาเลือก สถานะ </div>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="submit" type="submit" value="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>

        </div>

    </div><!-- End Vertically centered Modal-->
</form><!-- End General Form Elements -->



<?php

if (isset($_POST['submit'])) {

    include "config.inc.php";

    if (isset($_POST['form_main_id'])  && !empty($_POST['form_main_id'])) {
        $form_main_id = $conn->real_escape_string($_POST['form_main_id']);
    } else {
        $form_main_id = 0;
    }


    if (isset($_POST['type_work_id'])  && !empty($_POST['type_work_id'])) {
        $type_work_id = $conn->real_escape_string($_POST['type_work_id']);
    } else {
        $type_work_id = '';
    }


    if (isset($_POST['form_main_name'])  && !empty($_POST['form_main_name'])) {
        $form_main_name = $conn->real_escape_string($_POST['form_main_name']);
    } else {
        $form_main_name = '';
    }


    if (isset($_POST['form_main_status'])  && !empty($_POST['form_main_status'])) {
        $form_main_status = $conn->real_escape_string($_POST['form_main_status']);
    } else {
        $form_main_status = 0;
    }


    if (isset($_POST['form_main_table'])  && !empty($_POST['form_main_table'])) {
        $form_main_table = $conn->real_escape_string($_POST['form_main_table']);
    } else {
        $form_main_table = 0;
    }


    if (isset($_POST['form_main_detail'])) {
        $form_main_detail = json_encode($_POST['form_main_detail']);
    } else {
        $form_main_detail = json_encode([]);
    }


    if (isset($_POST['form_main_detail_step'])) {
        $form_main_detail_step = json_encode($_POST['form_main_detail_step']);
    } else {
        $form_main_detail_step = json_encode([]);
    }






    if (isset($_POST['form_main_confirm'])  && !empty($_POST['form_main_confirm'])) {
        $form_main_confirm = $conn->real_escape_string($_POST['form_main_confirm']);
    } else {
        $form_main_confirm = 0;
    }




    if (!empty($form_main_id)) {


        $sql_up = " UPDATE tbl_form_main SET ";
        $sql_up .= "  type_work_id = '$type_work_id', ";
        $sql_up .= "  form_main_name = '$form_main_name', ";
        $sql_up .= "  form_main_status = '$form_main_status', ";
        $sql_up .= "  form_main_table = '$form_main_table', ";
        $sql_up .= "  form_main_detail = '$form_main_detail', ";
        $sql_up .= "  form_main_detail_step = '$form_main_detail_step', ";
        $sql_up .= "  form_main_confirm = '$form_main_confirm' ";
        $sql_up .= " WHERE  form_main_id = '$form_main_id' ";
        $conn->query($sql_up);

        $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';
    } else {



        $sql_in = " INSERT INTO tbl_form_main (form_main_id, type_work_id,    form_main_name,    form_main_status,    form_main_table,    form_main_detail, form_main_detail_step, form_main_confirm ) VALUES ";
        $sql_in .= " ( NULL, '$type_work_id', '$form_main_name', '$form_main_status', '$form_main_table', '$form_main_detail', '$form_main_detail_step', '$form_main_confirm' ) ";
        $conn->query($sql_in);

        $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
    }

    echo "<script type='text/javascript'>";
    //echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='form_main.php';";
    echo "</script>";
}




?>




<section class="section dashboard">


    <div class="row">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Datatables ข้อมูล ใบประเมินการสอบปฏิบัติ </h5>

                <!-- Table with stripped rows -->

                <table id="DataTable1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th width="10">อนุสาขาวิชา</th>
                            <th width="10">ชื่อใบประเมินการสอบ</th>
                            <th width="5">รายละเอียด</th>
                            <th width="5">หัวข้อ</th>
                            <th width="5">ตาราง</th>
                            <th width="5">ยืนยัน</th>
                            <th width="5">สถานะ</th>
                            <th width="10">จัดการข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?PHP
                        include "config.inc.php";
                        $sql = " SELECT * FROM tbl_form_main as fm ";
                        $sql .= " INNER JOIN  tbl_type_work AS tw  on fm.type_work_id = tw.type_work_id";
                        $sql .= " ORDER BY fm.form_main_id ASC ";
                        $query = $conn->query($sql);
                        $i = 0;
                        while ($result = $query->fetch_assoc()) {
                            $i++;

                            $form_main_id = $result['form_main_id'];
                            $type_work_id = $result['type_work_id'];
                            $form_main_name = $result['form_main_name'];
                            $form_main_status = $result['form_main_status'];
                            $form_main_table = $result['form_main_table'];
                            $form_main_detail = $result['form_main_detail'];
                            $form_main_detail_step = $result['form_main_detail_step'];
                            $form_main_confirm = $result['form_main_confirm'];

                        ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $i; ?>
                                </th>

                                <td><?php echo $result['type_work_name']; ?> </td>
                                <td><?php echo $result['form_main_name']; ?> </td>
                                <td><?php echo $result['form_main_detail']; ?> </td>
                                <td><?php echo $result['form_main_detail_step']; ?> </td>
                                <td><?php echo $result['form_main_table']; ?> </td>



                                <td>
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
                                </td>





                                <td>
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
                                </td>





                                <td>
                                    <?php $form_main_id = md5($result['form_main_id']); ?>
                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $form_main_id; ?>">
                                        <i class='ri-edit-line'></i> จัดการข้อมูล
                                    </button>
                                </td>
                            </tr>





                            <!-- Modal -->
                            <div class="modal fade" id="delModal<?php echo $form_main_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <form name="form<?php echo $form_main_id; ?>" method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <font color='#fff'> <i class='ri-delete-bin-5-line'></i> Delete </font>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input name="form_main_id" type="hidden" value="<?php echo $result['form_main_id']; ?>" />
                                                <center>
                                                    <h3>
                                                        <font color="red"> ยืนยันการลบอีกครั้ง </font>
                                                    </h3>

                                                </center>
                                            </div>

                                            <div class="modal-footer">
                                                <button name="submit_del" type="submit" value="submit_del" class="btn btn-danger">ยืนยัน</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>







                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $form_main_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-scrollable">

                                    <form name="form<?php echo $form_main_id; ?>" method="post" action="" enctype="multipart/form-data">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">  แก้ไข <?php echo $form_main_id; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">


                                                <input name="form_main_id" type="hidden" value="<?php echo $result['form_main_id']; ?>" />


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="table_name" class="form-label">อนุสาขาวิชา</label>
                                                        <select name="type_work_id" id="type_work_id" class="form-select rounded-pill" required>
                                                            <option value=""> เลือกอนุสาขาวิชา </option>
                                                            <?php
                                                            $sql_type_work = "SELECT * FROM  tbl_type_work where type_work_status = 1";
                                                            $query_type_work = $conn->query($sql_type_work);
                                                            while ($result_type_work  = $query_type_work->fetch_assoc()) {
                                                            ?>
                                                                <option value="<?php echo $result_type_work['type_work_id']; ?>" <?php if (!(strcmp($result_type_work['type_work_id'], $type_work_id))) {
                                                                                                                                        echo "selected=\"selected\"";
                                                                                                                                    } ?>> <?php echo $result_type_work['type_work_name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="invalid-feedback"> กรุณาเลือก อนุสาขาวิชา </div>
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="form_main_name" class="form-label">ชื่อใบประเมินการสอบ</label>
                                                        <input type="text" name="form_main_name" class="form-control rounded-pill" placeholder="ชื่อใบประเมินการสอบ" value="<?php echo $form_main_name; ?>" required>
                                                        <div class="invalid-feedback"> กรุณากรอก ชื่อใบประเมินการสอบ </div>
                                                    </div>
                                                </div>


                                                <br>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="form_main_table" class="form-label">ชื่อตาราง</label>
                                                        <input type="text" name="form_main_table" class="form-control rounded-pill" placeholder="ชื่อตาราง" value="<?php echo $form_main_table; ?>" required>
                                                        <div class="invalid-feedback"> กรุณากรอก ชื่อตาราง </div>
                                                    </div>
                                                </div>


                                                <?php
                                                $array_form_main_detail = json_decode($form_main_detail, true);
                                                $map_detail = [
                                                    "hn" => "ผู้ป่วย HN",
                                                    "t" => "ซี่ฟัน",
                                                    "s" => "ด้าน",
                                                    "r" => "ราก",
                                                    "c" => "คลาส",
                                                    "ct" => "นับครั้งที่"
                                                ];
                                                ?>

                                                <br>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <?php
                                                        foreach ($map_detail as $id => $name) {
                                                        ?>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="form_main_detail[]" type="checkbox" id="<?php echo $id; ?><?php echo $form_main_id; ?>" style="width: 2em; height: 2em;" <?php if (in_array($id, $array_form_main_detail)) {
                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                            }  ?> value="<?php echo $id; ?>">
                                                                        <label class="form-check-label" for="<?php echo $id; ?><?php echo $form_main_id; ?>">
                                                                            &nbsp; <?php echo $name; ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>



                                                <hr>


                                                <?php
                                                $array_form_main_detail_step = json_decode($form_main_detail_step, true);
                                                $map_step = [
                                                    "G" => "แบ่งหัวข้อ",
                                                    "W" => "น้ำหนัก",
                                                    "F" => "คะแนนเต็ม"
                                                ];
                                                ?>


                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label>หัวคอลัมการประเมิน</label>
                                                        <?php
                                                        foreach ($map_step as $id => $name) {
                                                        ?>
                                                            <div class="col-sm-4">

                                                                <div class="form-group">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="form_main_detail_step[]" type="checkbox" id="form_main_detail_step<?php echo $id; ?><?php echo $form_main_id; ?>" style="width: 2em; height: 2em;" <?php if (in_array($id, $array_form_main_detail_step)) {
                                                                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                                                                        }  ?> value="<?php echo $id; ?>">
                                                                        <label class="form-check-label" for="form_main_detail_step<?php echo $id; ?><?php echo $form_main_id; ?>">
                                                                            &nbsp; <?php echo $name; ?> 
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <br>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <br>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>สถานะ</label>
                                                        <select name="form_main_status" id="form_main_status" class="form-select rounded-pill" required>
                                                            <option value=""> เลือก สถานะ </option>
                                                            <option value="0" <?php if (!(strcmp(0, $form_main_status))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>>ปิดการใช้งาน</option>
                                                            <option value="1" <?php if (!(strcmp(1, $form_main_status))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>>เปิดการใช้งาน</option>
                                                        </select>
                                                        <div class="invalid-feedback"> กรุณาเลือก สถานะ </div>
                                                    </div>
                                                </div>
                                            </div>


                                          

                                            <div class="modal-footer">


                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delModal<?php echo $form_main_id; ?>">
                                                    <i class='ri-delete-bin-5-line'></i> Delete
                                                </button>
                                                <button name="submit" type="submit" value="submit" class="btn btn-primary"> <i class='ri-save-2-line'></i> Save changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>




                                             <a href="form_detail.php?form_main_id=<?php echo $form_main_id; ?>" class="btn btn-primary btn-sm btn-block"> << จัดการขั้นตอนการประเมิน >> </a>
                                             <a href="form_view.php?form_main_id=<?php echo $form_main_id; ?>" class="btn btn-success btn-sm btn-block"> << ตัวอย่าง >> </a>

                                            </div>

                                           
                                          
                                        </div>
                                    </form>



                                </div>
                            </div>




                        <?php
                        }
                        $conn->close();
                        ?>

                    </tbody>
                </table>
                <!-- End Table with stripped rows -->

            </div>
        </div>



        <!-- Button trigger modal -->






    </div>
</section>




<?php include "footer.php"; ?>