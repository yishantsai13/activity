<?php session_start(); ?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$_SESSION['admin'] = "";
$_SESSION['sid'] = "";
$pass = htmlspecialchars($_POST['pass']);
$id = pg_escape_string(htmlspecialchars($_POST['id']));
if(!empty($id) && !empty($pass)){//原本是isset($id) && isset($pass)
	require_once("user_auth.php");
	if(!$main_database_link){
		echo "open fail 222<br/>";
		student_conn();
	}
	//檢查學生登入
	if($id!=null && $pass!=null && check_student($id,$pass)){
		$_SESSION['sid']=$id;
		echo '<script language="javascript">
			
			window.location="index.php";
			</script>';
		exit;	
	}
	//檢查管理者登入
	if($id!=null && $pass!=null && check_manager($id,$pass)){
		$_SESSION['admin']=$id;
		echo '<script language="javascript">
			
			window.location="manage.php";
			</script>';
		exit;	
	}
			
	echo 
	'
	    <script language="javascript">
		alert("帳密錯誤");
		window.location="index.php";
		</script>';
	exit;
}

?>




<title>活動報名系統_登入</title> 

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

<style>
a{text-decoration:none }
</style>

</head>

<body onLoad="MM_preloadImages('image/choose/21.gif','image/backtoindex2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg" id="tablegb">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td><a style="text-decoration: none" href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagebacktoindex','','image/backtoindex2.png',1)"><img src="image/backtoindex.png" alt="返回首頁" width="160" height="41" id="Imagebacktoindex"></a></td>
  </tr>
  
  <tr>
  	<td>
			<table id="___01" height="120" border="0" cellpadding="0" cellspacing="0" align="center">
  		 	  <tr>
				<td><img src="image/choose/00.png" width="12" height="120" /></td>
				<td><a style="text-decoration: none" href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','image/choose/21.gif',1)"><img src="image/choose/11.gif" alt="活動列表" width="224" height="120" id="Image7"></a></td>
				<td><img src="image/choose/02.gif" width="219" height="120" /></td>
				<td><img src="image/choose/03.gif" width="220" height="120" /></td>
				<td><img src="image/choose/04.gif" width="223" height="120" /></td>
				<td><img src="image/choose/05.gif" width="102" height="120" /></td>
  		 	  </tr>
			</table>
	</td>
  </tr>
  <tr>
  	<td>
    	<form name="form1" method="post" action="login.php">
        <table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
        <tr valign="top"><td>
<!-- Start -->
		<table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
        <tbody>
            <tr height="10">
              <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
              <td align="center"><font color="red"><b>＊</b></font><font color="#0000CC">請使用學籍系統的帳號密碼登入</font></td>
            </tr>
            <tr height="10">
              <td>&nbsp;&nbsp;</td>
            </tr>
            <tr>
		  	  <td align="center"><font Face="標楷體" size="5">帳號</font><input type="text" name="id" id="textfield2"></td>
            </tr>
			<tr>
		      <td align="center"><font Face="標楷體" size="5">密碼</font><input type="password" name="pass" id="textfield"></td>
			</tr>
			<tr>
			  <td align="center"><input name="" type="submit" value="送出"></td>
			</tr>
        </tbody>
        </table>
<!-- End -->
		</td></tr>
        </table>
        </form>
    </td>
  </tr>
  
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>
</table>

</div>
</body>
</html>
