<?PHP
 session_start();
 include "config.inc.php";
 include "config.inc_hosxp.php";	




					$sql =
						"   SELECT  o.loginname, o.passweb, o.doctorcode,
									d.pname, d.fname, d.lname, d.doctor_type_id
									FROM opduser o
										LEFT JOIN doctor d ON d.code = o.doctorcode
									WHERE  o.loginname = '{$_POST["username"]}'
									
									";
					//$sql .=	" AND d.doctor_type_id NOT IN ('1', '2', '3')  AND o.passweb = '" . md5($_POST["password"]) . "'";
					//$sql .=	"  AND o.passweb = '" . md5($_POST["password"]) . "'";
					
					$query = mysqli_query($conn_hosxp, $sql);
					$rows = mysqli_num_rows($query);
					$result = mysqli_fetch_assoc($query);
					if ($rows > 0) {

						$_SESSION["sessid"] = session_id();
						$_SESSION["doctorcode"] = $result["doctorcode"];
						$_SESSION["loginname"] = $result["loginname"];
						$_SESSION['pname'] = $result["pname"];
						$_SESSION['fname'] = $result["fname"];
						$_SESSION['lname'] = $result["lname"];
						$_SESSION['doctor_type_id'] = $result["doctor_type_id"];

					    $doctor_type_id = $result["doctor_type_id"];
 
						if( $doctor_type_id == 1 || $doctor_type_id == 2 ) {
						
							$_SESSION['Login_clinic_test'] = 'student';

					    } else if ( $doctor_type_id == 3 || $doctor_type_id == 4) { 

							$_SESSION['Login_clinic_test'] = 'teacher';

						}else{  

							$_SESSION['Login_clinic_test'] = 'staff';

						}

					
						$_SESSION['do'] = 'เข้าสู่ระบบสำเร็จ';

						echo "<script language='javascript'>";
						//echo "window.location='index.php' ";
						echo "window.location='check_permission.php' ";
						echo "</script>";
				
					
						
					} else {


						$_SESSION['error'] = 'Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง..!!';

						echo "<script language='javascript'>";
						//echo "alert('Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง..!!');window.location='index.php'";
						echo "window.location='index.php' ";
						echo "</script>";
					}












					