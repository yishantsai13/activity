<?php 
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	
	require_once('mysql.php'); 

	if($_GET['del_sign']){//刪除報名學生
		mysql_query("DELETE FROM `activity_student_select` WHERE `sign_id`=".$_GET['del_sign']);//刪學生選的
		$check=mysql_query("DELETE FROM `activity_sign_up` WHERE `sign_id` =".$_GET['del_sign']);//刪報名
		
		echo '<script language="javascript">';
		if($check){
			echo 'alert("刪除成功");';
		}else{
			echo 'alert("學生刪除失敗");';
		}
			echo 'window.location="manage.php?activity_id='.$_GET['activity_id'].'";';
			echo '</script>';			
		exit();
	}
	
	if($_GET['del_activity']){
		mysql_query("DELETE FROM `activity_selection` WHERE `activity_id`=".$_GET['del_activity']);//刪問題選項
		mysql_query("DELETE FROM `activity_question` WHERE `activity_id`=".$_GET['del_activity']);//刪問題
		mysql_query("DELETE FROM `activity_sign_up_select` WHERE `activity_id`=".$_GET['del_activity']);//刪學生報名選擇項
		mysql_query("DELETE FROM `activity_sign_up` WHERE `activity_id`=".$_GET['del_activity']);//刪學生報名資料
		$check=mysql_query("DELETE FROM `activity` WHERE `activity_id`=".$_GET['del_activity']);//刪活動
		
		echo '<script language="javascript">';
		if($check){
			echo 'alert("刪除成功");';
		}else{
			echo 'alert("活動刪除失敗");';
		}
			echo 'window.location="manage_active.php";';
			echo '</script>';			
		exit();
	}

	

	$introduce=$_POST['introduce'];//活動簡介
	$activity_name=$_POST['activity_name'];//活動名稱

	$start_date=$_POST['start_date'];//報名開始日期
	$end_date=$_POST['end_date'];//報名截止日期

	$start_time_to_hour=$_POST['start_time_to_hour'];//報名開始時間-時
	$start_time_to_min=$_POST['start_time_to_min'];//報名開始時間-分	

	$end_time_to_hour=$_POST['end_time_to_hour'];//報名截止時間-時
	$end_time_to_min=$_POST['end_time_to_min'];//報名截止時間-分
	
	$event_start_date=$_POST['event_start_date'];//活動開始日期
	$event_start_hour=$_POST['event_start_hour'];//活動開始時間-時
	$event_start_min=$_POST['event_start_min'];//活動開始時間-分
			
	$event_end_date=$_POST['event_end_date'];//活動結束日期
	$event_end_hour=$_POST['event_end_hour'];//活動開始時間-時
	$event_end_min=$_POST['event_end_min'];//活動開始時間-分	
		
	
	$event_people=$_POST['event_people'];//人數限制
	$event_require=$_POST['event_require'];//備註
	$need_food=$_POST['need_food'];//需要便當
	

	if(!empty($introduce) && !empty($activity_name) && !empty($start_date) && !empty($end_date) && !empty($event_start_date) && !empty($event_end_date) && !empty($event_people)){
		
		$start_date=$start_date." ".$start_time_to_hour.":".$start_time_to_min;
		$end_date=$end_date." ".$end_time_to_hour.":".$end_time_to_min;
		$event_start=$event_start_date." ".$event_start_hour.":".$event_start_min;
		$event_end=$event_end_date." ".$event_end_hour.":".$event_end_min;
		
		$sql="INSERT INTO `activity` (`name` , `intro` , `max` ,`start_date`, `end_date` , `event_start` , `event_end` , `need_food`)
VALUES ('".string_escape($activity_name)."','".string_escape($introduce)."','".string_escape($event_people)."','".string_escape($start_date)."','".string_escape($end_date)."','".string_escape($event_start)."','".string_escape($event_end)."','".$need_food."')";

		if(mysql_query($sql)){		

			echo '<script language="javascript">';
			echo 'alert("'.$activity_name.'新增成功");';
			echo 'window.location="manage.php";';
			echo '</script>';	
			
			
			$sql="select activity_id from activity 
			where name='".string_escape($activity_name)."' ORDER BY `activity_id` DESC";
			
			$result=mysql_query($sql); //使用活動名稱且排序最大的來找出剛剛插入的ID
			$row=mysql_fetch_array($result);
						
			//插入活動選項
			$qes=0;//題號
			for($i=0;$i<10;$i++){//總共幾題
				//前端進來時i順序為0 3,4,....原因待查
				if(is_array($_POST['q'.$i.'_ans'])){//有選項才插入
					if($_POST['q'.$i.'_select_multiple']=="S"){
						$multiple=0;
					}else{
						$multiple=1;	
					}
					$qes++;//問題的題號
					$sql="INSERT INTO `activity_question` (`activity_id` ,`question_num`,`question` ,`multiple`)VALUES ('".$row[0]."', '".$qes."', '".$_POST['q'.$i.'_qes']."','".$multiple."')";
					mysql_query($sql);
					$ans=1;
					foreach($_POST['q'.$i.'_ans'] as $item){
						$sql="INSERT INTO `activity_selection` (`activity_id` ,`question_num`,`select_num` ,`item`)VALUES ('".$row[0]."', '".$qes."', '".$ans."','".$item."')";
						mysql_query($sql);
						$ans++;
					}
				}
				
			}
			

		}else{
			echo  '<script language="javascript">';
			echo 'alert("新增失敗，請洽管理員");';
			echo 'window.location="manage.php";';
			echo '</script>';	

		}
		exit();
	}
	echo  '<script language="javascript">';
	echo 'alert("資料有誤，請洽管理員");';
	echo 'window.location="manage.php";';
	echo '</script>';	



	


?>