<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>

<body>
<?php
echo '123';
	$db_host="140.123.30.7:4100";
    $user="life_explorer";
    $password="IWillBePirateKing!";
    $db = sybase_connect($db_host, $user, $password) or die("Could not connect");
    sybase_select_db("life_exploration", $db);
	echo 'ok';

?>
</body>
</html>