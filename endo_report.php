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




            </div>
        </div>
    </div>







    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> รายงานประเมินการสอบปฏิบัติ 9 งาน ศ.ป.ท. Endo </h5>



                <?PHP // ข้อมูลงานที่มีในสาขาที่ส่งค่ามา
                $student_id = '6110810018';
                $type_work_id = 5; //Endo
                $form_main_id = 132; //Root Canal Treatment (License)
                $tbl = "endo_rootcanallicense";


                $array_step = array();
               



                include "config.inc_clinic.php";

                $sql_detail = " SELECT o.*, d.*, p.* ";
                $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                $sql_detail  .=  " INNER JOIN  tbl_detail as d  ON  d.order_id = o.order_id";
                $sql_detail  .=  " INNER JOIN  tbl_plan as p  ON  p.plan_id = d.plan_id";
                $sql_detail  .=  " WHERE d.plan_id = 107  ";
                //   $sql_detail = " SELECT o.*, d.*, p.*, t.*, f.* ";
                //   $sql_detail  .=  " FROM (SELECT * FROM tbl_order WHERE student_id = $student_id) as o ";
                //   $sql_detail  .=  " INNER JOIN (SELECT detail_id, order_id, plan_id  FROM tbl_detail ) as d  ON  d.order_id = o.order_id";
                //   $sql_detail  .=  " INNER JOIN (SELECT * FROM tbl_detail WHERE type_work_id = $type_work_id) as p  ON  p.plan_id = d.plan_id";
                //   $sql_detail  .=  " INNER JOIN  tbl_type_work   AS t  ON  t.type_work_id = p.type_work_id ";
                //  echo $sql_detail  .=  " WHERE d.plan_id = 107  ";
                //$sql_detail  .=  " INNER  JOIN (SELECT * FROM tbl_form_main where form_main_confirm = 1 and form_main_status = 'Y'  ) AS f  ON  f.form_main_id = p.form_main_id ";
                $query_detail = $conn_clinic->query($sql_detail);
                while ($result_detail = $query_detail->fetch_assoc()) {

                    echo $plan_name = $result_detail['plan_name'];
                    $plan_id = $result_detail['plan_id']; // 
                    $detail_id = $result_detail['detail_id']; // ID งาน

                ?>


                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-user"></i>
                            HN : <?php echo $result_detail['HN']; ?> :
                            <?php echo $result_detail['pname']; ?><?php echo $result_detail['fname']; ?>
                            <?php echo $result_detail['lname']; ?>

                            <?php if (!empty($result_detail['detail_surface'])) { ?>
                                Surface : <?php echo $result_detail['detail_surface']; ?>
                            <?php } ?>

                            <?php if (!empty($result_detail['detail_root'])) { ?>
                                Root : <?php echo $result_detail['detail_root']; ?>
                            <?php } ?>

                            <?php if (!empty($result_detail['class_id'])) { ?>
                                Class : <?php echo nameClass::get_class_name($result_detail['class_id']); ?>
                            <?php } ?>

                            <?php if (!empty($result_detail['detail_tooth'])) {  ?>
                                <?php
                                $array_detail_tooth = (array)json_decode($result_detail['detail_tooth']);
                                $toothh = "";
                                foreach ($array_detail_tooth as $id => $value) {
                                ?>
                                    <span class="btn btn-info rounded-pill btn-sm"> <?php echo $value; ?></span>
                                <?php }  ?>
                            <?php
                            }
                            ?>
                            <span class="btn btn-secondary rounded-pill btn-sm"> Date : <?php echo $result_detail['detail_date_work']; ?></span>
                        </h2>
                    </div>




                    <!--<div style="overflow-x:auto;"> -->
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th Width="3%">
                                    <div align="center">ลำดับ</div>
                                </th>
                                <th Width="30%">หัวข้อการประเมิน / ขั้นตอน </th>
                                <?php

                                $sql_form_re = "SELECT * FROM tbl_endo_rootcanallicense where detail_id = $detail_id";
                                $sql_form_re  .=  " ORDER BY endo_rootcanallicense_id  ASC ";
                                $query_form_re = $conn_clinic->query($sql_form_re);
                                while ($row_form_re = $query_form_re->fetch_assoc()) {
                                    $id_form_re = $row_form_re['endo_rootcanallicense_id'];
                                ?>


                                    <th Width="7%">
                                        <div align="center">คะแนน</div>
                                    </th>

                                    <th Width="5%"> Sum </th>


                                <?php } // $sql_form_re 
                                ?>

                                <th Width="5%"> Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i_re = 0;
                            $total_sum = 0;
                            $total_sum_s = 0;
                            $total_step = 0;
                            $sum_score = 0;
                            $sum_score_full = 0;
                            $sum_stepp  = 0;
                            $total_weight = 0;
                            $total_sum = 0;


                            // หาชื่อฟิลด์
                            $sql_form_detail_re   =  " SELECT fd.form_main_id, fd.form_detail_id, fd.form_detail_topic, fd.form_detail_field, fd.form_detail_order";
                            $sql_form_detail_re  .=  " FROM (SELECT f.*   FROM tbl_form_detail AS f WHERE f.form_main_id = '$form_main_id') AS fd ";
                            $sql_form_detail_re  .=  " ORDER BY fd.form_detail_order ASC ";
                            //echo $sql_form_detail_re;
                            $query_form_detail_re = $conn_clinic->query($sql_form_detail_re);
                            while ($row_form_detail_re = $query_form_detail_re->fetch_assoc()) {
                                $i_re++;
                                $field = $tbl . "_" . $row_form_detail_re['form_detail_field']; //ชื่อฟิลด์
                            ?>

                                <tr>
                                    <td>
                                        <div align="center"> <?php echo $i_re; ?></div>
                                    </td>
                                    <td><?php echo $row_form_detail_re['form_detail_topic']; ?> (<?php echo $row_form_detail_re['form_detail_field']; ?>) </td>
                                    <?php

                                    $total_weight = 0;
                                    $total_sum = 0;
                                    $sum_stepp_s = 0;
                                    $total_full = 0;
                                    $total_stepp = 0;
                                    $total_sum_stepp = 0;


                                    $sql_form_re = "SELECT * FROM tbl_" . $tbl . " where detail_id = $detail_id";
                                    $sql_form_re  .=  " ORDER BY endo_rootcanallicense_id  ASC ";
                                    $query_form_re = $conn_clinic->query($sql_form_re);
                                    $num_rows = $query_form_re->num_rows;
                                    while ($row_form_re = $query_form_re->fetch_assoc()) {


                                        $field_grade = $field . "_grade";  //_grade
                                        $grade = $row_form_re["{$field_grade}"];

                                        if (isset($grade) && !empty($grade)) {
                                            $field_weights = $field . "_weight";   //_weight
                                            $weight = $row_form_re["{$field_weights}"];
                                            $field_teacher = $field . "_teacher";  //_teacher
                                            $teacher = $row_form_re["{$field_teacher}"];
                                            $field_date = $field . "_date";  //_date
                                            $datee = $row_form_re["{$field_date}"];
                                        } else {
                                            $weight = "";
                                            $teacher = "";
                                            $datee = "";
                                        }


                                        if ($grade == "A") {
                                            $score = 4; //เกรด
                                            $stepp = 1; // จำนวนครั้ง
                                            $weight_ss =  $weight; //น้ำหนัก
                                            $claass = "table-success";  //สี
                                        } else if ($grade == "B+") {
                                            $score = 3.5;
                                            $stepp = 1;
                                            $weight_ss =  $weight;
                                            $claass = "table-success";
                                        } else if ($grade == "B") {
                                            $score = 3;
                                            $stepp = 1;
                                            $weight_ss =  $weight;
                                            $claass = "table-success";
                                        } else if ($grade == "C+") {
                                            $score = 2.5;
                                            $stepp = 1;
                                            $weight_ss =  $weight;
                                            $claass = "table-success";
                                        } else if ($grade == "C") {
                                            $score = 2;
                                            $stepp = 1;
                                            $weight_ss =  $weight;
                                            $claass = "table-success";
                                        } else if ($grade == "F") {
                                            $score = 0;
                                            $stepp = 1;
                                            $weight_ss =  $weight;
                                            $claass = "table-success";
                                        } else {
                                            $score = 0;
                                            $stepp = 0;
                                            $weight_ss =  0;
                                            $claass = "";
                                        }

                                    ?>


                                        <td>
                                            <div align="center">
                                                <?php if (!empty($grade)) { ?>
                                                    <?php echo $weight; ?> * <?php echo $grade; ?> (<?php echo $score; ?>)
                                                <?php } ?>
                                            </div>
                                        </td>

                                        <td class="<?php echo $claass; ?>">
                                            <?php
                                            $sum_score = $weight * $score; //คะแนนที่ได้
                                            $sum_score_full = $weight * 4; //คะแนนเต็ม
                                            $sum_stepp =  $stepp++;
                                            ?>
                                            <div align="center">
                                                <B> <?php echo  $sum_score; ?> </B>
                                            </div>
                                        </td>

                                    <?php
                                        $total_sum =  $total_sum + $sum_score; //คะแนนรวมในขั้นตอน
                                        $total_full =  $total_full + $sum_score_full; //คะแนนเต็มในขั้นตอน
                                        $total_weight =  $total_weight + $weight; //น้ำหนักรวม
                                        $total_stepp =  $total_stepp + $sum_stepp; //จำนวนได้คะแนนในขั้นตอน
                                    }
                                    @$total_step  = $total_sum / $total_weight;
                                 



                                    $array_step[] = array(
                                        'form_detail_topic' => $row_form_detail_re['form_detail_topic'],
                                        'form_detail_field' => $row_form_detail_re['form_detail_field'],
                                        'total_step' => round($total_step, 2)
                                    );

                                    
                                    $array_total_step[] = round($total_step, 2);

                                    ?>
                                    <td>
                                        <div align="center"> <?php echo round($total_step, 2); ?> </div>
                                    </td>
                                </tr>




                            <?php
                            }
                            ?>
                        </tbody>
                    </table>



                    <div class="row">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> รายงานประเมินการสอบปฏิบัติ 9 งาน ศ.ป.ท. Endo </h5>

                <table id="example3" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <div align="center">ลำดับ</div>
                            </th>
                            <th>
                                ขั้นตอน
                            </th>
                            <th>
                                <div align="center">คะแนนเต็ม</div>
                            </th>
                            <th>
                                <div align="center">คะแนนที่ได้</div>
                            </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div align="center">1</div> </td>
                            <td>Charting and treatment planning</td>
                            <td><div align="center">10</div></td>
                            <!-- <td><div align="center"> <?php echo $array_total_step['0']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step1 = ($array_total_step['0']*10) / 4; ?></div></td>
                        </tr>

                        <tr>
                            <td><div align="center">2</div> </td>
                            <td>Access opening</td>
                            <td><div align="center">15</div></td>
                            <!-- <td><div align="center"><?php echo $array_total_step['3']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step2 = ($array_total_step['3']*15) / 4; ?></div></td>
                        </tr>

                        <tr>
                            <td><div align="center">3</div> </td>
                            <td>Working length determination</td>
                            <td><div align="center">8</div></td>
                            <!-- <td><div align="center"><?php echo $array_total_step['4']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step3 = ($array_total_step['4']*8) / 4; ?></div></td>
                        </tr>

                        <tr>
                            <td><div align="center">4</div> </td>
                            <td>Mechanical instrumentation & trial main cone</td>
                            <td><div align="center">25</div></td>
                            <!-- <td><div align="center"> <?php echo $array_total_step['5']; ?> + <?php echo $array_total_step['6']; ?></div></td> -->
                            <td><div align="center"> 
                                    <?php 
                                        $step56 = $array_total_step['5'] =$array_total_step['6'];
                                        echo $total_step4 = ($step56*25) / 8; 
                                    ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td><div align="center">5</div> </td>
                            <td>Root canal obturation</td>
                            <td><div align="center">20</div></td>
                            <!-- <td><div align="center"><?php echo $array_total_step['7']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step5 = ($array_total_step['7']*20) / 4; ?></div></td>
                        </tr>

                        <tr>
                            <td><div align="center">6</div> </td>
                            <td>
                                    Patient management/ 
                                    Infection control Rubber dam/
                                    Irrigation / 
                                    Medication and Temporary seal 
                            </td>
                            <td><div align="center">10</div></td>
                            <!-- <td><div align="center"><?php echo $array_total_step['1']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step6 = ($array_total_step['1']*10) / 4; ?></div></td>

                        </tr>

                        <tr>
                            <td><div align="center">7</div> </td>
                            <td>Radiographic evaluation</td>
                            <td><div align="center">12</div></td>
                            <!-- <td><div align="center"><?php echo $array_total_step['2']; ?></div></td> -->
                            <td><div align="center"> <?php echo $total_step7 = ($array_total_step['2']*12) / 4; ?></div></td>
                        </tr>


                        <tr>
                            <td><div align="center"></div> </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div align="center"> 
                                <B>
                                <?php echo $total_step1 + $total_step2 + $total_step3 + $total_step4 + $total_step5 + $total_step6 + $total_step7; ?>
                                </B>
                                </div>
                            </td>
                        </tr>



                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            </div>





            

        <?php } ?>



        </div>
    </div>
 
 


                                   <?php
                                  
                                        foreach ($array_step as $values => $data) {
                                            
                                            $form_detail_topic =  $data['form_detail_topic'];
                                            $form_detail_field =  $data['form_detail_field'];
                                            $total_step =  $data['total_step'];
                                        }
                                        
                                       //echo implode(",", $array_total_step);
                                      //echo $array_total_step['0'];

                                    ?>


  
</section>