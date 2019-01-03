<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$this_page = basename(__FILE__); 
require_once("mysql.php");

$a_id = $_GET['aid'];
$sid=$_SESSION['sid'];
$sql_d="SELECT * FROM `hai_active_activity_sign_up_select` WHERE `activity_id`='$a_id' AND `sid`='$sid'";
$result_d = mysql_query($sql_d);

	while($data_d=mysql_fetch_array($result_d)){
$sql = "DELETE FROM `hai_active_activity_sign_up_select` WHERE `activity_id` = '$a_id' AND `sid`='$sid' AND `question_num`='".$data_d['question_num']."' AND `select_num`='".$data_d['select_num']."'";
$result = mysql_query($sql);
}
$sql_2="DELETE FROM `hai_active_activity_sign_up`  WHERE `activity_id`='$a_id' AND `sid`='$sid'";
$result = mysql_query($sql_2);

echo '
    <script language="javascript">
	window.location="regi_activity.php";
	</script>';
?>
