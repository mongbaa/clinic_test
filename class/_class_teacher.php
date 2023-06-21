<?php 
   include "config.inc_clinic.php";

    class nameTeacher {
        private static $conn_clinic;
        private static $memo = [];

        public function __construct($conn_clinic) {
            static::$conn_clinic = $conn_clinic;
        }
    
        public static function get_teacher_name($teacherID)
        {  


            if (is_null(static::$conn_clinic)) {
                static::$conn_clinic = $GLOBALS['conn_clinic'];
            }

            // guard
            if (empty($teacherID)) { return ""; }

            // check memo
            if (array_key_exists($teacherID, static::$memo)) {
                return static::$memo[$teacherID];
            }
       

            // query
            $sql_t   =  " SELECT * FROM tbl_teacher where teacher_id IN ('{$teacherID}') ";
            $query_t = static::$conn_clinic->query($sql_t);
            $result_t = $query_t->fetch_assoc();

             $teacher_name = "อ.".$result_t["teacher_name"] . " " . $result_t["teacher_surname"];
            // memo
            static::$memo[$teacherID] = $teacher_name;

            // return
            return $teacher_name;

        }
    }

    
?>
