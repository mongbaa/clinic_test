<?php include "header.php"; 


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





<div class="pagetitle">
    <h1>
        <i class="bi bi-unlock-fill"></i> ยินดีต้อนรับ กรุณาเข้าสู่ระบบ
    </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Login</li>
        </ol>
    </nav>
</div><!-- End Page Title -->



<section class="section dashboard">


    <div class="col-lg-12">
        <div class="row justify-content-md-center">

            <div class="col-xxl-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ยินดีต้อนรับ กรุณาเข้าสู่ระบบ โดยใช้  Username และ Password ของ ระบบ Hosxp </h5>



                        <form class="needs-validation" novalidate method="post" action="check_login_m.php" enctype="multipart/form-data">

                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="username" class="form-label"> Username (ระบบ Hosxp) </label>
                                                <input name="username" type="text" class="form-control" placeholder="Username" value="aree.kan"  required>
                                                <div class="invalid-feedback"> กรุณากรอก Username </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label"> Password </label>
                                                <input type="password" name="password" class="form-control" placeholder="Password" value="aree.kan" required>
                                                <div class="invalid-feedback"> กรุณากรอก password </div>
                                            </div>
                                        </div>
                                    
                                            <br>

                                            <br>
                                        <div class="col-sm-12">
                                        <br>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info btn-block">เข้าสู่ระบบ</button>
                                            </div>
                                        </div>
                            
                            
                                    </div>
                        </form>
            

                     </div>

                </div>

            </div>





        </div>
    </div>




</section>



<?php include "footer.php"; ?>