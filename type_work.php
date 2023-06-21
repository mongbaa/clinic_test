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
    <h1>ข้อมูล อนุสาขาวิชาให้บริการ </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">อนุสาขาวิชาให้บริการ</li>
        </ol>

        <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#verticalycentered">
            <i class="ri-add-circle-fill"></i> เพิ่ม อนุสาขาวิชาให้บริการ
        </button>
    </nav>
</div><!-- End Page Title -->




<?php


if (!empty($_GET['edit']) && !empty($_GET['check']) && ($_GET['check'] == md5($_GET['edit'] . 'edit108'))) {

    include "config.inc.php";
    $sql_edit = "SELECT * FROM tbl_type_work WHERE md5(type_work_id) = '$_GET[edit]' ";
    $query_edit = $conn->query($sql_edit);
    $result_edit = $query_edit->fetch_assoc();


    $type_work_id = $result_edit['type_work_id'];
    $type_work_name = $result_edit['type_work_name'];
    $type_work_status = $result_edit['type_work_status'];

    $conn->close();
    
} else {

    $type_work_id = "";
    $type_work_name = "";
    $type_work_status = "";
}




if (isset($_POST['submit_del'])) {

    $type_work_id  = $_POST['type_work_id'];
    $type_work_id_spm = $_SESSION["user_id_clinic_test"];
    $ipp = $_SERVER['REMOTE_ADDR'];
    $type_work_log  = ",DE|" . date('Y-m-d H:s:i') . "|$type_work_id_spm|" . $ipp . "/";

    include "config.inc.php";
    $sql_del = "DELETE FROM tbl_type_work WHERE type_work_id = $type_work_id  ";
    $conn->query($sql_del);
    $conn->close();

    $_SESSION['do'] = 'ลบข้อมูลสำเร็จ';

    echo "<script type='text/javascript'>";
    // echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='type_work.php';";
    echo "</script>";
}


?>





<form class="needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
    <div class="modal fade" id="verticalycentered" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">


            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title"><i class=" ri-add-circle-fill"></i> เพิ่ม อนุสาขาวิชา </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">




                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="type_work_name" class="form-label">ชื่ออนุสาขาวิชา</label>
                            <input type="text" name="type_work_name" class="form-control rounded-pill" placeholder="ชื่ออนุสาขาวิชา" value="<?php echo $type_work_name; ?>" required>
                            <div class="invalid-feedback"> กรุณากรอก ชื่อ ชื่ออนุสาขาวิชา </div>
                        </div>
                    </div>

                   

                    <br>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>สถานะ</label>
                            <select name="type_work_status" id="type_work_status" class="form-select rounded-pill" required>
                                <option value=""> เลือก สถานะ </option>
                                <option value="0" <?php if (!(strcmp(0, $type_work_status))) {
                                                        echo "selected=\"selected\"";
                                                    } ?>>ปิดการใช้งาน</option>
                                <option value="1" <?php if (!(strcmp(1, $type_work_status))) {
                                                        echo "selected=\"selected\"";
                                                    } ?>>เปิดการใช้งาน</option>
                            </select>
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

    if (isset($_POST['type_work_id'])  && !empty($_POST['type_work_id'])) {
        $type_work_id = $conn->real_escape_string($_POST['type_work_id']);
    } else {
        $type_work_id = 0;
    }

    if (isset($_POST['type_work_name'])  && !empty($_POST['type_work_name'])) {
        $type_work_name = $conn->real_escape_string($_POST['type_work_name']);
    } else {
        $type_work_name = '';
    }

   

 

    if (isset($_POST['type_work_status'])  && !empty($_POST['type_work_status'])) {
        $type_work_status = $conn->real_escape_string($_POST['type_work_status']);
    } else {
        $type_work_status = 0;
    }


    if (!empty($type_work_id)) {


        $sql_up = "UPDATE tbl_type_work SET type_work_name = '$type_work_name',  type_work_status = '$type_work_status' WHERE  type_work_id = '$type_work_id'";
        $conn->query($sql_up);

        $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';

    } else {



        $sql_in = " INSERT INTO tbl_type_work (type_work_id, type_work_name, type_work_status) VALUES (NULL,'$type_work_name', '$type_work_status')";
        $conn->query($sql_in);

        $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
    }

    echo "<script type='text/javascript'>";
    //echo "alert('[บันทึกข้อมูสำเร็จ]');";
    echo "window.location='type_work.php';";
    echo "</script>";
}




?>




<section class="section dashboard">


    <div class="row">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Datatables ข้อมูล อนุสาขาวิชาให้บริการ </h5>

                <!-- Table with stripped rows -->

                <table id="DataTable1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5">#</th>
                            <th width="10">ชื่ออนุสาขาวิชา</th>
                            <th width="5">สถานะ</th>
                            <th width="10">จัดการข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?PHP
                        include "config.inc.php";
                        $sql = " SELECT * FROM tbl_type_work as tbl_type_work ";
                        $sql .= " ORDER BY tbl_type_work.type_work_id ASC ";
                        $query = $conn->query($sql);
                        $i = 0;
                        while ($result = $query->fetch_assoc()) {
                        $i++;

                            $type_work_name = $result['type_work_name'];
                            $type_work_status = $result['type_work_status'];
                            $type_work_id = $result['type_work_id'];

                        ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $i; ?>
                                </th>

                                <td><?php echo $result['type_work_name']; ?> </td>
                                <td>
                                    <?php
                                    switch ($type_work_status) { // Harder page
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
                                    <?php $type_work_id = md5($result['type_work_id']); ?>
                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $type_work_id; ?>">
                                        <i class='ri-edit-line'></i> จัดการข้อมูล
                                    </button>
                                </td>
                            </tr>





                            <!-- Modal -->
                            <div class="modal fade" id="delModal<?php echo $type_work_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <form name="form<?php echo $type_work_id; ?>" method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <font color='#fff'> <i class='ri-delete-bin-5-line'></i> Delete </font>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input name="type_work_id" type="hidden" value="<?php echo $result['type_work_id']; ?>" />
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
                            <div class="modal fade" id="exampleModal<?php echo $type_work_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-scrollable">

                                    <form name="form<?php echo $type_work_id; ?>" method="post" action="" enctype="multipart/form-data">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo $type_work_id; ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">


                                                <input name="type_work_id" type="hidden" value="<?php echo $result['type_work_id']; ?>" />


                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="type_work_name" class="form-label">ชื่ออนุสาขาวิชา</label>
                                                        <input type="text" name="type_work_name" class="form-control rounded-pill" placeholder="ชื่ออนุสาขาวิชา" value="<?php echo $type_work_name; ?>" required>
                                                        <div class="invalid-feedback"> กรุณากรอก ชื่อ ชื่ออนุสาขาวิชา </div>
                                                    </div>
                                                </div>


                                                <br>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>สถานะ</label>
                                                        <select name="type_work_status" id="type_work_status" class="form-select rounded-pill" required>
                                                            <option value=""> เลือก สถานะ </option>
                                                            <option value="2" <?php if (!(strcmp(2, $type_work_status))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>>ปิดการใช้งาน</option>
                                                            <option value="1" <?php if (!(strcmp(1, $type_work_status))) {
                                                                                    echo "selected=\"selected\"";
                                                                                } ?>>เปิดการใช้งาน</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delModal<?php echo $type_work_id; ?>">
                                                    <i class='ri-delete-bin-5-line'></i> Delete
                                                </button>
                                                <button name="submit" type="submit" value="submit" class="btn btn-primary"> <i class='ri-save-2-line'></i> Save changes</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>
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