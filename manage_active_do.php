<?php 
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	
	require_once('mysql.php'); 
	require_once('image-resizing.php');

	if($_GET['del_sign']){//刪除報名學生sid
		//刪學生選的
		mysql_query("DELETE FROM `hai_active_activity_sign_up_select` WHERE `sid`=".$_GET['del_sign']."' AND activity_id='".$_GET['activity_id']."'");
		//刪報名
		$check=mysql_query("DELETE FROM `hai_active_activity_sign_up` WHERE `sid`='".$_GET['del_sign']."' AND activity_id='".$_GET['activity_id']."'");
		
		echo '<script language="javascript">';
		if($check){
			echo 'alert("刪除成功");';
		}else{
			echo 'alert("學生刪除失敗");';
		}
			echo 'window.location="manage_detail.php?activity_id='.$_GET['activity_id'].'";';
			echo '</script>';			
		exit();
	}

//-------------------------------------------------------------------------------------------------------
	
	if($_GET['del_activity']){//刪除活動
	
		mysql_query("DELETE FROM `hai_active_activity_selection` WHERE `activity_id`=".$_GET['del_activity']);//刪問題選項
		mysql_query("DELETE FROM `hai_active_activity_question` WHERE `activity_id`=".$_GET['del_activity']);//刪問題
		mysql_query("DELETE FROM `hai_active_activity_sign_up_select` WHERE `activity_id`=".$_GET['del_activity']);//刪學生報名選擇項
		mysql_query("DELETE FROM `hai_active_activity_sign_up` WHERE `activity_id`=".$_GET['del_activity']);//刪學生報名資料
		$check=mysql_query("DELETE FROM `hai_active_activity` WHERE `activity_id`=".$_GET['del_activity']);//刪活動
		
		echo '<script language="javascript">';
		if($check){
			echo 'alert("刪除成功");';
		}else{
			echo 'alert("活動刪除失敗");';
		}
			echo 'window.location="manage.php";';
			echo '</script>';			
		exit();
	}
	

//-------------------------------------------------------------------------------------------------------

	if($_POST['edit_activity']){//修改活動
		$introduce=$_POST['edit_introduce'];//活動簡介
		$activity_name=$_POST['edit_activity_name'];//活動名稱

		//---------------------------------------報名期間
		$sign_start_date=$_POST['edit_sign_start_date'];//報名開始日期
		$sign_end_date=$_POST['edit_sign_end_date'];//報名截止日期

		$sign_start_time_to_hour=$_POST['edit_sign_start_time_to_hour'];//報名開始時間-時
		$sign_start_time_to_min=$_POST['edit_sign_start_time_to_min'];//報名開始時間-分	

		$sign_end_time_to_hour=$_POST['edit_sign_end_time_to_hour'];//報名截止時間-時
		$sign_end_time_to_min=$_POST['edit_sign_end_time_to_min'];//報名截止時間-分
		
		//---------------------------------------上架期間
		$appear_start_date=$_POST['edit_appear_start_date'];//報名開始日期
		$appear_end_date=$_POST['edit_appear_end_date'];//報名截止日期

		$appear_start_time_to_hour=$_POST['edit_appear_start_time_to_hour'];//報名開始時間-時
		$appear_start_time_to_min=$_POST['edit_appear_start_time_to_min'];//報名開始時間-分	

		$appear_end_time_to_hour=$_POST['edit_appear_end_time_to_hour'];//報名截止時間-時
		$appear_end_time_to_min=$_POST['edit_appear_end_time_to_min'];//報名截止時間-分			
	
	
		//---------------------------------------活動期間
		$event_start_date=$_POST['edit_event_start_date'];//活動開始日期
		$event_start_hour=$_POST['edit_event_start_hour'];//活動開始時間-時
		$event_start_min=$_POST['edit_event_start_min'];//活動開始時間-分
			
		$event_end_date=$_POST['edit_event_end_date'];//活動結束日期
		$event_end_hour=$_POST['edit_event_end_hour'];//活動開始時間-時
		$event_end_min=$_POST['edit_event_end_min'];//活動開始時間-分	
		
	
		$event_people=$_POST['edit_event_people'];//人數限制
		$event_require=$_POST['edit_event_require'];//備註
		$need_food=$_POST['edit_need_food'];//需要便當
		
		$sign_start=$sign_start_date." ".$sign_start_time_to_hour.":".$sign_start_time_to_min;
		$sign_end=$sign_end_date." ".$sign_end_time_to_hour.":".$sign_end_time_to_min;
			
		$appear_start=$appear_start_date." ".$appear_start_time_to_hour.":".$appear_start_time_to_min;
		$appear_end=$appear_end_date." ".$appear_end_time_to_hour.":".$appear_end_time_to_min;		
				
		$event_start=$event_start_date." ".$event_start_hour.":".$event_start_min;
		$event_end=$event_end_date." ".$event_end_hour.":".$event_end_min;
		
		$sql="UPDATE `hai_active_activity` SET `name`='".string_escape($activity_name)."' , `intro`='".string_escape($introduce)."' , 
		`max`='".string_escape($event_people)."' ,`sign_start`='".$sign_start."', `sign_end`='".$sign_end."',
		`appear_start`='".$appear_start."',`appear_end`='".$appear_end."' , `event_start`='".string_escape($event_start)."' , 
		`event_end`='".string_escape($event_end)."' , `need_food`='".$need_food."'
		 WHERE `activity_id`='".$_POST['activity_id']."'";
		 
		
		if(mysql_query($sql)){
			echo  '<script language="javascript">';
			echo 'alert("修改活動成功，請繼續編輯相關檔案上傳部分");';
			echo 'window.location="manage_active_file.php?activity_id='.$_POST['activity_id'].'";';
			echo '</script>';		
		}else{
			echo  '<script language="javascript">';
			echo 'alert("修改失敗");';
			echo 'window.location="manage.php";';
			echo '</script>';			
		}
		exit;
	
	}
	
//-------------------------------------------------------------------------以下都是新增	
	
	if($_POST['add_activity']){//新增活動

		$introduce=$_POST['introduce'];//活動簡介
		$activity_name=$_POST['activity_name'];//活動名稱

		//---------------------------------------報名期間
		$sign_start_date=$_POST['sign_start_date'];//報名開始日期
		$sign_end_date=$_POST['sign_end_date'];//報名截止日期

		$sign_start_time_to_hour=$_POST['sign_start_time_to_hour'];//報名開始時間-時
		$sign_start_time_to_min=$_POST['sign_start_time_to_min'];//報名開始時間-分	

		$sign_end_time_to_hour=$_POST['sign_end_time_to_hour'];//報名截止時間-時
		$sign_end_time_to_min=$_POST['sign_end_time_to_min'];//報名截止時間-分
		
		//---------------------------------------上架期間
		$appear_start_date=$_POST['appear_start_date'];//報名開始日期
		$appear_end_date=$_POST['appear_end_date'];//報名截止日期

		$appear_start_time_to_hour=$_POST['appear_start_time_to_hour'];//報名開始時間-時
		$appear_start_time_to_min=$_POST['appear_start_time_to_min'];//報名開始時間-分	

		$appear_end_time_to_hour=$_POST['appear_end_time_to_hour'];//報名截止時間-時
		$appear_end_time_to_min=$_POST['appear_end_time_to_min'];//報名截止時間-分			
	
	
		//---------------------------------------活動期間
		$event_start_date=$_POST['event_start_date'];//活動開始日期
		$event_start_hour=$_POST['event_start_hour'];//活動開始時間-時
		$event_start_min=$_POST['event_start_min'];//活動開始時間-分
			
		$event_end_date=$_POST['event_end_date'];//活動結束日期
		$event_end_hour=$_POST['event_end_hour'];//活動開始時間-時
		$event_end_min=$_POST['event_end_min'];//活動開始時間-分	
		
	
		$event_people=$_POST['event_people'];//人數限制
		$event_require=$_POST['event_require'];//備註
		$need_food=$_POST['need_food'];//需要便當
	

		if(empty($introduce) || empty($activity_name) || empty($sign_start_date) || empty($sign_end_date) || empty($appear_start_date) || empty($appear_end_date) || empty($event_start_date) || empty($appear_end_date) || empty($event_people)){
			$error="資料有誤，請洽管理員";
		}else{
		
			$sign_start=$sign_start_date." 00:00:00";//$sign_start_time_to_hour.":".$sign_start_time_to_min;
			$sign_end=$sign_end_date." 00:00:00";//$sign_end_time_to_hour.":".$sign_end_time_to_min;
			
			$appear_start=$appear_start_date." 00:00:00";//$appear_start_time_to_hour.":".$appear_start_time_to_min;
			$appear_end=$appear_end_date." 00:00:00";//$appear_end_time_to_hour.":".$appear_end_time_to_min;		
				
			$event_start=$event_start_date." 00:00:00";//$event_start_hour.":".$event_start_min;
			$event_end=$event_end_date." 00:00:00";//$event_end_hour.":".$event_end_min;
		
			$sql="INSERT INTO `hai_active_activity` (`poster` , `name` , `intro` , `max` ,`sign_start`, `sign_end`,
			`appear_start`,`appear_end` , `event_start` , `event_end` , `need_food`)
			VALUES ('".$_SESSION['admin']."','".string_escape($activity_name)."','".string_escape($introduce)."','".string_escape($event_people)."',
			'".$sign_start."','".$sign_end."','".$appear_start."','".$appear_end."','".string_escape($event_start)."',
			'".string_escape($event_end)."','".$need_food."')";
			
			/*echo "</br>".$_SESSION['admin']."','".string_escape($activity_name)."','".string_escape($introduce)."','".string_escape($event_people)."',
			'".$sign_start."','".$sign_end."','".$appear_start."','".$appear_end."','".string_escape($event_start)."',
			'".string_escape($event_end)."','".$need_food;*/
			print_r($_POST);
			
			if(mysql_query($sql)){		
			

			
				$sql="select activity_id from hai_active_activity 
				where name='".string_escape($activity_name)."' ORDER BY `activity_id` DESC";
			
				$row=mysql_fetch_array(mysql_query($sql));//使用活動名稱且排序最大的來找出剛剛插入的ID
				$activity_id=$row[0];
					
				insert_selection($activity_id);
				
				$inssql="INSERT INTO `hai_active_sign_max`(`activity_id`) VALUES ('".$activity_id."')";
				mysql_query($inssql);
				
				echo '<script language="javascript">';
				echo 'alert("'.$activity_name.'新增活動成功，請繼續編輯相關檔案上傳部分");';
				echo 'window.location="manage_active_file.php?activity_id='.$activity_id.'";';
				echo '</script>';	
			
			exit;
				
			}else{
				$error="新增失敗，請洽管理員";	
			}
			
		}
		echo  '<script language="javascript">';
		echo 'alert("'.$error.'");';
		//echo 'window.location="manage.php";';
		echo '</script>';			
		exit();
	}


	function insert_selection($activity_id){	
		//插入活動選項
		$qes=0;//題號
		for($i=1;$i<=$_POST['qes_num'];$i++){//總共幾題
			$qes++;//問題的題號	
			if($_POST['q'.$i.'_select_qes_type']=="S")
				$type="S";
			elseif($_POST['q'.$i.'_select_qes_type']=="M")
				$type="M";
			else
				$type="D";	
				
			$sql="INSERT INTO `hai_active_activity_question` (`activity_id` ,`question_num`,`question` ,`type`)
			VALUES ('".$activity_id."', '".$qes."', '".$_POST['q'.$i.'_qes']."','".$type."')";
			mysql_query($sql);
			$ans=1;
			if($_POST['q'.$i.'_select_qes_type']=="S" || $_POST['q'.$i.'_select_qes_type']=="M"){//單複選selection處理	
				foreach($_POST['q'.$i.'_ans'] as $item){
					$sql="INSERT INTO `hai_active_activity_selection` (`activity_id` ,`question_num`,`select_num` ,`item`)
					VALUES ('".$activity_id."', '".$qes."', '".$ans."','".$item."')";
					mysql_query($sql);
					$ans++;
				}
			}//開放性問答無selection
		}
	}


	echo  '<script language="javascript">';
	echo 'alert("資料有誤，請洽管理員");';
	echo 'window.location="manage.php";';
	echo '</script>';	

?>