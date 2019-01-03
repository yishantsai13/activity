<?php
session_start();
require_once("mysql.php");
include_once("user_auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_活動列表</title>

<style type="text/css">
#wrapper{min-width:960px;max-width:1400px;margin:0 auto;}
#tablebg{background-image:url(image/bg5.jpg); background-repeat:no-repeat; background-position:top;}
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

<body onload="MM_preloadImages('image/choose/22.gif')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg" id="tablegb">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td>
		<?php 
		if($_SESSION['sid']){
			echo '&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5">'.$_SESSION['sid']."，您好</font>";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5"><a href="logout.php">登出</a></font>';	
		}
		else{
			echo '&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5"><a href="login.php">登入</a></font>';	
		}
		?>
  	</td>
  </tr>
  
  <tr>
  	<td>
			<table id="___01" width="1000" height="120" border="0" cellpadding="0" cellspacing="0">
              <tr>
				<td><img src="image/choose/00.png" width="12" height="120" alt=""></td>
				<td><a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','image/choose/21.gif',1)"><img src="image/choose/11.gif" alt="活動列表" width="224" height="120" id="Image7"></a></td>
				<td><a href="regi_activity.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','image/choose/22.gif',1)"><img src="image/choose/12.gif" alt="我的活動" width="219" height="120" id="Image2" /></a></td>
				<td><a href="detail_infor.php?aid=<?php echo $activity_id;?>&amp;sid=<?php echo $sid;?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','image/choose/23.gif',1)"><img src="image/choose/13.gif" alt="詳細資訊" width="224" height="120" id="Image3" /></a></td>
				<td><a href="edit_data.php?aid=<?php echo $a_id;?>&amp;sid=<?php echo $sid;?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','image/choose/24.gif',1)"><img src="image/choose/14.gif" alt="報名資料" width="224" height="120" id="Image4" /></a></td>
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
				<?php
				/*
				//編碼轉換(big5->utf8)
				$sid=$_SESSION['sid'];
				$student=get_student_data($sid); 
				$nameb5 = $student['name'];
				$nameutf=mb_convert_encoding($nameb5,"utf-8","big5");
				echo $student['sex'];
				echo $nameutf;
				*/
				//$result=sybase_fetch_array(sybase_query("select * from a11vstd_advise where std_no=".$_SESSION['sid'],$main_sybase_link));
				$sid=$_SESSION['sid'];
                              student_conn();
                              var_dump($main_sybase_link);
                              //$query = pg_query("select * from a11vstd_advise where std_no='".$sid."'");
                              $q = "select * from a11vstd_advise";
//							  $q = "select * from activity";
							  //$q = "ccc";
                              $query = pg_query($main_sybase_link, $q);
							  //$query = pg_query($q);
							  echo "result = $query<BR>\n";
							  echo "error msg = ";
                              var_dump(pg_result_error($query));
							  
                              $cnt = pg_num_rows($query);
                              echo "num of rows = ";
							  var_dump($cnt);
                              var_dump($query);
                              exit(1);
				$row=pg_fetch_array(pg_query("select * from a11vstd_advise where std_no='".$sid."'", $main_sybase_link));
		if($row==NULL){
			echo "NULL";
			echo pg_result_error($row);
		}
		$student_data=array();
		$student_data['name']=$row['name'];
		$student_data['sex']=$row['sex_id'];
		$student_data['dept']=$row['deptname'];
		$student_data['grade']=$row['now_grade'];
		$student_data['class']=$row['now_class'];
		echo $student_data['name'];
				//$result=pg_query($main_sybase_link,"select * from a11vstd_advise where std_no='601410046'");//a11vstd_advise
				if(!$result){echo "ResultFalse!!!";
				
				$res1 = pg_get_result($main_sybase_link);
				echo pg_result_error($res1);
				}
				$row=pg_fetch_row($result);//".$id."
				if(!$row){echo "RowFalse!!!";}
				else{
				echo "0:".$row[0]."<br />";
				echo "1:".$row[1]."<br />";
				echo "2:".$row[2]."<br />";
				echo "3:".$row[3]."<br />";
				echo "4:".$row[4]."<br />";
				echo "5:".$row[5]."<br />";
				}
				?>

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