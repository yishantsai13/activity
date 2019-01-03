<?php
session_start();
$this_page = basename(__FILE__); 

//避免有學號session和get不同的情形
if(empty($_SESSION['admin']))
	$sid=$_SESSION['sid'];
else	
	$sid=$_GET['sid'];

require_once("mysql.php");
require_once("user_auth.php");
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_我的活動</title>

<style type="text/css">
#wrapper{min-width:960px;max-width:1400px;margin:0 auto;}
img {BORDER: 0px;}
</style>

<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>

</head>

<body onload="MM_preloadImages('image/choose/21.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg" id="tablegb">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td>
		<?php 
		$student=get_student_data($sid); 
		if($_SESSION['admin']){
			echo '&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5">'.$_SESSION['admin']."，您好</font>";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5"><a href="manage_active.php">進入管理介面</a></font>';
		?>
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		else if($_SESSION['sid']){
		?>
        &nbsp;&nbsp;
		<font Face="細明體" size="5"><?php echo $student['name']; ?>，您好</font>
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		else{
		?>
        <a href="login.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogin','','image/login2.png',1)"><img src="image/login.png" alt="登入" width="80" height="41" id="Imagelogin" /></a>
		<?php
        }
		?>
  	</td>
  </tr>
  
  <tr>
  	<td>
			<table id="___01" width="1000" height="120" border="0" cellpadding="0" cellspacing="0">
              <tr>
				<td><img src="image/choose/00.png" width="12" height="120" alt=""></td>
				<td><a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','image/choose/21.gif',1)"><img src="image/choose/11.gif" alt="活動列表" width="224" height="120" id="Image1" /></a></td>
				<td><img src="image/choose/22.gif" width="224" height="120" alt="我的活動" /></a></td>
				<td><img src="image/choose/03.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/04.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/05.gif" width="92" height="120" alt=""></td>
			  </tr>
			</table>
	</td>
  </tr>
  <tr>
  	<td>
    	<table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
        <tr valign="top"><td>
<!-- Start -->
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
<?php
if(empty($_SESSION['sid']) && empty($_SESSION['admin'])){	
?>
            <tr bgcolor="#FFFFFF" height="500">
            	<td align="center" colspan="6"><font Face="標楷體" size="10" color="#FF0000">您尚未登入！</font></td>
            </tr>
<?php 
}
else{
?>

  <tr bordercolor="#FFCC33">
    <td align="center" width="40%" class="title_word" bgcolor="FFB35A"><font Face="標楷體" size="5">活動名稱</font></td>
    <td align="center" width="24%" class="title_word" bgcolor="FFB35A"><font Face="標楷體" size="5">活動日期</font></td>
    <td align="center" width="8%" class="title_word" bgcolor="FFB35A"><font Face="標楷體" size="5">修改</font></td>
    <td align="center" width="8%" class="title_word" bgcolor="FFB35A"><font Face="標楷體" size="5">刪除</font></td>
    <td align="center" width="20%" class="title_word" bgcolor="FFB35A"><font Face="標楷體" size="5">詳細活動資訊</font></td>
  </tr>
  <?php
 	$getdate = date("Y-m-d",mktime(date(m), date(d), date(Y)));		//yyyy-mm-dd
	
	$result_indate=mysql_query("SELECT * FROM  `hai_active_activity_sign_up`,`hai_active_activity` WHERE `hai_active_activity`.`activity_id`=`hai_active_activity_sign_up`.`activity_id` AND `sid`=".$sid." AND `appear_start`<='".$getdate."' AND `appear_end`>='".$getdate."' ORDER BY `event_start` ASC");
	$result_outofdate=mysql_query("SELECT * FROM  `hai_active_activity_sign_up`,`hai_active_activity` WHERE `hai_active_activity`.`activity_id`=`hai_active_activity_activity_sign_up`.`activity_id` AND `sid`=".$sid." AND `appear_end`<'".$getdate."' ORDER BY `event_start` DESC");
  $r = mysql_num_rows($result_indate);	
  $numrows = $r;
	$r2 = mysql_num_rows($result_outofdate);
	$numr2 = $r2;
	
	$num_result=mysql_query("SELECT COUNT(activity_id) FROM `hai_active_activity_sign_up` WHERE `activity_id`");
	if($num_result==0){
	 echo '<tr bgcolor="#FFFFFF"><td colspan="5"><div align="center">目前並沒有參加任何活動</div></td></tr>';
	}else{
		
	//活動時間排序：近->遠->過期的活動
	while($row=mysql_fetch_assoc($result_indate)){
	
	if(++$numrows % 2 > 0){$bgcolor="FEF5E8";}  //淺
    else{$bgcolor="FDE4C4";}  //深
	echo "<tr height='50' bgcolor=".$bgcolor.">";
	//活動名稱
	echo "<td align='center' valign='middle'>".$row['name']."</td>";
	//活動時間
	if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){echo "<td align='center' valign='middle'>".substr($row['event_start'],0,4)."/".substr($row['event_start'],5,2)."/".substr($row['event_start'],8,2); }else{ echo "<td align='center' valign='middle'>".substr($row['event_start'],0,4)."/".substr($row['event_start'],5,2)."/".substr($row['event_start'],8,2)."<br>至<br>".substr($row['event_start'],0,4)."/".substr($row['event_end'],5,2)."/".substr($row['event_end'],8,2)."</td>";}
    //序號
	//echo "<td align='center'>".$row['snum']."</td>";
	//修改	
	echo "<td align='center' valign='middle'><a href='edit_data.php?aid=".$row['activity_id']."&amp;sid=".$sid."' target='_self'>修改</a></td>";
	//刪除
	echo "<td align='center' valign='middle'><a href='delete_data_do.php?aid=".$row['activity_id']."' onclick='return(confirm(\"確定要刪除此筆資料？\"))' target='_self'>刪除</a></td>";
	//詳細活動資訊
	echo "<td align='center' valign='middle'><a href='detail_infor.php?aid=".$row['activity_id']."&amp;sid=".$sid."' target='_self'>觀看詳細資訊</a></td></tr>";
	}
	
	while($row=mysql_fetch_assoc($result_outofdate)){
	
	if($numrows % 2 > 0){
		if(++$numr2 % 2 > 0){$bgcolor="FDE4C4";}  //深
    	else{$bgcolor="FEF5E8";}  //淺
		echo "<tr  height='50' bgcolor=".$bgcolor.">";

	}
	else{
		if(++$numr2 % 2 > 0){$bgcolor="FEF5E8";} //淺
    	else{$bgcolor="FDE4C4";} //深
		echo "<tr  height='50' bgcolor=".$bgcolor.">";
	}
		
	//活動名稱
	echo "<td align='center' valign='middle'>".$row['name']."</td>";
	//活動時間
	if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){echo "<td align='center' valign='middle'>".substr($row['event_start'],0,4)."/".substr($row['event_start'],5,2)."/".substr($row['event_start'],8,2); }else{ echo "<td align='center' valign='middle'>".substr($row['event_start'],0,4)."/".substr($row['event_start'],5,2)."/".substr($row['event_start'],8,2)."<br>至<br>".substr($row['event_start'],0,4)."/".substr($row['event_end'],5,2)."/".substr($row['event_end'],8,2)."</td>";}
    //序號
	//echo "<td align='center'>".$row['snum']."</td>";
	//修改與刪除需隱藏	
	echo "<td colspan='2' align='center' valign='middle'>活動時間已過</td>";
	
	//詳細活動資訊
	echo "<td align='center' valign='middle'><a href='detail_infor_end.php?aid=".$row['activity_id']."' target='_self'>觀看詳細資訊</a></td></tr>";
	}
	
	}
}
  ?>
        </table>
<!-- End -->
        </td></tr>
        </table>
    </td>
  </tr>
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>
</table>
</div>
</body>
</html>
