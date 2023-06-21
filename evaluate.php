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

if (isset($_GET['arrange_date_get'])) {
    $_SESSION["arrange_date_get"] = $_GET["arrange_date_get"];
    echo "<script wg='text/javascript'>";
    echo "window.location='evaluate.php';";
    echo "</script>";
} else {
}

if (isset($_SESSION['arrange_date_get'])) {
    $arrange_date_get = $_SESSION['arrange_date_get'];
} else {
    $arrange_date_get = date('Y-m-d');
}

?>


<div class="pagetitle">
    <h1>ประเมินการสอบ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="detail_work.php">เลือกวันที่</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->






<section class="section contact">
    <div class="row gy-4">
        <div class="col-lg-3">
            <form class="needs-validation" novalidate method="GET" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <input type="date" name="arrange_date_get" class="form-control rounded-pill" placeholder="วันที่ประเมิน" value="<?php echo $arrange_date_get; ?>" required>
                            <div class="invalid-feedback"> กรุณากรอก วันที่ประเมิน </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <button name="submit_date" type="submit" value="submit_date" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


<?php
   $teacher_id = $_SESSION["user_id"];
?>

    <br>
    <div class="row gy-4">
        <?PHP
            $detail_array = array();
            include "config.inc.php";
            $sql = " SELECT * FROM db_clinic_test.tbl_arrange as a ";
            $sql .= " INNER JOIN db_clinic_test.tbl_detail    as d on a.detail_id     = d.detail_id ";
            $sql .= " INNER JOIN db_clinic_test.tbl_form_main as f on d.form_main_id  = f.form_main_id ";
            $sql .= " INNER JOIN db_clinic.tbl_teacher as t on a.teacher_id  = t.teacher_id ";
            $sql .= " INNER JOIN db_clinic.tbl_student as s on d.student_id  = s.student_id ";
         
           if($loginname == 'mongkol.th'){ 

            $sql .= " where a.arrange_date = '$arrange_date_get' ";
           }else{
            $sql .= " where a.teacher_id = '$teacher_id' and a.arrange_date = '$arrange_date_get' ";

           }
            $sql .= " ORDER BY a.arrange_id DESC ";
            $query = $conn->query($sql);
            $i = 0;
            while ($result = $query->fetch_assoc()) {
                $i++;
                $detail_id = $result['detail_id'];
                $arrange_id = $result['arrange_id'];
                $teacher_id = $result['teacher_id'];
                $detail_tooth = $result['detail_tooth'];
                $detail_surface = $result['detail_surface'];
                $arrange_date = $result['arrange_date'];
                $student_id =  $result['student_id'];
                $arrange_check_eval =  $result['arrange_check_eval'];

                $array_detail_surface = json_decode($detail_surface, true);
                $array_detail_tooth = json_decode($detail_tooth, true);
                //active
                if ($arrange_id == $arrange_id_s) {
                    $active = "active";
                } else {
                    $active = "";
                }
        ?>

            <div class="col-lg-3">
                <div class="info-box card">
                <center>
                    <a href="evaluate_list.php?detail_id=<?php echo $detail_id;?>" class="">
                     
                    <img src="../pic_students/<?php echo $result['student_id']; ?>.jpg" width="120" height="120" style="border-radius:50%;" class="img-circle responsive" alt="<?php echo $result['student_id']; ?>">
                      
     
                      
                        <h3><?php echo $result['student_id']; ?></h3>
                        <B><?php echo $result['student_name']; ?> <?php echo $result['student_lastname']; ?></B>
                        <br>
                                <?php echo $result['form_main_name']; ?>
                                <br>
                                <?php
                                foreach ($array_detail_tooth as $id => $value) {
                                    if (!empty($value)) {
                                        echo '<span class="btn btn-warning rounded-pill btn-sm">' . $value . '</span> ' . " ";
                                    }
                                }
                                foreach ($array_detail_surface as $id => $value) {
                                    if (!empty($value)) {
                                        echo '<span class="btn btn-info rounded-pill btn-sm">' . $value . '</span> ' . " ";
                                    }
                                }
                                if (!empty($detail_root)) {
                                    echo "|";
                                    echo $result['detail_root'];
                                }
                                
                                ?>
                    </a>  

                         
                  
                                <?php
                                
                               // echo $arrange_check_eval;
                                        switch ($arrange_check_eval) { // Harder page
                                            case 0:
                                                echo "<a href='evaluate_list.php?detail_id=$detail_id' target='_blank' class='btn btn-secondary rounded-pill btn-sm'>รอประเมิน </a> ";
                                               //echo " <a href='pdf.php?detail_id=$detail_id' target='_blank' class='btn btn-secondary rounded-pill btn-sm'>รอประเมิน PDF</a> ";
                                                break;
                                            case 1:
                                                echo " <a href='evaluate_list.php?detail_id=$detail_id' target='_blank' class='btn btn-success rounded-pill btn-sm'>ประเมินแล้ว  </a>";
                                               // echo " <a href='pdf.php?detail_id=$detail_id' target='_blank' class='btn btn-success rounded-pill btn-sm'>ประเมินแล้ว PDF </a>";
                                                break;
                                            case 2:
                                                echo " <a href='pdf.php?detail_id=$detail_id' target='_blank' class='btn btn-danger rounded-pill btn-sm'> ไม่ประเมิน </a>";
                                                break;
                                            default:
                                                echo  "";
                                        }
                                ?>

                </center>
                </div>
            </div>
        <?php }
        $conn->close(); ?>
    </div>




    </div>
</section>









<?php include "footer.php"; ?>s