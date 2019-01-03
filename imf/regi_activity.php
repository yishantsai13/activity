<?php
session_start();
$this_page = basename(__FILE__); 
require_once("mysql.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>航海王活動報名</title>
<link href="base.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<p align="right">→<a href="activity.php">回活動列表</a>←</p>
<table style="margin-top:10pt;margin-bottom:20pt" width="75%" border="0" align="center">
<tr><td colspan="5"><img name="top7.jpg" src="top7.jpg" width="780" height="205" border="0" id="top7" alt="" /></td></tr>
  <tr bordercolor="#FFCC33" bgcolor="#FFF5D7">
    <td align="center" width="30%" class="title_word">活動名稱</td>
    <td align="center" width="20%" class="title_word">活動時間</td>
    <td align="center" width="5%" class="title_word">修改</td>
    <td align="center" width="5%" class="title_word">刪除</td>
    <td align="center" width="15%" class="title_word">詳細活動資訊</td>
  </tr>
  <?php
 	$getdate = date("Y-m-d",mktime(date(m), date(d), date(Y)));		//yyyy-mm-dd
	$result=mysql_query("SELECT * FROM  `activity_sign_up`,`activity` WHERE `activity`.`activity_id`=`activity_sign_up`.`activity_id` AND `sid`=".$_SESSION['sid']." ORDER BY `sign_end` ASC ");
	$num_result=mysql_query("SELECT COUNT(activity_id) FROM `activity_sign_up` WHERE `activity_id`");
	if($num_result==0){
	 echo '<tr><td colspan="5"><div align="center">目前並沒有參加任何活動</div></td></tr>';
	}else{
	while($row=mysql_fetch_array($result)){
	//活動時間過的話，須讓活動下架
	if(substr($row['event_end'],0,10)>$getdate){
	//活動名稱
	echo "<tr><td>".$row['name']."</td>";
	//活動時間
	echo "<td>".substr($row['event_start'],5,2)."/".substr($row['event_start'],8,8)." ~ ".substr($row['event_end'],5,2)."/".substr($row['event_end'],8,8)."</td>";
    //修改	
	echo "<td align='center'><a href='edit_data.php?aid=".$row['activity_id']."' target='_self'>修改</a></td>";
	//刪除
	echo "<td align='center'><a href='delete_data_do.php?aid=".$row['activity_id']."' onclick='return(confirm(\"確定要刪除此筆資料？\"))' target='_self'>刪除</a></td>";
	//詳細活動資訊
	echo "<td align='center'><a href='detail_infor.php?aid=".$row['activity_id']."' target='_self'>觀看詳細資訊</a></td></tr>";
	}
	}
	}
  ?>
</table>
<p>&nbsp;</p>
</body>
</html>