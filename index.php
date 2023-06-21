<?php include "header.php";

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
$Login_clinic_test = $_SESSION['Login_clinic_test'];
switch ($Login_clinic_test) { // Harder page
    case 'teacher':
        echo  "<META http-equiv=refresh content=0;url=evaluate.php>";
        break;
    case 'student':
        echo  "<META http-equiv=refresh content=0;url=detail_work.php>";
        break;
    default:
        echo  "";
}
?>

<?php include "footer.php"; ?>




