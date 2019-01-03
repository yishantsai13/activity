<?php
session_start();
$this_page = basename(__FILE__); 
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
img {BORDER: 0px;}
</style>

</head>

<body onload="MM_preloadImages('image/choose/22.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td align="left" valign="top">
		<?php 
		$sid=$_SESSION['sid'];
		$student=get_student_data($sid);
		if($_SESSION['sid']){
		?>
        &nbsp;&nbsp;
		<font Face="細明體" size="5"><?php echo $student['name']; ?>，您好</font>
        <a style="text-decoration: none" href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		else{
		?>
        <a style="text-decoration: none" href="login.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogin','','image/login2.png',1)"><img src="image/login.png" alt="登入" width="80" height="41" id="Imagelogin" /></a>
		<?php
        }
		?>
  	</td>
  </tr>
  <tr>
  	<td>
		<?php 
		if($_SESSION['sid']){　　//使用者顯示活動列表、我的活動
		?>
			<table id="___01" width="1000" height="120" border="0" cellpadding="0" cellspacing="0">
              <tr>
				<td><img src="image/choose/00.png" width="12" height="120" alt=""></td>
				<td><img src="image/choose/21.gif" width="224" height="120" alt="活動列表"></td>
				<td><a style="text-decoration: none" href="regi_activity.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','image/choose/22.gif',1)"><img src="image/choose/12.gif" alt="我的活動" width="219" height="120" id="Image2" /></a></td>
				<td><img src="image/choose/03.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/04.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/05.gif" width="92" height="120" alt=""></td>
			  </tr>
			</table>
		<?php
		}
		else{  //尚未登入只顯示活動列表
		?>
			<table id="___01" width="1000" height="120" border="0" cellpadding="0" cellspacing="0">
              <tr>
				<td><img src="image/choose/00.png" width="12" height="120" alt=""></td>
				<td><img src="image/choose/21.gif" width="224" height="120" alt="活動列表"></td>
				<td><img src="image/choose/02.gif" width="224" height="120" alt=""></a></td>
				<td><img src="image/choose/03.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/04.gif" width="224" height="120" alt=""></td>
				<td><img src="image/choose/05.gif" width="92" height="120" alt=""></td>
			  </tr>
			</table>
		<?php } ?>
	</td>
  </tr>
  <tr>
  	<td>
    	<table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
        <tr valign="top"><td>
<!-- Start -->
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
			<tr bordercolor="#FFCC33">
                <?php if($_SESSION['sid']){ ?>
                <td align="center" width="28%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">活動名稱</font></td>
				<td align="center" width="18%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">公告單位</font></td>
				<td align="center" width="18%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">報名截止日期</font></td> 
				<td align="center" width="18%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">活動日期</font></td>
			    <td align="center" width="18%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">狀態</font></td>
				<?php } 
                else{ ?>
				<td align="center" width="30%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">活動名稱</font></td>
				<td align="center" width="25%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">活動公告單位</font></td>
				<td align="center" width="25%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">報名截止日期</font></td> 
				<td align="center" width="14%" class="title_word" bgcolor="DFA7A6"><font Face="標楷體" size="5">活動日期</font></td>
				<?php } ?>

		  </tr>
			<?php 
			$now_time=date("Y-m-d H:i:s"); //檢查活動是否已下架用
				$pagesql = "SELECT COUNT(*) FROM hai_active_activity WHERE appear_start<='".$now_time."' AND appear_end >='".$now_time."'";
				$pageresult = mysql_query($pagesql);
				$r = mysql_fetch_row($pageresult);
				$numrows = $r[0];
			

  // 每頁顯示的列數
  $rowsperpage = 10;
  // 計算總共需要多少頁
  $totalpages = ceil($numrows / $rowsperpage);
 
  // 取得當前的頁數，或者顯示預設的頁數
  if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
    // 把變量的類型轉換成 int
    $currentpage = (int) $_GET['currentpage'];
  } 
  else {
    // 預設的頁數
    $currentpage = 1;
  } // end if
 
  // 若過當前的頁數大於頁數總數
  if ($currentpage > $totalpages) {
    // 把當前頁數設定為最後一頁
    $currentpage = $totalpages;
  } // end if
  // 若果當前的頁數小於 1
  if ($currentpage < 1) {
    // 把當前頁數設定為 1
    $currentpage = 1;
  } // end if
 
  // 根據當前頁數計算名單的起始位置
  $offset = ($currentpage - 1) * $rowsperpage;
		  	$result=mysql_query("SELECT * FROM `hai_active_activity` WHERE appear_start<='".$now_time."' AND appear_end >='".$now_time."' ORDER BY `sign_end` ASC  LIMIT $offset, $rowsperpage ");

			if(!$result){
			?>
            <tr bgcolor="#FFFFFF" height="500">
            	<td align="center" colspan="6"><font Face="標楷體" size="10" color="#FF0000">目前沒有任何活動</font></td>
            </tr>
		    <?php
			}
			else{
		  		 
				while($row=mysql_fetch_assoc($result)){
			  		if(++$numrows % 2 > 0){$bgcolor="F8EDED";}
                    else{$bgcolor="F2DBDB";}
			
					$row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `hai_active_activity_sign_up` WHERE activity_id=".$row['activity_id'])); //檢視活動的時效性
					
					$result_apply=mysql_fetch_array(mysql_query("SELECT `sid` FROM  `hai_active_activity_sign_up` WHERE `sid`=".$_SESSION['sid']." AND activity_id=".$row['activity_id']));

			?>
         
  			<tr height="50" bgcolor=<?php echo $bgcolor; ?>>
   			   <td align="center" valign="middle" class="r_word" style="padding-left:10pt">
   			   <a href=detail_infor_end.php?aid=<?php echo $row['activity_id'];?>><?php echo $row['name']; ?></a></td>
    		   <td  align="center" valign="middle" class="r_word"><?php echo check_dept($row['poster']); ?></td>
   			   <td  align="center" valign="middle" class="r_word"><?php echo substr($row['sign_end'],0,10); ?></td>
  			   <td  align="center" valign="middle" class="r_word"><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."<br>至<br>".substr($row['event_end'],0,10);} ?></td>
                <?php if($_SESSION['sid']){ ?>
				<td  align="center" valign="middle" class="r_word">
                	<?php if(!empty($result_apply['sid'])){
					echo "<font color='#CC0000'><B>已報名！</B></font>";
					} 
					else{
						if( $row['sign_start'] <= $now_time && $now_time <= $row['sign_end']){
						echo "<a href='sign.php?activity_id=".$row['activity_id']."'><font color='#CC0000'><B>我要報名！</B></font></a>"; 
						}else if($row['sign_end'] < $now_time && $now_time < $row['event_start']){
							echo "<a href='sign.php?activity_id=".$row['activity_id']."'><font color='#CC0000'><B>已結束報名！</B></font></a>";
						}
						else{
							echo "<font color='#CC0000'><B>尚未開始報名！</B></font>";
						}
					} ?>
			  </td>
          </tr>
          <tr align="center"><td colspan="5">
				<?php }
				else{ ?>	
          </tr>
			<?php
            	} 
				}
			}
			?>
          <tr align="center"><td colspan="4">
  <?php  
	/****** 建立分頁連結 ******/
	// 顯示的頁數範圍
	$range = 50;
 
	// 若果正在顯示第一頁，無需顯示「前一頁」連結
	if ($currentpage > 1) {
    	// 使用 << 連結回到第一頁
    	echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'>第一頁&nbsp;</a> ";
    	// 前一頁的頁數
    	$prevpage = $currentpage - 1;
    	// 使用 < 連結回到前一頁
    	echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'>上一頁&nbsp;</a> ";
	} // end if
 
	// 顯示當前分頁鄰近的分頁頁數
	for ($x = (($currentpage - $range) - 1); $x < (($currentpage + $range) + 1); $x++) {
    	// 如果這是一個正確的頁數...
    	if (($x > 0) && ($x <= $totalpages)) {
       	 	// 如果這一頁等於當前頁數...
        	if ($x == $currentpage) {
            	// 不使用連結, 但用高亮度顯示
            	echo " [<b>$x</b>] ";
            	// 如果這一頁不是當前頁數...
        	} 
			else {
            	// 顯示連結
            	echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
        	} // end else
    	} // end if
	} // end for
 
	// 如果不是最後一頁, 顯示跳往下一頁及最後一頁的連結
	if ($currentpage != $totalpages) {
    	// 下一頁的頁數
    	$nextpage = $currentpage + 1;
    	// 顯示跳往下一頁的連結
    	echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>&nbsp;下一頁</a> ";
    	// 顯示跳往最後一頁的連結
    	echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>&nbsp;最末頁</a> ";
	} // end if
/****** 完成建立分頁連結 ******/
  
 ?>
        </td></tr>
        </table>
<!-- End -->
        </td></tr>
        </table>
    </td>
  </tr>
  <tr height="66" >
	<td colspan="2" align="left"><br /><br /><strong>本活動報名系統之個人資料之蒐集、處理及利用，僅作為聯繫學生之用。本中心將依相關法令規定妥善保存。
	<a href='http://www.ccu.edu.tw/privacy.php'>(本校隱私權聲明)</a>
	</strong></td>
  </tr>
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>
</table>
</div>
</body>
</html>
