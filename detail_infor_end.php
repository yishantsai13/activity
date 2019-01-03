<?php
session_start();
$this_page = basename(__FILE__);
 
require_once("mysql.php");
require_once("user_auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_詳細資訊</title>

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

<body onload="MM_preloadImages('image/choose/21.gif','image/choose/22.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">

<?php
$a_id = mysql_real_escape_string($_GET['aid']);
$sid = $_SESSION['sid'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_activity` WHERE activity_id=".$a_id));
$row_img=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_activity_file` WHERE cover=1 AND activity_id=".$a_id));
?>

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
				<td><a href="regi_activity.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','image/choose/22.gif',1)"><img src="image/choose/12.gif" alt="我的活動" width="224" height="120" id="Image2" /></a></a></td>
				<td><img src="image/choose/23.gif" width="224" height="120" alt="詳細資訊" /></td>
				<td><img src="image/choose/04.gif" width="224" height="120" /></td>
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
    <tr>
      <td rowspan="7" width="2%"></td>
 	  <td width="33%" rowspan="7" align="center" bgcolor="#CCCCCC" scope="col"><?php if(!empty($row_img['fname'])){?><img src="<?php echo "./".$row_img['path'];?>" width="300" height="400"  />
	  														 <?php }else{ echo "<font size='5' color='#CC0000'><B>無海報！</B></font>";}?></td>
      <td width="11%" align="right" class="m_word" bgcolor="CEE2D0"><font Face="標楷體" size="4"><b>活 動 名 稱：</b></font></td>
      <td width="52%" bgcolor="CEE2D0"><font size="2"><?php echo $row['name']; ?></font></td>
      <td rowspan="7" bgcolor="#FFFFFF" width="2%"></td>
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>活 動 日 期：</strong></font></td>
      <td><font size="2"><?php echo substr($row['event_start'],0,10)."至".substr($row['event_end'],0,10); ?></font></td>
    </tr>
    <tr bgcolor="CEE2D0">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>報 名 截 止：</strong></font></td>
      <td><font size="2"><?php echo substr($row['sign_end'],0,10); ?>止</font></td>
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;額：</strong></font></td>
      <td><font size="2"><?php echo $row['max']; ?>位</font></td>
    </tr>
    <tr bgcolor="CEE2D0">
      <td align="right" class="m_word" valign="top"><font Face="標楷體" size="4"><strong>活 動 說 明：</strong></font></td>
      <td><font size="2"><?php echo nl2br($row['intro']); ?></font></td>
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word" valign="top"><font Face="標楷體" size="4"><strong>檔 案 附 件：</strong></font></td>
      <td valign="top"><?php 
		$result_filelist=mysql_query("SELECT * FROM hai_active_activity_file WHERE  activity_id=".$a_id);
		while($row_filelist=mysql_fetch_array($result_filelist)){
		  if(!empty($row_filelist['fname'])){
		  ?>
		  <a target="_blank" href="<?php echo $row_filelist['path'];?>"><?php echo $row_filelist['fname'];?></a><br>
		  <?php  }}?>
	  </td>
    </tr>
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
