<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 

//學生登入或管理者登入
if(empty($_SESSION['sid']) && empty($_SESSION['admin'])){
	echo "請登入";
	exit;
}
//避免有學號session和get不同的情形
if(empty($_SESSION['admin']))
	$sid=$_SESSION['sid'];
else	
	$sid=$_GET['sid'];

require_once("mysql.php");
require_once("user_auth.php");

	$a_id=$GET_['a_id'];	
	//接收學生變數
	$activity_id=$_POST['activity_id'];//fair_serial
	$s_phone=$_POST['s_phone'];//行動電話
	$s_food=$_POST['s_food'];//便當
	$s_email=$_POST['s_email'];//email
	$s_other=$_POST['s_other'];//備註
	//$max_qes=$_POST['max_qes'];//備註
	$snum=$_POST['snum'];//報名編號
	$sid=$_SESSION['sid'];
	//check 值存在
	if(!isset($s_phone) || !isset($s_email)){
				echo '
   	   			<script language="javascript">
				alert("資料錯誤，請洽管理者");
				window.location="edit_data.php";
				</script>';		
	}

//先刪除資料
print_r($_GET);
echo $sid;
$sql_d="SELECT * FROM `hai_active_activity_sign_up_select` WHERE `activity_id`='".$a_id."' AND `sid`='".$sid."'";
echo $sql_d;
$result_d = mysql_query($sql_d);

	while($data_d=mysql_fetch_array($result_d)){
$sql_do = "DELETE FROM `hai_active_activity_sign_up_select` WHERE `activity_id` = '$activity_id' AND `sid`='$sid' AND `question_num`='".$data_d['question_num']."' AND `select_num`='".$data_d['select_num']."'";
echo $sql_do;
$result = mysql_query($sql_do);
}
$sql_2="DELETE FROM `hai_active_activity_sign_up`  WHERE `activity_id`='$activity_id' AND `sid`='$sid'";
$result = mysql_query($sql_2);

	
//再新增資料
$sql="INSERT INTO `hai_active_activity_sign_up`(`activity_id`,`sid`,`food`,`email`,`phone`,`others`,`snum`) VALUES ('".$activity_id."','".$sid."','".$s_food."','".$s_email."','".$s_phone."','".$s_other."','".$snum."')";
mysql_query($sql);
			
	if(is_numeric($max_qes) && $max_qes > 0){
		
		for($i=1;$i<=$max_qes;$i++){ //依序接收問題的答案，i代表問題的序號
			if(isset($_POST['q_'.$i.'_select'])){//判斷此問題是否有選項，沒選項認定無此問題
				if(is_array($_POST['q_'.$i.'_select'])||isset($_POST['q_'.$i.'_textans'])){//判斷是否為array
					foreach($_POST['q_'.$i.'_select'] as $item){//是則為多選，依序讀入
						$sql="INSERT INTO `hai_active_activity_sign_up_select` (`activity_id`, `sid`, `question_num`, `select_num`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$item."')";
						mysql_query($sql);
					}
				}elseif($row_qes['type']=="S"){//單選只插入一個
				//echo "單選";
						$item=$_POST['q_'.$i.'_select'];
						$sql2="INSERT INTO `hai_active_activity_sign_up_select` (`activity_id`, `sid`, `question_num`, `select_num`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$item."')";
						mysql_query($sql2);
				}elseif($row_qes['type']=="D"){	//開放性問題
				//echo "開放";
						$content=$_POST['q_'.$i.'_textans'];
						$sql3="INSERT INTO `activity_sign_up_select` (`activity_id`, `sid`, `question_num`,`ans`) VALUES ('".$activity_id."', '".$sid."', '".$i."', '".$content."')";
						mysql_query($sql3);
				}else{
						echo "錯誤";
				     }
				}
			}
		}
	
if(empty($_SESSION['admin'])){ //學生
	echo '
    <script language="javascript">
	alert("修改成功");';
	echo 'window.location="regi_activity.php?sid='.$sid.'";';
	echo '</script>';
}
else{ //管理者
	echo '
    <script language="javascript">
	alert("修改成功");';
	echo 'window.location="manage.php";';
	echo '</script>';
}

?>
<p>&nbsp;</p>
