<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

//กรณีต้องการเก็บ log file
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

// เริ่มต้นการใช้งาน แทรกส่วนนี้ไว้ตอนต้นๆของเพจ ก่อนการประมวลผล
include('class/class_Timer.php');
$bm = new Timer; // เรียกใช้งาน class
$bm->start(); // เริ่มต้นจับเวลา



//$_SESSION['session_clinic_test'] = 1;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> ระบบใบประเมินการสอบปฏิบัติ 9 งาน </title>
    <meta content="ระบบใบประเมินการสอบปฏิบัติ 9 งาน (สำหรับนักศึกษาทันตแพทยศาสตร์ มหาวิทยาลัยสงขลานครินทร์ ระดับปริญญาตรี)" name="description">
    <meta content="ระบบใบประเมินการสอบปฏิบัติ 9 งาน (สำหรับนักศึกษาทันตแพทยศาสตร์ มหาวิทยาลัยสงขลานครินทร์ ระดับปริญญาตรี)" name="keywords">

    <!-- Favicons -->
    <link href="image/logoo.jpg" rel="icon">
    <link href="image/logoo.jpg" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <!-- 
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  -->
    <!-- 
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href='https://fonts.googleapis.com/css?family=Kanit' rel='stylesheet'>
 -->


    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- Select2 -->
    <link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- fullCalendar -->
    <link href="assets/vendor/fullcalendar/main.css" rel="stylesheet">

    <style>
        .select2 {
            width: 100% !important;
        }

        .select2-container .select2-selection {
            height: 40px;
        }
    </style>


    <!-- sweetalert2 JS File -->
    <link rel="stylesheet" href="assets/vendor/sweetalert2/sweetalert2.min.css">
    <script src="assets/vendor/sweetalert2/sweetalert2.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/vendor/datatables-buttons/css/buttons.bootstrap4.min.css">



    <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->


    <script>
        function myHide() {
            document.getElementById('hidepage').style.display = 'block'; //content ที่ต้องการแสดงหลังจากเพจโหลดเสร็จ
            document.getElementById('hidepage2').style.display = 'none'; //content ที่ต้องการแสดงระหว่างโหลดเพจ
        }
    </script>
</head>



<style>
    body {
        font-family: 'Kanit', sans-serif !important;
        background-image: url("image/6057300.png");
        background-color: #fff;
        /* Used if the image is unavailable */
        height: 900px;
        /* You must set a specified height */
        background-position: center;
        /* Center the image */
        /*background-repeat: no-repeat;  Do not repeat the image */
        background-size: cover;
        /* Resize the background image to cover the entire container */
    }
</style>


<style>
    .gradiant-bg {
        font-size: 20px;
        font-weight: bold;
        background: linear-gradient(45deg, #012a4a, #013a63, #01497c, #014f86, #00b4d8);
        background-size: 40%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 5s infinite;
    }

    .gradiant2-bg {
        font-size: 20px;
        font-weight: bold;
        background: linear-gradient(45deg, #03045e, #023e8a, #0077b6, #0096c7, #00b4d8);
        background-size: 90%;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 5s infinite;
    }

    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 100% 50%;
        }
    }
</style>


<style>
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: rgb(255 255 255 / 80%);
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 2rem;
        box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
    }
</style>


<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="logo d-flex align-items-center">
                <img src="image/logoo.jpg" alt="">
                <span class="d-none d-lg-block"> ศ.ป.ท. </span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <B>
                <div class="gradiant-bg"> ระบบใบประเมินการสอบปฏิบัติ 9 งาน (สำหรับนักศึกษาทันตแพทยศาสตร์ ระดับปริญญาตรี)
                </div>
            </B>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class=' ri-window-2-fill'></i>
                    </a>
                </li><!-- End Search Icon-->

                <?php
                if (isset($_SESSION['Login_clinic_test'])) {
                    if (isset($_SESSION['Login_clinic_test'])) {
                        $user_name = $_SESSION["pname"] . "" . $_SESSION["fname"] . " " . $_SESSION["lname"];
                        $user_level = $_SESSION["doctor_type_id"];
                        $loginname = $_SESSION["loginname"];
                    } else {
                        $user_name = "";
                        $user_level = "";
                        $loginname = "";
                    }
                ?>

                    <li class="nav-item dropdown pe-3">
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <?php if ($user_level == 1) { ?>
                                <img src="../pic_students/<?php echo $loginname; ?>.jpg" alt="<?php echo $loginname; ?>" class="rounded-circle">
                            <?php } else { ?>
                                <img src="image/7Pqg.gif" alt="Profile" class="rounded-circle">
                            <?php } ?>
                            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user_name; ?></span>
                        </a><!-- End Profile Iamge Icon -->
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6><?php echo $loginname; ?></h6>
                                <span><?php echo $user_name; ?></span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>
                        </ul><!-- End Profile Dropdown items -->
                    </li><!-- End Profile Nav -->
            </ul>
        </nav><!-- End Icons Navigation -->

    <?php } ?>



    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">


        <?php if (isset($_SESSION['Login_clinic_test'])) { ?>

            <?php
            if (isset($_SESSION['Login_clinic_test'])) {
                $user_name = $_SESSION["pname"] . "" . $_SESSION["fname"] . " " . $_SESSION["lname"];
                $doctor_type_id = $_SESSION["doctor_type_id"];
                $loginname = $_SESSION["loginname"];
                $Login_clinic_test = $_SESSION['Login_clinic_test'];
            } else {
                $user_name = "";
                $doctor_type_id = "";
                $loginname = "";
                $Login_clinic_test = '';
            }
            ?>

            <!-- Sidebar user (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3">
                <center>

                    <h1>
                        <?php if ($Login_clinic_test == 'student') { ?>
                            <img src="https://sys.dent.psu.ac.th/estudent/pic_students/<?php echo $loginname; ?>.jpg" width="120" height="120" alt="<?php echo $loginname; ?>" class="rounded-circle">
                        <?php } else { ?>
                            <img src="image/logoo.jpg" alt="" width="120" height="120" style="border-radius:50%;" class="img-circle">
                        <?php } ?>
                    </h1>

                </center>

                <center>
                    <?php echo $loginname; ?>
                    <div class="gradiant2-bg">
                        <a href="#" class="d-block"><?php echo $user_name; ?> </a>
                    </div>
                </center>
            </div>
        <?php } ?>

        <hr>

        <ul class="sidebar-nav" id="sidebar-nav">

            <?php if (isset($_SESSION['Login_clinic_test'])) {
                $user_name = $_SESSION["pname"] . "" . $_SESSION["fname"] . " " . $_SESSION["lname"];
                $user_level = $_SESSION["doctor_type_id"];
                $loginname = $_SESSION["loginname"];
            ?>


                <li class="nav-item">
                    <a class="nav-link " href="index.php">
                        <i class="bx bxs-tachometer"></i>
                        <span>หน้าหลัก</span>
                    </a>
                </li><!-- End Dashboard Nav -->

                <?php if ($_SESSION['Login_clinic_test'] == 'student') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="detail_work.php">
                            <i class="bx bxl-telegram"></i>
                            <span>ส่งใบงานสอบ</span>
                        </a>
                    </li>
                <?PHP } ?>


                <?php if ($_SESSION['Login_clinic_test'] == 'teacher') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="evaluate.php">
                            <i class="bx bxl-unsplash"></i>
                            <span>ประเมินการสอบ</span>
                        </a>
                    </li>
                <?PHP } ?>



                <?php if ($loginname == 'mongkol.th') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="detail_work.php">
                            <i class="bx bxl-telegram"></i>
                            <span>ส่งใบงานสอบ</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="evaluate.php">
                            <i class="bx bxl-unsplash"></i>
                            <span>ประเมินการสอบ</span>
                        </a>
                    </li>

                    <hr>

                    <li class="nav-item">
                        <a class="nav-link " href="form_main.php">
                            <i class="bx bxl-microsoft-teams"></i>
                            <span>สร้างใบงานสอบ</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link " href="type_work.php">
                            <i class="bx bxl-python"></i>
                            <span>อนุสาขาวิชา</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link " href="report.php">
                            <i class="bx bxs-file"></i>
                            <span>รายงาน</span>
                        </a>
                    </li>

                <?PHP } ?>





                <li class="nav-item">
                    <a class="nav-link " href="logout.php">
                        <i class="bi bi-lock"></i>
                        <span>ออกจากระบบ</span>
                    </a>
                </li>

            <?php } else { ?>

                <li class="nav-item">
                    <a class="nav-link " href="login.php">
                        <i class="bi bi-unlock-fill"></i>
                        <span>เข้าระบบ</span>
                    </a>
                </li>

            <?php } ?>


        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
