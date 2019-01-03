<?php 
require("user_auth.php");
header('content-Type: application/json; charset=utf-8');
if($_GET["id"]){
	$id=$_GET["id"];
	if($main_database_link==NULL){
		student_conn();
	}
	$sql = "SELECT * FROM a11vstd_advise where std_no like '".$id."'";
	$result = my_query($main_database_link, $sql);
	$row = pg_fetch_array($result);
	if(!$row){
		echo json_encode(array(error=>"Studnet Not Found"));	
	}
	else{
		if($_GET["simple"]){
			echo json_encode(array(std_no=>$row['std_no'],pwd=>$row['pwd']));
		}
		else{
			echo json_encode($row);
		}	
		
	}
}
else{
	echo json_encode(array(error=>'$_GET["id"] Is Missed'));
}
?>
