<?php include "header.php"; ?>



<div class="pagetitle">
    <h1>ข้อมูล ใบประเมินการสอบ </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">ใบประเมินการสอบ</li>
        </ol>
    </nav>
</div><!-- End Page Title -->






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

                            $form_main_id = md5($result['form_main_id']);
                        ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $i; ?>
                                </th>

                                <td><?php echo $result['type_work_name']; ?> </td>
                                <td><?php echo $result['form_main_name']; ?> </td>
                             



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
                                <a href="form_view.php?form_main_id=<?php echo $form_main_id; ?>" class="btn btn-success btn-sm btn-block"> << ตัวอย่าง >> </a>
                                </td>
                            </tr>


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