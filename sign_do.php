<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	if(!$_SESSION['sid']){
		echo '
    	<script language="javascript">
		alert("請先登入");
		window.location="index.php";
		</script>';	
		exit();
	}
		
	require_once('mysql.php');
	
	//接收學生變數D
	$activity_id=$_POST['activity_id'];//fair_serial
	$s_phone=$_POST['s_phone'];//行動電話
	
	$s_food=$_POST['s_food'];//便當
	$s_email=$_POST['s_email'];//email
	$s_other=$_POST['s_other'];//備註
	$max_qes=$_POST['max_qes'];//備註
	
	$sid=$_SESSION['sid'];
	
	//check 值存在

	if(!isset($s_phone) || !isset($s_email)){
				echo '
   	   			<script language="javascript">
				alert("資料錯誤，請洽管理者");
				window.location="activity.php?activity_id='.$activity_id.'";
				</script>';		
	}
	$maxnum=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_sign_max` WHERE activity_id=".$activity_id));
	$sql="INSERT INTO  `hai_active_activity_sign_up` (  `activity_id` ,   `sid` ,  `food`  ,  `email` ,  `phone` ,  `others` , `snum` ) VALUES ('".$activity_id."','".$sid."','".$s_food."','".$s_email."','".$s_phone."','".$s_other."','".$maxnum['max']."')";
	mysql_query($sql);
	$query_maxUpdate = "UPDATE `hai_active_sign_max` SET `max`=`max`+1 WHERE `activity_id`='" . $activity_id . "'";
	mysql_query($query_maxUpdate);
	$result_qes=mysql_query("select * from `hai_active_activity_question` where `activity_id`='".$activity_id."'");
	while($row_qes=mysql_fetch_array($result_qes)){ 
	if(is_numeric($max_qes) && $max_qes > 0){
	
		//依序接收問題的答案，i代表問題的序號
		for($i==1;$i<=$max_qes;$i++){ 
			//判斷此問題是否有選項，沒選項認定無此問題
			if(isset($_POST['q_'.$i.'_select'])||isset($_POST['q_'.$i.'_textans'])){
				//判斷是否為array
				//echo $row_qes['type'];
				if(is_array($_POST['q_'.$i.'_select'])){
					//是則為多選，依序讀入
					foreach($_POST['q_'.$i.'_select'] as $item){
					//echo "多選";
						$sql1="INSERT INTO `hai_active_activity_sign_up_select` (`activity_id`, `sid`, `question_num`, `select_num`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$item."')";
						mysql_query($sql1);
					}
				}elseif($row_qes['type']=="S"){//單選只插入一個
				//echo "單選";
						$item=$_POST['q_'.$i.'_select'];
						$sql2="INSERT INTO `hai_active_activity_sign_up_select` (`activity_id`, `sid`, `question_num`, `select_num`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$item."')";
						mysql_query($sql2);
				}elseif($row_qes['type']=="D"){	//開放性問題
				//echo "開放";
						$content=$_POST['q_'.$i.'_textans'];
						$sql3="INSERT INTO `hai_active_activity_sign_up_select` (`activity_id`, `sid`, `question_num`,`ans`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$content."')";
						mysql_query($sql3);
				}else{
						echo "錯誤";
				     }
			}
		}
	}
	}
	
	echo '
    <script language="javascript">
	alert("報名成功");
	window.location="index.php";
	</script>';
	

?>
