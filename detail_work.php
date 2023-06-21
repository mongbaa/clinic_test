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

    echo " <script>";
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
    <h1>เลือกอนุสาขาวิชา</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div><!-- End Page Title -->




<?php
if (!empty($_GET['type_work_id'])) {
   
    $type_work_id = $_GET['type_work_id'];
    $type_work_name = $_GET['type_work_name'];

    $_SESSION['type_work_id'] = $type_work_id ;
   // $_SESSION['do'] = 'อานุสาขา :'.$type_work_name;

    echo "<script type='text/javascript'>";
    echo "window.location='detail_work_form.php';";
    echo "</script>";

  }
?>







<section class="section dashboard">

    <div class="row">


        <?PHP
        include "config.inc.php";
        $sql = " SELECT * FROM tbl_type_work as tbl_type_work WHERE type_work_status = 1";
        $sql .= " ORDER BY tbl_type_work.type_work_id ASC ";
        $query = $conn->query($sql);
        $i = 0;
        while ($result = $query->fetch_assoc()) {
        $i++;

            $type_work_name = $result['type_work_name'];
            $type_work_status = $result['type_work_status'];
            $type_work_id = $result['type_work_id'];

        ?>

                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card">
                            <div class="filter">
                                <a class="icon" href="?type_work_id=<?php echo $type_work_id;?>&type_work_name=<?php echo $type_work_name;?>"> เลือก </a>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">  อนุสาขา <span>| <?php echo $type_work_name;?> </span> </h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <img src="image/7Pqg.gif" alt="unit_"  class="rounded-circle" width="100%">
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $type_work_name;?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

        <?php } ?>


    </div>
</section>




<?php include "footer.php"; ?>