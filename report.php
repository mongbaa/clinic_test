<?php include "header.php"; ?>


<?php
if (!isset($_SESSION['Login_clinic_test'])) {
    echo "<META http-equiv=refresh content=0;url=login.php>";
    exit;
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

<style>
            .table-responsive {
                height: 500px;
                overflow: scroll;
            }

            thead tr:nth-child(1) th {
                background: white;
                position: sticky;
                top: 0;
                z-index: 10;
            }

            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td,
            th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #dddddd;
                color: black;
            }

            th:first-child,


            td:first-child {
                position: sticky;
                left: 0px;
            }

            td:first-child {
                background-color: whitesmoke;
                color: black;
            }


            table,
            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                border-style: dotted;

            }
        </style>
<div class="pagetitle">
    <h1>รายงาน</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Report</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<?php
//ตัวแปรเงื่อนไขการค้นหา
if (isset($_GET['level_search'])) {
    $level_search = $_GET['level_search'];
} else {
    $level_search = 1;
}

if (isset($_GET['student_search'])) {
    $student_search = $_GET['student_search'];
} else {
    $student_search = "";
}


if (isset($_GET['type_work_id'])) {
    $type_work_id = $_GET['type_work_id'];
} else {
    $type_work_id = 1;
}


?>

<section class="section dashboard">

    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> ค้นหาข้อมูล </h5>

                <form method="get" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="row p-2">



                        <div class="col-sm-4">
                            <?php for ($i = 4; $i <= 6; $i++) { ?>
                                <a href="?level_search=<?php echo $i; ?>&type_work_id=<?php echo $type_work_id; ?>" <?php if ($level_search == $i) { ?> class="btn btn-primary" <?php } else { ?> class="btn btn-outline-primary" <?php } ?>>
                                    ชั้นปีที่ <?php echo $i; ?>
                                </a>
                            <?php } ?>
                        </div>

                        <input type="hidden" name="type_work_id" value="<?php echo $type_work_id; ?>">


                        <div class="col-sm-4">
                            <input class="form-control" type="search" name="student_search" placeholder="รหัส , ชื่อ , สกุล" value="<?php echo $student_search; ?>" aria-label="Search">
                        </div>

                        <div class="col-sm-4">
                            <button class="btn btn-info" type="submit">Search</button>
                        </div>

                    </div>
                </form>



                <div class="row p-2">

                                <div class="col-sm-12">

                                <?PHP
                                    include "config.inc.php";
                                    $sql_type_work = " SELECT * FROM tbl_type_work as tbl_type_work WHERE type_work_status = 1";
                                    $sql_type_work .= " ORDER BY tbl_type_work.type_work_id ASC ";
                                    $query_type_work = $conn->query($sql_type_work);
                                    while ($result_type_work = $query_type_work->fetch_assoc()) {
                                        $type_work_name = $result_type_work['type_work_name'];
                                        $type_work_status = $result_type_work['type_work_status'];
                                        $type_work_id_ = $result_type_work['type_work_id'];
                                        
                                        
                                ?>
                                
                                        <a href="?level_search=<?php echo $level_search;?>&type_work_id=<?php echo $type_work_id_;?>" <?php if ($type_work_id_ == $type_work_id) { ?> class="btn btn-success" <?php } else { ?> class="btn btn-outline-success" <?php } ?>>
                                            <?php echo $type_work_name;?>
                                        </a>

                                <?php } ?>



                                </div>

                </div>

            </div>
        </div>
    </div>


                           




    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> รายงานประเมินการสอบปฏิบัติ 9 งาน ศ.ป.ท. </h5>
                <div class="table-responsive">
                    <table id="DataTable1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <?PHP
                                    $form_main_array = array();
                                    $sql_form_main  = " SELECT * FROM tbl_form_main as form_main ";
                                    $sql_form_main .= " where  form_main.type_work_id = $type_work_id ";
                                    $sql_form_main .= " ORDER BY form_main.form_main_id ASC ";
                                    $query_form_main = $conn->query($sql_form_main);
                                    while ($result_form_main = $query_form_main->fetch_assoc()) {
                                        $i++;
                                        $form_main_name = $result_form_main['form_main_name'];
                                        $form_main_id = $result_form_main['form_main_id'];
                                        $form_main_detail = $result_form_main['form_main_detail'];

                                        $form_main_array[] = array(
                                            'form_main_name' => $result_form_main['form_main_name'],
                                            'form_main_id' => $result_form_main['form_main_id'],
                                            'form_main_table' => $result_form_main['form_main_table']
                                        );


                                ?>

                                        <th colspan="3" ><center> <?php echo $form_main_name; ?>  </center> </th>

                                <?php } ?>
                            </tr>

                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อ - สกุล</th>
                                <?PHP
                                    foreach ($form_main_array as $values => $data) {
                                        $form_main_table = $data['form_main_table'];
                                        $form_main_id = $data['form_main_id'];
                                ?>

                                        <th><center> ครั้ง  </center> </th>
                                        <th><center> ผ่าน </th>
                                        <th><center> Incomplete </th>

                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <?PHP
                            include "config.inc_clinic.php";
                            $i = 0;
                            $sql_student   =  " SELECT *FROM  tbl_student ";
                            if ($level_search == "all") {
                                $sql_student  .=  " ORDER BY student_id ASC   ";
                            } else if ($student_search != "") {
                                $sql_student   .=  " where student_id like '%$student_search%' or student_name like '%$student_search%' or student_lastname like '%$student_search%' ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            } else {
                                $sql_student   .=  " where student_level = $level_search ";
                                $sql_student  .=  " ORDER BY student_id ASC  ";
                            }
                            $query_student = $conn_clinic->query($sql_student);
                            while ($result_student = $query_student->fetch_assoc()) {
                                $i++;
                                $student_id = $result_student['student_id'];
                            ?>
                                <tr>
                                    <th scope="row"> <?php echo $result_student['student_id']; ?> </th>
                                    <td> <?php echo $result_student['student_name']; ?> <?php echo $result_student['student_lastname']; ?> </td>
                                    <?php
                                        foreach ($form_main_array as $values => $data) {
                                        $form_main_table = $data['form_main_table'];
                                        $form_main_id = $data['form_main_id'];
                                    ?>
                                    
                                    <td>   
                                        <center>
                                                <?php
                                                $sql_detail = " SELECT COUNT( * ) as Count_row FROM tbl_detail as d ";
                                                $sql_detail .= " WHERE d.form_main_id = '$form_main_id' and  student_id = $student_id ";
                                                $query_detail = $conn->query($sql_detail);
                                                if($result_detail = $query_detail->fetch_assoc()){
                                                    $Count_row = $result_detail['Count_row'];
                                                }else{
                                                    
                                                    $Count_row = '';
                                                }
                                                
                                                    echo $Count_row; 
                                                ?> 
                                        </center>
                                    </td>


                                    <?php
                                        $sql_complete = " SELECT COUNT( * ) as Count_complete FROM tbl_detail as d ";
                                        $sql_complete .= " WHERE d.form_main_id = '$form_main_id' and  student_id = $student_id and  detail_complete = 1";
                                        $query_complete = $conn->query($sql_complete);
                                        if($result_complete = $query_complete->fetch_assoc()){
                                            $Count_complete = $result_complete['Count_complete'];
                                        }else{
                                            
                                            $Count_complete = 0;
                                        }
                                    ?> 

                                    <?php if($Count_complete >= 1){?>
                                        <td class="table-success">
                                    <?php }else{?> 
                                        <td>
                                    <?php }?>

                                        <center>
                                                <?php
                                                    echo $Count_complete; 
                                                ?> 
                                        </center>

                                    </td>



                                    <?php
                                        $sql_complete = " SELECT COUNT( * ) as Count_incomplete FROM tbl_detail as d ";
                                        $sql_complete .= " WHERE d.form_main_id = '$form_main_id' and  student_id = $student_id and  detail_complete = 2";
                                        $query_complete = $conn->query($sql_complete);
                                        if($result_complete = $query_complete->fetch_assoc()){
                                            $Count_incomplete = $result_complete['Count_incomplete'];
                                        }else{
                                            
                                            $Count_incomplete = 0;
                                        }
                                    ?> 
                                    <td>
                                        <center>
                                                <?php
                                                    echo $Count_incomplete; 
                                                ?> 
                                        </center>

                                    </td>



                                    <?php } ?>
                                </tr>
                            <?php
                            }
                            $conn_clinic->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</section>