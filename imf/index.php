<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<table width="781" border="1" align="center" cellpadding="0" cellspacing="0">
<tr><td><img name="top1.jpg" src="top1.jpg" width="780" height="205" border="0" id="top1" alt="" /></td></tr>
</table>
<table width="780" border="1" align="center" cellpadding="0" cellspacing="0">
<tr><td width="180">
<?php 
if($_SESSION['admin']){
	echo '<p align="center">'.$_SESSION['admin']."你好</p>";	
	echo '<p align="center"><a href="manage_active.php">進入管理介面</a></p>';
	echo '<p align="center"><a href="logout.php">登出</a></p>';	
}elseif($_SESSION['sid']){
	echo '<p align="center">'.$_SESSION['sid']."你好</p>";
	echo '<p align="center"><a href="logout.php">登出</a></p>';	
}else{
	echo '<p align="center"><a href="login.php">登入</a></p>';	
}

?></td>
    <td width="200" align="center"><a href="activity.php">活動報名</a></td>
    <td width="200" align="center">生涯故事書</td>
    <td width="200" align="center">心得筆記分享區</td>
  </tr>
</table>
<p>&nbsp;</p>

</body>
</html>