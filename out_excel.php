<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_活動匯出</title>
</head>

<body>
<?php
if(!$_GET['aid'])
	exit;
	
$activity_id=$_GET['aid'];
/** PHPExcel */
require_once 'phpexcel/Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();


$objPHPExcel->getProperties()->setCreator("林育任")
							 ->setLastModifiedBy("林育任")
							 ->setTitle("Office 2007 XLSX Document")
							 ->setSubject("Office 2007 XLSX Document")
							 ->setDescription("社員整合名單")
							 ->setKeywords("office 2007 2003 php")
							 ->setCategory("社團");

require_once('mysql.php');
require_once('user_auth.php');
// Rename sheet
$objPHPExcel->setActiveSheetIndex(0)->setTitle('學生報名名單');
// Add some data
$objPHPExcel->getActiveSheet()
			->setCellValue('A1', '學號')
            ->setCellValue('B1', '姓名')
			->setCellValue('C1', '性別')
			->setCellValue('D1', '科系')
			->setCellValue('E1', '年級')
			->setCellValue('F1', '班級')
            ->setCellValue('G1', '便當')
			->setCellValue('H1', 'email')
			->setCellValue('I1', '電話')
			->setCellValue('J1', '報名時間')
			->setCellValue('K1', '備註')
			->setCellValue('L1', '詢問回答');
			
			
$qes_array=array();
$cell_letter_ascii=ord("K")+1;//從上橫軸欄位顯示基本資料後接續問答的題目		
$result=mysql_query("select * from hai_active_activity_question where activity_id='".$activity_id."'");			
while($row=mysql_fetch_array($result)){
	array_push($qes_array,$row['question_num']);
	$objPHPExcel->getActiveSheet()->setCellValue(chr($cell_letter_ascii).'1', $row['question']);	
	$cell_letter_ascii++;	
}
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);	
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);		
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);	
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);	
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(100);	
			
$result=mysql_query("select * from hai_active_activity_sign_up where activity_id='".$activity_id."'");
$i=2;
while($row=mysql_fetch_array($result)){
	$student=get_student_data($row['sid']); 
	if($student['sex']=="M"){ $stusex="男";}
	else{ $stusex="女"; }
	$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$i, $row['sid'])
            ->setCellValue('B'.$i, $student['name'])
			->setCellValue('C'.$i, $stusex)
			->setCellValue('D'.$i, $student['dept'])
			->setCellValue('E'.$i, $student['grade'])
			->setCellValue('F'.$i, $student['class'])
            ->setCellValue('G'.$i, $row['food'])
            ->setCellValue('H'.$i, $row['email'])
            ->setCellValue('I'.$i, $row['phone'])
            ->setCellValue('J'.$i, $row['time'])
            ->setCellValue('K'.$i, $row['others']);
	$cell_letter_ascii=ord("J")+2;//從上橫軸欄位顯示基本資料後接續問答的題目		
	foreach($qes_array as $qes_num){
		$objPHPExcel->getActiveSheet() ->setCellValue(chr($cell_letter_ascii).$i, qes_ans($activity_id,$qes_num,$row['sid']));
		$cell_letter_ascii++;		
	}								
	$i++;
}


$row=mysql_fetch_array(mysql_query("SELECT * FROM  `hai_active_activity` WHERE activity_id='".$activity_id."'"));
$filename=mb_convert_encoding($row['name'],"big5","utf-8");
$filename2=mb_convert_encoding("報名名單","big5","utf-8");

// Redirect output to a client's web browser (Excel5)
ob_end_clean();
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="'.$filename.$filename2.'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');



function qes_ans($activity_id,$qes_num,$sid){
	$row_qes=mysql_fetch_array(mysql_query("select * from hai_active_activity_question where activity_id='".$activity_id."'"));
	$ans="";	
	
	if($row_qes['type']=="D"){	//若為開放式問題
		$sql_D="SELECT `ans` FROM hai_active_activity_question S1 ,`hai_active_activity_sign_up_select` S2 WHERE `sid`='".$sid."' AND S1.activity_id='".$activity_id."' AND S1.activity_id = S2.activity_id AND S1.`question_num` = S2.`question_num` AND `type`='D'";
				
			
		$result_select_D=mysql_query($sql_D);
		while($row_select_D=mysql_fetch_array($result_select_D))
		{
				$ans=$ans.','.$row_select_D['ans']; 
		}
		return $ans;
	}elseif($row_qes['type']=="S"){
		
			  $sql="SELECT * FROM `hai_active_activity_sign_up_select` S1, `activity_selection` S2 WHERE `sid`='".$sid."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$activity_id."' and S1.question_num='".$qes_num."'";
			  
			  $result_select=mysql_query($sql);
				while($row_select=mysql_fetch_array($result_select)){
					$ans=$ans.','.$row_select['item']; 
			  	}
				return $ans;
				
			  }else{
			  $sql="SELECT * FROM `hai_active_activity_sign_up_select` S1, `hai_active_activity_selection` S2 WHERE `sid`='".$sid."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$activity_id."' and S1.question_num='".$qes_num."'";
			  $result_select=mysql_query($sql);
			  
				while($row_select=mysql_fetch_array($result_select)){
					$ans=$ans.','.$row_select['item']; 
			  	}
			  
			  	return $ans;
			  }
}
exit;
			
?>

</body>
</html>