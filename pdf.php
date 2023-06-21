<?php
$detail_id = (!empty($_GET['detail_id'])) ?  $_GET['detail_id'] : 0;


include "config.inc.php";
$sql = " SELECT * FROM db_clinic_test.tbl_arrange as a ";
$sql .= " INNER JOIN db_clinic_test.tbl_detail    as d on a.detail_id     = d.detail_id ";
$sql .= " INNER JOIN db_clinic_test.tbl_form_main as f on d.form_main_id  = f.form_main_id ";
$sql .= " INNER JOIN db_clinic.tbl_teacher as t on a.teacher_id  = t.teacher_id ";
$sql .= " INNER JOIN db_clinic.tbl_student as s on d.student_id  = s.student_id ";
$sql .= " where  a.detail_id = $detail_id ";
$sql .= " ORDER BY a.arrange_id DESC ";
$query = $conn->query($sql);
$result = $query->fetch_assoc();

    $detail_id = $result['detail_id'];
    $arrange_id = $result['arrange_id'];
    $teacher_id = $result['teacher_id'];
    $student_id = $result['student_id'];
    $detail_tooth = $result['detail_tooth'];
    $detail_surface = $result['detail_surface'];
    $array_detail_surface = json_decode($detail_surface, true);
    $array_detail_tooth = json_decode($detail_tooth, true);

    $arrange_date = $result['arrange_date'];
    $form_main_id = $result['form_main_id'];


$sql_form_main  = " SELECT * FROM tbl_form_main as fm ";
$sql_form_main  .= " INNER JOIN  tbl_type_work AS tw  on fm.type_work_id = tw.type_work_id ";
$sql_form_main  .= " WHERE fm.form_main_id = '$form_main_id' ";
$sql_form_main  .= " ORDER BY fm.form_main_id ASC ";
$query_form_main  = $conn->query($sql_form_main);
$result_form_main  = $query_form_main->fetch_assoc();

    $type_work_id = $result_form_main['type_work_id'];
    $form_main_name = $result_form_main['form_main_name'];
    $form_main_status = $result_form_main['form_main_status'];

    $form_main_detail = $result_form_main['form_main_detail'];
    $array_form_main_detail = json_decode($form_main_detail, true);

    $form_main_detail_step = $result_form_main['form_main_detail_step'];
    $array_form_main_detail_step = json_decode($form_main_detail_step, true);

    $form_main_confirm = $result_form_main['form_main_confirm'];
    $tbl = $result_form_main['form_main_table'];


    $sql_check_ = " SELECT * FROM tbl_{$tbl} ";
    $sql_check_ .= " WHERE  detail_id = $detail_id ";
    $query_check_ = $conn->query($sql_check_);

        if ($result_check_ = $query_check_->fetch_assoc()) {

            $edit_id = $result_check_["id"];
            $edit_comment = $result_check_['comment'];
            if (in_array('ct', $array_form_main_detail)) {
                for ($x = 1; $x <= 4; $x++) {
                    $edit_count[$x] = $result_check_["count{$x}"];
                    $edit_last_date[$x] = $result_check_["last_date{$x}"];
                    $edit_time_start[$x] = $result_check_["time_start{$x}"];
                    $edit_time_end[$x] = $result_check_["time_end{$x}"];
                }
            } else {
                $edit_last_date = $result_check_['last_date'];
                $edit_time_start = $result_check_['time_start'];
                $edit_time_end = $result_check_['time_end'];
            }

        } else {

            $edit_id = '';
            $edit_comment = '';
            if (in_array('ct', $array_form_main_detail)) {

                for ($x = 1; $x <= 4; $x++) {
                    $edit_count[$x] = $x;
                    if ($x == 1) {
                        $edit_last_date[$x] = $arrange_date;
                    } else {
                        $edit_last_date[$x] = '';
                    }
                    $edit_time_start[$x] = '';
                    $edit_time_end[$x] = '';
                }
            } else {
                $edit_last_date = $arrange_date;
                $edit_time_start = '';
                $edit_time_end = '';
            }

        }

$date      = date_create($edit_last_date);
$last_date = date_format($date,"d-m-Y");


if (in_array('W', $array_form_main_detail_step)) {
    $w = 1;
} else {
    $w = 0;
}
if (in_array('F', $array_form_main_detail_step)) {
    $f = 1;
} else {
    $f = 0;
}
$col = 3 + $w + $f;


$html = '
<style type="text/css">
u {    
    border-bottom: 1px dotted #000;
    text-decoration: none;
}
</style>';


$html .= ' <div style="text-align: center;"><img style="vertical-align: top" src="image/logoo.jpg" width="15%" /></div>';
$html .= ' <div style="text-align: center;font-size:22px;"><B> ใบประเมินการปฏิบัติงาน '. $form_main_name .'</B></div>';


// Paragraph 1 top: 35mm;
$html .= '<div style=" font-size:18px; position: fixed; left:0 mm; top: 35mm; ">';
$html .= ' วันที่ ________________________';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:10 mm; top: 35mm; ">';
$html .= $last_date;
$html .= '</div>';



$html .= '<div style=" font-size:18px; position: fixed; left:50 mm; top: 35mm;">';
$html .= ' เวลาเริ่มการประเมิน __________________ ';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:85mm; top: 35mm; ">';
$html .= $edit_time_start;
$html .= '</div>';



$html .= '<div style=" font-size:18px; position: fixed; left:110 mm; top: 35mm;">';
$html .= ' เวลายุติการประเมิน ___________________ ';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:140 mm; top: 35mm;">';
$html .=  $edit_time_end;
$html .= '</div>';






// Paragraph 2 top: 43mm;
$html .= '<div style=" font-size:18px; position: fixed; left:0 mm; top: 43mm;">';
$html .= ' ชื่อ - สกุลผู้ขอรับการประเมิน ______________________________________ ';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:40 mm; top: 43mm;">';
$html .=  $result['student_name'].' '.$result['student_lastname'];
$html .= '</div>';


$html .= '<div style=" font-size:18px; position: fixed; left:110 mm; top: 43mm;">';
$html .= ' เลขที่ ______________________________ ';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:130 mm; top: 43mm;">';
$html .=  $result['student_id'];
$html .= '</div>';


// Paragraph 3 top: 51mm;
$html .= '<div style=" font-size:18px; position: fixed; left:0 mm; top: 51mm;">';
$html .= ' ชื่อ - สกุลผู้ป่วย _________________________________';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:40 mm; top: 51mm;">';
$html .=  $result['patient_titel'].' '.$result['patient_name'].' '.$result['patient_lastname'];
$html .= '</div>';


$html .= '<div style=" font-size:18px; position: fixed; left:76 mm; top: 51mm;">';
$html .= ' เลขที่บัตร ___________';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:90 mm; top: 51mm;">';
$html .=  $result['HN'];
$html .= '</div>';


$html .= '<div style=" font-size:18px; position: fixed; left:110 mm; top: 51mm;">';
$html .= ' ฟันซี่ _____________';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:120 mm; top: 51mm;">';
$html .=  '_'.$array_detail_tooth[0].'_';
$html .= '</div>';



$html .= '<div style=" font-size:18px; position: fixed; left:140 mm; top: 51mm;">';
$html .= ' ด้าน _____________';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:150 mm; top: 51mm;">';
foreach ($array_detail_surface as $id => $value) {
    if (!empty($value)) {
        $surface .= $value;
    }
}
$html .=  ''.$array_detail_surface[0].'_'.$array_detail_surface[1].'';
$html .= '</div>';



$html .= '<div style=" font-size:18px; position: fixed; left:65 mm; top: 243mm;">';
$html .= ' _________________________(ลายเซ็นอาจารย์)';
$html .= '</div>';
$html .= '<div style=" font-size:18px; position: fixed; left:72 mm; top: 250mm;">';
$html .=  'อ.' . $result['teacher_name'] . ' ' . $result['teacher_surname'];
$html .= '</div>';





$html .= '<br><br><br><br><br>';


$html .= '<table width="100%" height="50px"; style="border-collapse: collapse;font-size:14pt;margin-top:10px;border:1px solid #00000;" > ';


$html .= '<thead>';
$html .= '<tr>';
$html .= '<th style="text-align:left;font-size::14px;border:1px solid #00000;">ลำดับ</th>';
$html .= '<th style="text-align:left;font-size::14px;border:1px solid #00000;">ขั้นตอนการประเมิน</th>';
$html .= '<th style="text-align:center;font-size::14px;border:1px solid #00000;">น้ำหนัก</th>';
$html .= '<th style="text-align:center;font-size::14px;border:1px solid #00000;">คะแนนเต็ม</th>';
$html .= '<th style="text-align:center;font-size::14px;border:1px solid #00000;">คะแนน</th>';
$html .= '</tr>';
$html .= '</thead>';


if (in_array('G', $array_form_main_detail_step)) {  //เพิ่ม แบ่งหัวข้อรายการประเมิน 
    
      

            $sql_group = " SELECT * FROM tbl_form_group as fg ";
            $sql_group .= " WHERE fg.form_main_id = '$form_main_id' ";
            $sql_group .= " ORDER BY fg.form_group_order ASC ";
            $query_group = $conn->query($sql_group);
            while ($result_group = $query_group->fetch_assoc()) {

                $form_group_id      = $result_group['form_group_id'];
                $form_main_id       = $result_group['form_main_id'];
                $form_group_order   = $result_group['form_group_order'];
                $form_group_name    = $result_group['form_group_name'];

                $html .= '<thead>';
                $html .= '<tr>';
                $html .= '<td style=" text-align:left; font-size::16px; border:1px solid #00000;" colspan="'.$col.'"> '.$form_group_order.'.'.$form_group_name.'</td>';
                $html .= '</tr>';

                    $sql_detail = " SELECT * FROM tbl_form_detail as fd ";
                    $sql_detail .= " WHERE form_main_id = '$form_main_id' and  form_group_id = $form_group_id";
                    $sql_detail .= " ORDER BY fd.form_detail_order ASC ";
                    $query_detail = $conn->query($sql_detail);
                    while ($result_detail = $query_detail->fetch_assoc()) {

                        $form_detail_id          = $result_detail['form_detail_id'];
                        $form_detail_order       = $result_detail['form_detail_order'];
                        $form_main_id            = $result_detail['form_main_id'];
                        $form_detail_name        = $result_detail['form_detail_name'];
                        $form_detail_weight      = $result_detail['form_detail_weight'];
                        $form_detail_score       = $result_detail['form_detail_score'];
                        $form_detail_score_full  = $result_detail['form_detail_score_full'];
                        $form_detail_field       = $result_detail['form_detail_field'];
                        $field_name              = $result_detail['form_detail_field'];


                        if (isset($result_check_["{$field_name}_grade"])) {
                            $grade =  $result_check_["{$field_name}_grade"];
                        }else{
                            $grade = 0;
                        }


                        $html .= '<tr>';
                        $html .= '<td style="text-align:left;font-size::14px;border:1px solid #00000;">'.$form_group_order.'.'.$form_detail_order.'</td>';
                        $html .= '<td style="text-align:left;font-size::14px;border:1px solid #00000;">'.$form_detail_name.'</td>';
                        $html .= '<td style="text-align:center;font-size::14px;border:1px solid #00000;">'.$form_detail_weight.'</td>';
                        $html .= '<td style="text-align:center;font-size::14px;border:1px solid #00000;">'.$form_detail_score_full.'</td>';
                        $html .= '<td style="text-align:center;font-size::14px;border:1px solid #00000;">'.$grade.'</td>';
                        $html .= '</tr>';

                    }

            $html .= '</thead>';

            }


}else{




}


$html .= '</table>';
        










//==============================================================
//==============================================================
//==============================================================

require_once __DIR__ . '/mypdf-master/vendor/autoload.php';
$mpdf = new mPDF('th');
$mpdf->AddPageByArray([
    'margin-left' => 20,
    'margin-right' => 20,
    'margin-top' => 20,
    'margin-bottom' => 5,
    ]);

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================