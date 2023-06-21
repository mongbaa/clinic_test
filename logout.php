<?PHP  

			include 'header.php';

	        session_destroy();


			session_start();
			$_SESSION['do'] = 'ออกจากระบบสำเร็จ';


			echo "<script type='text/javascript'>";
			//echo  "alert('ออกจากระบบสำเร็จ');";
		    echo "window.location='index.php'";
			echo "</script>";

?>