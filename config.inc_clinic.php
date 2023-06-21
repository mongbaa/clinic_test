<?PHP

$serverName = "localhost";
$userName = "root";
$userPassword = "root2018*mysql";
//$userPassword = "";
$dbName = "db_clinic"; 

date_default_timezone_set('Asia/Bangkok');
 
$conn_clinic = new mysqli($serverName,$userName,$userPassword,$dbName);


mysqli_set_charset($conn_clinic,"utf8");
if ($conn_clinic->connect_errno) {
echo $conn_clinic->connect_error;
exit;
} else {

}
?> 