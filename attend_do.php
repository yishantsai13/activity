<?php 
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	
	require_once('mysql.php'); 
	require_once('image-resizing.php');	

	$state=0;
	//接收變數	
	$aid=$_GET['aid'];
	$att=$_GET['att']; 
	/*
	echo '<script language="javascript">';
    echo 'alert('.$_POST["att"][1].')';
    echo '</script>';
	
	exit;
	*/
	/*$row=mysql_fetch_array(mysql_query("SELECT *  FROM  `activity_sign_up` WHERE activity_id=".$aid." and sid=".$sid));
	if($row['attend']=="N"){
    $sql="UPDATE `activity_sign_up` SET `attend`='Y' WHERE activity_id=".$aid." and sid=".$sid;
	}
	else{
    $sql="UPDATE `activity_sign_up` SET `attend`='N' WHERE activity_id=".$aid." and sid=".$sid;
	}*/
	
	for($i=0;$i<count($_POST["att"]);$i++){
		$attid=$_POST["att"][$i];
		//echo $_POST["signs"][$attid].",";
		/*
		echo '<script language="javascript">';
		echo 'alert('.$attid.$_POST["signs"][$attid].')';
		echo '</script>';
		*/
	
		$sql="UPDATE `activity_sign_up` SET `attend`='N' WHERE activity_id=".$aid." and sid=".$_POST["signs"][$attid];
		$result = mysql_query($sql);
		if($result){
			$state=1;
		}
		else{
			$state=0;
		}
		
	}

	
  if($state==1){
    echo '<script language="javascript">';
    echo 'window.location="manage_attend.php?activity_id='.$aid.'";';
    echo '</script>';
  }
  
else{
	echo '<script language="javascript">';
	echo 'alert("UPDATE data failed!")';
    echo 'window.location="manage_attend.php?activity_id='.$aid.'";';
    echo '</script>';
  }
 ?>