<div class="card ">
    <div class="card-header bg-danger">
        <h3 class="card-title"> SQL INSERT TABLE</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <?php

        include "config.inc.php";

        if (isset($_POST['edit_id'])  && !empty($_POST['edit_id'])) {
            $edit_id = $conn->real_escape_string($_POST['edit_id']);
        } else {
            $edit_id = 0;
        }

 
        if (isset($_POST['arrange_id'])  && !empty($_POST['arrange_id'])) {
            $arrange_id = $conn->real_escape_string($_POST['arrange_id']);
        } else {
            $arrange_id = 0;
        }


        if (isset($_POST['teacher_id'])  && !empty($_POST['teacher_id'])) {
            $teacher_id = $conn->real_escape_string($_POST['teacher_id']);
        } else {
            $teacher_id = 0;
        }


        if (isset($_POST['detail_id'])  && !empty($_POST['detail_id'])) {
            $detail_id = $conn->real_escape_string($_POST['detail_id']);
        } else {
            $detail_id = 0;
        }


        if (isset($_POST['detail_complete'])  && !empty($_POST['detail_complete'])) {
            $detail_complete = $conn->real_escape_string($_POST['detail_complete']);
        } else {
            $detail_complete = 0;
        }


        if (isset($_POST['student_id'])  && !empty($_POST['student_id'])) {
            $student_id = $conn->real_escape_string($_POST['student_id']);
        } else {
            $student_id = 0;
        }




        if (isset($_POST['tbl'])  && !empty($_POST['tbl'])) {
            $tbl = 'tbl_' . $conn->real_escape_string($_POST['tbl']);
            $tbl_id = 'id';
        } else {
            $tbl = '';
            $tbl_id = '';
        }



        if (isset($_POST['arrange_date'])  && !empty($_POST['arrange_date'])) {
            $datee = $conn->real_escape_string($_POST['arrange_date']);
        } else {
            $datee = '0000-00-00 00:00:00:00';
        }


        if (isset($_POST['comment'])  && !empty($_POST['comment'])) {
            $comment = $conn->real_escape_string($_POST['comment']);
        } else {
            $comment = '';
        }






        if (isset($_POST['last_date'])  && !empty($_POST['last_date'])) {
            $last_date = $conn->real_escape_string($_POST['last_date']);
        } else {
            $last_date = '';
        }


        if (isset($_POST['time_start'])  && !empty($_POST['time_start'])) {
            $time_start = $conn->real_escape_string($_POST['time_start']);
        } else {
            $time_start = date('H:i:s');
        }


        if (isset($_POST['time_end'])  && !empty($_POST['time_end'])) {
            $time_end = $conn->real_escape_string($_POST['time_end']);
        } else {
            $time_end = date('H:i:s');
        }

        // $comment = str_replace("\r\n", "", $comment);


        $name_table = substr($tbl, 4);

        
  

        if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง

        
        // for ($x = 1; $x <= 4; $x++) {
        //     if (isset($_POST["count{$x}"])  && !empty($_POST["count{$x}"])) {
        //         $count[$x] = $conn->real_escape_string($_POST["count{$x}"]);
        //     } else {
        //         $count[$x] = '';
        //     }

        //     if (isset($_POST["last_date{$x}"])  && !empty($_POST["last_date{$x}"])) {
        //         $last_date[$x] = $conn->real_escape_string($_POST["last_date{$x}"]);
        //     } else {
        //         $last_date[$x] = '0000-00-00';
        //     }

        //     // if (isset($_POST["time_start{$x}"])  && !empty($_POST["time_start{$x}"])) {
        //     //   echo  $time_start[$x] = $_POST["time_start{$x}"];
        //     // } else {
        //     //   echo   $time_start[$x] = '00:00:00'; //'00:00:00';
        //     // }

        //     if (isset($_POST["time_end{$x}"])  && !empty($_POST["time_end{$x}"])) {
        //         $time_end[$x] = $_POST["time_end{$x}"];
        //     } else {
        //         $time_end[$x] = '00:00:00'; // '00:00:00';
        //     }
        // }


        if (isset($_POST["count1"]) && !empty($_POST["count1"])) { $count1 = $_POST["count1"]; } else { $count1 = '1';  }
        if (isset($_POST["last_date1"]) && !empty($_POST["last_date1"])) { $last_date1 = $_POST["last_date1"]; } else { $last_date1 = '0000-00-00';  }
        if (isset($_POST["time_start1"]) && !empty($_POST["time_start1"])) { $time_start1 = $_POST["time_start1"]; } else { $time_start1 = '00:00:00';  }
        if (isset($_POST["time_end1"])   && !empty($_POST["time_end1"])) {   $time_end1   = $_POST["time_end1"];   } else { $time_end1 = '00:00:00';  }

        if (isset($_POST["count2"]) && !empty($_POST["count2"])) { $count2 = $_POST["count2"]; } else { $count2 = '2'; }
        if (isset($_POST["last_date2"]) && !empty($_POST["last_date2"])) { $last_date2 = $_POST["last_date2"]; } else { $last_date2 = '0000-00-00'; }
        if (isset($_POST["time_start2"]) && !empty($_POST["time_start2"])) { $time_start2 = $_POST["time_start2"]; } else { $time_start2 = '00:00:00'; }
        if (isset($_POST["time_end2"]) && !empty($_POST["time_end2"])) { $time_end2 = $_POST["time_end2"]; } else { $time_end2 = '00:00:00'; }
    
        if (isset($_POST["count3"]) && !empty($_POST["count3"])) { $count3 = $_POST["count3"]; } else { $count3 = '3'; }
        if (isset($_POST["last_date3"]) && !empty($_POST["last_date3"])) { $last_date3 = $_POST["last_date3"]; } else { $last_date3 = '0000-00-00'; }
        if (isset($_POST["time_start3"]) && !empty($_POST["time_start3"])) { $time_start3 = $_POST["time_start3"]; } else { $time_start3 = '00:00:00'; }
        if (isset($_POST["time_end3"]) && !empty($_POST["time_end3"])) { $time_end3 = $_POST["time_end3"]; } else { $time_end3 = '00:00:00'; }

        if (isset($_POST["count4"]) && !empty($_POST["count4"])) { $count4 = $_POST["count4"]; } else { $count4 = '4'; }
        if (isset($_POST["last_date4"]) && !empty($_POST["last_date4"])) { $last_date4 = $_POST["last_date4"]; } else { $last_date4 = '0000-00-00'; }
        if (isset($_POST["time_start4"]) && !empty($_POST["time_start4"])) { $time_start4 = $_POST["time_start4"]; } else { $time_start4 = '00:00:00'; }
        if (isset($_POST["time_end4"]) && !empty($_POST["time_end4"])) { $time_end4 = $_POST["time_end4"]; } else { $time_end4 = '00:00:00'; }




        } else {

            $last_date = $datee;
        }


        $last_time = date('a');
        $time = date('H:i:s');




        if (!empty($edit_id)) {

            $user = $_SESSION['Login_clinic_test'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $log  = ",edit|" . date('Y-m-d H:s:i') . "|" . $ip . "|$user/";

            $sql_up = " UPDATE $tbl SET ";


            foreach ($form_detail_array as $values => $data) {

                $field_name = $data['field_name'];
                $field_name_grade  = $field_name . "_grade";
                $field_name_grade_s  = $field_name . "_grade_s";

                $field_name_date  = $field_name . "_date";
                $field_name_teacher  = $field_name . "_teacher";

                if (isset($_POST["{$field_name_grade}"])) {

                    $grade = $conn->real_escape_string($_POST["{$field_name_grade}"]);
                    $grade_s = $conn->real_escape_string($_POST["{$field_name_grade_s}"]);


                    if ($grade != $grade_s) {

                        $sql_up .= " $field_name_grade = '$grade', $field_name_teacher = '$teacher_id', $field_name_date = '$datee $time',  ";
                    }

                    if ($grade == '') {

                        $sql_up .= " $field_name_grade = '', $field_name_teacher = '', $field_name_date = '',  ";
                    }
                } else {
                }
            }

            $sql_up .= " comment = '$comment', ";


            if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง


                // for ($x = 1; $x <= 4; $x++) {

                //     $sql_up .= " count{$x} = '$count[$x]', ";
                //     $sql_up .= " last_date{$x} = '$last_date[$x]', ";

                //     if ($time_start[$x] == '00:00:00') {
                //         $sql_up .= " time_start{$x} = NULL, ";
                //     } else {
                //         $sql_up .= " time_start{$x} = '$time_start[$x]', ";
                //     }

                //     if ($time_end[$x] == '00:00:00') {
                //         $sql_up .= " time_end{$x} = NULL, ";
                //     } else {
                //         $sql_up .= " time_end{$x} = '$time_end[$x]', ";
                //     }
                // }



                $sql_up .= " count1 = '$count1', ";
                $sql_up .= " last_date1 = '$last_date1', ";
                if ($time_start1 == '00:00:00') { $sql_up .= " time_start1 = NULL, "; } else {  $sql_up .= " time_start1 = '$time_start1', "; }
                if ($time_end1   == '00:00:00') { $sql_up .= " time_end1   = NULL, "; } else {  $sql_up .= " time_end1   = '$time_end1', "; }  
                
                $sql_up .= " count2 = '$count2', ";
                $sql_up .= " last_date2 = '$last_date2', ";
                if ($time_start2 == '00:00:00') { $sql_up .= " time_start2 = NULL, "; } else { $sql_up .= " time_start2 = '$time_start2', "; }
                if ($time_end2 == '00:00:00') { $sql_up .= " time_end2 = NULL, "; } else { $sql_up .= " time_end2 = '$time_end2', "; }
                   
                $sql_up .= " count3 = '$count3', ";
                $sql_up .= " last_date3 = '$last_date3', ";
                if ($time_start3 == '00:00:00') { $sql_up .= " time_start3 = NULL, "; } else { $sql_up .= " time_start3 = '$time_start3', "; }
                if ($time_end3 == '00:00:00') { $sql_up .= " time_end3 = NULL, "; } else { $sql_up .= " time_end3 = '$time_end3', "; }
        
                $sql_up .= " count4 = '$count4', ";
                $sql_up .= " last_date4 = '$last_date4', ";
                if ($time_start4 == '00:00:00') { $sql_up .= " time_start4 = NULL, "; } else { $sql_up .= " time_start4 = '$time_start4', "; }
                if ($time_end4 == '00:00:00') { $sql_up .= " time_end4 = NULL, "; } else { $sql_up .= " time_end4 = '$time_end4', "; }



            } else {


                $sql_up .= " 	last_date = '$last_date', time_start = '$time_start',  time_end = '$time_end', ";
            }


            $sql_up .= " 	 log = replace(log, '/','$log') WHERE  $tbl_id = '$edit_id'  ";

            echo $sql =  $sql_up;


            $_SESSION['do'] = 'แก้ไขข้อมูลสำเร็จ';
        } else {








            $user = $_SESSION['Login_clinic_test'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $log  = "in|" . date('Y-m-d H:s:i') . "|" . $ip . "|$user/";

            $sql_in = " INSERT INTO $tbl ( id , arrange_id, student_id, detail_id, ";

            foreach ($form_detail_array as $values => $data) {
                $field_name = $data['field_name'];

                $sql_in .= "  {$field_name}_grade, {$field_name}_teacher, {$field_name}_date, ";
            }


            $sql_in .= " comment, ";
            if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง


                for ($x = 1; $x <= 4; $x++) {

                    $sql_in .= " count{$x},";
                    $sql_in .= " last_date{$x}, time_start{$x}, time_end{$x}, ";
                }
            } else {

                $sql_in .= " last_date, time_start, time_end, ";
            }
            $sql_in .= "  log ) VALUES ( NULL, '$arrange_id', '$student_id', '$detail_id', ";



            foreach ($form_detail_array as $values => $data) {
                $field_name = $data['field_name'];
                $field_name_grade  = $field_name . "_grade";

                if (isset($_POST["{$field_name_grade}"])) {

                    $grade = $conn->real_escape_string($_POST["{$field_name_grade}"]);

                    if ($grade != '') {
                        $sql_in .= "  '$grade', '$teacher_id', '$datee $time', ";
                    } else {
                        $sql_in .= "  '',  '0', '0000-00-00 00:00:00:00', ";
                    }
                } else {

                    $grade = '';
                    $sql_in .= "  '$grade',  '0', '0000-00-00 00:00:00:00', ";
                }
            }

            $sql_in .= " '$comment', ";

            if (in_array('ct', $array_form_main_detail)) { //// นับครั้ง


                // for ($x = 1; $x <= 4; $x++) {

                //     $sql_in .= " '$count[$x]',";


                //     $sql_in .= " '$last_date[$x]',   ";


                //     if ($time_start[$x] == '00:00:00') {
                //         $sql_in .= " NULL,   ";
                //     } else {
                //         $sql_in .= " '$time_start[$x]',   ";
                //     }

                //     if ($time_end[$x] == '00:00:00') {
                //         $sql_in .= " NULL,   ";
                //     } else {
                //         $sql_in .= " '$time_end[$x]',   ";
                //     }
                // }


                $sql_in .= " '$count1',";
                $sql_in .= " '$last_date1',   ";
                if ($time_start1 == '00:00:00') { $sql_in .= " NULL, ";  } else { $sql_in .= " '$time_start1',   "; }
                if ($time_end1   == '00:00:00') { $sql_in .= " NULL, ";    } else { $sql_in .= " '$time_end1',   "; }
                   
                        
                $sql_in .= " '$count2',";
                $sql_in .= " '$last_date2',   ";
                if ($time_start2 == '00:00:00') { $sql_in .= " NULL, ";  } else { $sql_in .= " '$time_start2',   "; }
                if ($time_end2   == '00:00:00') { $sql_in .= " NULL, ";    } else { $sql_in .= " '$time_end2',   "; }
                   
                $sql_in .= " '$count3',";
                $sql_in .= " '$last_date3',   ";
                if ($time_start3 == '00:00:00') { $sql_in .= " NULL, ";  } else { $sql_in .= " '$time_start3',   "; }
                if ($time_end3   == '00:00:00') { $sql_in .= " NULL, ";    } else { $sql_in .= " '$time_end3',   "; }

                $sql_in .= " '$count4',";
                $sql_in .= " '$last_date4',   ";
                if ($time_start4 == '00:00:00') { $sql_in .= " NULL, ";  } else { $sql_in .= " '$time_start4',   "; }
                if ($time_end4   == '00:00:00') { $sql_in .= " NULL, ";    } else { $sql_in .= " '$time_end4',   "; }




            } else {

                $sql_in .= "  '$last_date', '$time_start', '$time_end',  ";
            }



            $sql_in .= "   '$log') ";
            $sql =  $sql_in;
            $_SESSION['do'] = 'บันทึกข้อมูลสำเร็จ';
        }

        echo $sql;
        $conn->query($sql);

        echo "<br>";


        $arrange_check_date_eval = date('Y-m-d');
        $sql_up_arr = "UPDATE tbl_arrange SET arrange_check_eval = '1', arrange_check_date_eval = '$arrange_check_date_eval' WHERE tbl_arrange.arrange_id = $arrange_id";
        $conn->query($sql_up_arr);



        $sql_up_detail = "UPDATE tbl_detail SET detail_complete = '$detail_complete' WHERE tbl_detail.detail_id = $detail_id";
        $conn->query($sql_up_detail);




        $conn->close();








        //////////////////////////////////////////   ข้อมูล Conduct & Knowledge สาขาวิชา 	/////////////////////////////////////////////////////////////////////////
        if (isset($_POST['ck'])) {



            include "config.inc_clinic.php";

            foreach ($_POST as $key => $value) {
                $_POST[$key] = $conn_clinic->real_escape_string($value);
            }


            $ck_date = $_POST['ck_date'];
            $ck_time = date('H:i:s');
            $ck_time_type = $_POST['ck_time_type'];

            $teacher_id = $teacher_id;
            $student_id = $student_id;
            $type_work_id = $type_work_id;
            $detail_id = $detail_id;



            //////////////////////////////////////////  UPDATE 
            if (isset($_POST['ck_id']) && !empty($_POST['ck_id'])) {

                $ck_id = $_POST['ck_id'];

                $row_ck_id =  "ck_" . $type_work_id . "_id";



                $sql_up_ck = "UPDATE tbl_ck_$type_work_id SET  ";

                $sql_ck   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
                $sql_ck  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
                $sql_ck  .=  " ORDER BY c.form_conduct_knowledge_order ASC ";
                $query_ck = $conn_clinic->query($sql_ck);
                while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

                    $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                    $field_  = $_POST["{$field}"];
                    $sql_up_ck .= " $field = '$field_', ";
                }

                $sql_up_ck = substr("$sql_up_ck", 0, -2); // ตัด , ตัวสุดท้ายออก
                $sql_up_ck .= " WHERE $row_ck_id = $ck_id";
                $conn_clinic->query($sql_up_ck);
            } else {

                $sql_in_ck = "INSERT INTO tbl_ck_$type_work_id( ck_" . $type_work_id . "_id , teacher_id, student_id, detail_id, ck_date, ck_time, ck_time_type, ";

                $sql_ck   =  " SELECT * FROM (SELECT * FROM tbl_form_conduct_knowledge where type_work_id = $type_work_id) as c ";
                $sql_ck  .=  " LEFT JOIN  tbl_type_work  AS t  ON  t.type_work_id = c.type_work_id ";
                $sql_ck  .=  " ORDER BY c.form_conduct_knowledge_id ASC ";
                $query_ck = $conn_clinic->query($sql_ck);
                $sql_in_ck1 = "";
                while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {
                    $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                    // $field_  = $_POST["{$field}"];
                    $sql_in_ck1 .=  $field . ", ";
                }
                $sql_in_ck2  = substr($sql_in_ck1, 0, -2); //ตัด , ตัวสุดท้ายออก

                $sql_in_ck .= $sql_in_ck2 . ") VALUES (NULL, '{$teacher_id}' , '{$student_id}' ,'{$detail_id}' ,'{$ck_date}' ,'{$ck_time}' ,'{$ck_time_type}' ,";
                $query_ck = $conn_clinic->query($sql_ck);
                $sql_in_ck3 = "";
                while ($row_conduct_knowledge = $query_ck->fetch_assoc()) {

                    $field = $row_conduct_knowledge['form_conduct_knowledge_field'];
                    $field_  = $_POST["{$field}"];
                    $sql_in_ck3 .=  " '{$field_}' , ";
                }
                $sql_in_ck4  = substr($sql_in_ck3, 0, -2); //ตัด , ตัวสุดท้ายออก
                $sql_in_ck .= $sql_in_ck4 . " )";

                $sql_in_ck .= " ";
                $conn_clinic->query($sql_in_ck);
            }

            $conn_clinic->close();
        }
        //////////////////////////////////////////   ข้อมูล Conduct & Knowledge สาขาวิชา 	/////////////////////////////////////////////////////////////////////////





        echo "<script type='text/javascript'>";
        //echo "alert('[บันทึกข้อมูสำเร็จ]');";
        echo "window.location='evaluate_list.php?detail_id=$detail_id';";
        echo "</script>";



        ?>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->