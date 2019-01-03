<?php
session_start();
if(isset($_POST['activity_id'])){
	$_SESSION['activity_id']=$_POST['activity_id'];	
}
?>
<html>
<head>

</head>
<body>

<form name="form1" method="post" action="ttt.php">

  <label for=""></label>
  <input name="activity_id" type="text" id="activity_id">
  <input type="submit" name="button" id="button" value="送出">
</form>
</body>
</body>
</html>