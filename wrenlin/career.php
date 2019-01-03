<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>生涯故事書</title>
</head>

<body>
<p><a href="index.php">回首頁</a></p>
<p>
  <?php  require_once("mysql.php"); ?>
</p>


<?php 
$result=mysql_query("SELECT * FROM `career_story` order by class");
$class="";
while($row=mysql_fetch_array($result)){
	if($class!=$row['class']){
		echo "<hr>";
		echo "<b>類別：".$row['class']."</b>";	
	}
	echo "<p>".$row['title']."</p>";	
	$class=$row['class'];
}
?>

</body>
</html>