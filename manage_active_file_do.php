<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
require_once'mysql.php';
if($_GET['del_file']){
	$row=mysql_fetch_array(mysql_query("select * from hai_active_activity_file where fid='".$_GET['fid']."'"));
	if($row){
		unlink($row['path']);
		mysql_query("delete from hai_active_activity_file where fid='".$_GET['fid']."'");	
	}
	echo '<script language="javascript">';
	echo 'alert("修改完成");';
	echo 'window.location="manage_active_file.php?activity_id='.$_GET['activity_id'].'";';
	echo '</script>';		
}

if($_POST['set_cover']){
	mysql_query("update hai_active_activity_file set cover=0 where activity_id='".$_POST['activity_id']."'");
	mysql_query("update hai_active_activity_file set cover=1 where fid='".$_POST['cover_fid']."'");	
	echo '<script language="javascript">';
	echo 'alert("設定封面成功");';
	echo 'window.location="manage_active_file.php?activity_id='.$_POST['activity_id'].'";';
	echo '</script>';		
}



?>
