<?php
session_start();
header("Content-Type: text/html; charset=utf-8");//為了IE6相容才加此行，不然會讀不出utf8
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_destroy();
?>

<SCRIPT LANGUAGE="JavaScript">
alert("您已登出");
window.location="index.php";
</SCRIPT>