<?php
session_start();
$this_page = basename(__FILE__); 
if(empty($_SESSION['admin'])){
	echo "請登入";
	exit;
}
require_once("mysql.php");
require_once("user_auth.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_活動管理</title>

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

</head>

<SCRIPT LANGUAGE="JavaScript" SRC="Calendar/CalendarPopup.js"></SCRIPT><!-- 日期編輯器 -->
<SCRIPT LANGUAGE="JavaScript">
var cal = new CalendarPopup();//日期選單
</script>
<script language="javascript" src="jQuery.js"></script>
<script type="text/javascript" src="swfupload/swfupload.js"></script>
<script type="text/javascript" src="swfupload/swfupload.queue.js"></script>
<script type="text/javascript" src="swfupload/fileprogress.js"></script>
<script type="text/javascript" src="swfupload/handlers.js"></script>
<script src="./plugin/jquery-validation-1.9.0/lib/jquery.js" type="text/javascript"></script>
<script src="./plugin/jquery-validation-1.9.0/lib/jquery.metadata.js" type="text/javascript"></script>
<script type="text/javascript" src="./plugin/jquery-validation-1.9.0/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){
	$("#activity_form").validate({
errorPlacement: function (error, element) {
    if (element.is(':radio') || element.is(':checkbox')) {
        var eid = element.attr('name');
        $('input[name=' + eid + ']:last').next().after(error);
    } else {
        error.insertAfter(element);
    }
}
});
});
</script>
<script language="javascript">

function init_ans(qes_id){

	$('#q'+qes_id+'_ans_section').empty();
	
//	var ans_num=document.getElementById(qes_id+'_selector').options[document.getElementById(qes_id+'_selector').options.selectedIndex].value;

	for(var i=1;i<=$('#q'+qes_id+'_selector').val();i++){	
		$('#q'+qes_id+'_ans_section').append('選項'+i+':<input type="text" name="q'+qes_id+'_ans[]" /><br>');	
	}
}

function init_ans_desc(qes_id){
	if($('#q'+qes_id+'_select_qes_type').val()=="D"){
		$('#q'+qes_id+'_ans_section').empty();
		$('#q'+qes_id+'_selector').attr("disabled", true);
		$('#q'+qes_id+'_show_image').attr("style","visibility:visible");
		$('#q'+qes_id+'_show_image').attr("src","./image/answer.png"); //開放式問答不須選項
	}else{
		$('#q'+qes_id+'_show_image').empty();
		$('#q'+qes_id+'_selector').removeAttr("disabled");//非開放式要打開問題數選項
	}
	
}
function del_ans(r,ans_table){
	var i;
	i=r.parentNode.rowIndex;
	document.getElementById(ans_table).deleteRow(i);
}

function init_qes(){
	
	var qes="";
	var sel="";
	
	
	$('#qes_section').empty();
	
	for(var s=1;s<=10;s++){//問題答案上限
		sel+='<option value="'+s+'">'+s+'個</option>';
	}
	
	for(var i=1;i<=$('#qes_num').val();i++){
		qes='<p>問題標題'+i+'：<br><textarea name="q'+i+'_qes" cols="45" rows="1"></textarea></p>';
		qes+='<p>問題類型：<select id="q'+i+'_select_qes_type" name="q'+i+'_select_qes_type" onchange="init_ans_desc(\''+i+'\');"><option value="S">單選</option><option value="M">複選</option><option value="D">開放性問答</option></select></p>';
		qes+='<img id="q'+i+'_show_image" style="visibility:hidden">';
		qes+='<p>問題選項：<select name="q'+i+'_selector" id="q'+i+'_selector" onchange="init_ans(\''+i+'\');">'+sel+'</select><br /></p>';

		qes+='<div id="q'+i+'_ans_section"><p></p></div>';
		$('#qes_section').append('<p></p>');
		$('#qes_section').append('<div class="question_item">'+qes+'</div>');
		$('#qes_section').append('<p></p>');
		qes="";
	}
	
}

function del_qes(r){
	i=r.parentNode.parentNode.parentNode.rowIndex;
	document.getElementById("qes_table").deleteRow(i);
}	
</script>

<script type="text/javascript">
  window.onload = function(){
    document.getElementById("activity_form").onsubmit = 
      function(){
        var s1 = this.sign_start_date.value;//報名的起始時間
        var s2 = this.sign_end_date.value;//報名的結束時間
        var a1 = this.appear_start_date.value;//活動上架的起始時間
        var a2 = this.appear_end_date.value;//活動上架的結束時間
        var e1 = this.event_start_date.value;//活動的起始時間
        var e2 = this.event_end_date.value;//活動的結束時間
        
        if(!compareDate(s1,s2)) {alert("報名的起始時間大於結束時間");return false;}  
        if(!compareDate(a1,a2)) {alert("活動上架的起始時間大於結束時間");return false;} 
        if(!compareDate(e1,e2)) {alert("活動的起始時間大於結束時間");return false;}                   
      };
  }

  function compareDate(d1,d2){
    var arrayD1 = d1.split("-");
    var date1 = new Date(arrayD1[0],arrayD1[1],arrayD1[2]);
    var arrayD2 = d2.split("-");
    var date2 = new Date(arrayD2[0],arrayD2[1],arrayD2[2]); 
    if(date1 > date2) return false;        
      return true;
  } 
</script>

<body onload="MM_preloadImages('image/choose/22.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg" id="tablegb">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td>
		<?php 
		if($_SESSION['admin']){
			echo '&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5">'.$_SESSION['admin']."，您好</font>";
		?>
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		?>
  	</td>
  </tr>
  
  <tr>
  	<td>
			<table id="___01" height="120" border="0" cellpadding="0" cellspacing="0" align="center">
  		 	  <tr>
				<td><img src="image/choose/00.png" width="12" height="120" /></td>
				<td><img src="image/choose/81.gif" width="224" height="120" alt="活動列表" /></a></td>
				<td><a href="manage_add.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image62','','image/choose/82.gif',1)"><img src="image/choose/72.gif" alt="新增活動" width="224" height="120" id="Image62" /></a></td>
				<td><img src="image/choose/03.gif" width="220" height="120" /></td>
				<td><img src="image/choose/04.gif" width="223" height="120" /></td>
				<td><img src="image/choose/05.gif" width="102" height="120" /></td>
  		 	  </tr>
			</table>
	</td>
  </tr>
  <tr>
  	<td>
			<table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
            <tr valign="top"><td>
<!-- Start -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
  <tr class="word_b_w">
    <!--<td width="10%" class="title_word" bgcolor="#FFF5D7" align="center">封面</td> -->
    <td height="40px" width="19%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>活動名稱</b></center></font></td>
	<td height="40px" width="17%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>發布單位</b></center></font></td>
    <td height="40px" width="17%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>報名截止日</b></center></font></td>
    <td height="40px" width="11%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>活動日期</b></center></font></td>
	<td height="40px" width="17%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>已報名／限額</b></center></font></td>
    <td height="40px" width="13%" class="title_word" bgcolor="DFA7A6" align="center"><font face="標楷體" size="5"><center><b>活動狀態</b></center></font></td>
    <td height="40px" width="6%" align="center" class="title_word" bgcolor="DFA7A6">&nbsp;</td>
  </tr>
   <?php 
  $now_time=date("Y-m-d H:i:s"); //檢查活動是否已下架用 
 
  $pagesql = "SELECT COUNT(*) FROM hai_active_activity";
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
  $result=mysql_query("SELECT * FROM  `hai_active_activity`  ORDER BY`activity_id`DESC LIMIT $offset, $rowsperpage ");
  while($row=mysql_fetch_assoc($result)){

	$row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `hai_active_activity_sign_up` WHERE activity_id='".$row['activity_id']."'",$main_mysql_link));
	//$row_img=mysql_fetch_array(mysql_query("SELECT * FROM activity_file WHERE cover=1 AND activity_id=".$row['activity_id']));
		
	if(++$numrows % 2 > 0){$bgcolor="F8EDED";}
    else{$bgcolor="F2DBDB";}
  
		  ?>     
  <tr bgcolor=<?php echo $bgcolor; ?>>
    <td class="word" align="center"><a href=manage_detail.php?activity_id=<?php echo $row['activity_id'];?>><?php echo $row['name']; ?></a></td>
	<td class="word" align="center"><?php echo check_dept($row['poster']);?></td>
    <td class="word" align="center"><?php echo substr($row['sign_end'],0,10); ?></td>
    <td class="word" align="center"><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."<br>".substr($row['event_end'],0,10);} ?></td>
	<td class="word" align="center"><?php echo $row_count[0];echo "／";echo $row['max']; ?></td>
	<td class="word" align="center"><?php if($row['sign_end']<=$now_time){ echo "<font color='#CC0000'><B>結束報名</B></font>"; } elseif ($row['sign_start']>$now_time){ echo "<font color='#696969'><B>尚未開放報名</B></font>"; }else{echo "<font color='#0000CC'><B>開放報名中</B></font>"; }?><br>
	  <?php if($row['appear_end']<=$now_time){ echo "<font color='#CC0000'><B>OffLine</B></font>"; } elseif ($row['appear_start']>$now_time){ echo "<font color='#696969'><B>OffLine</B></font>"; }else{echo "<font color='#00BE02'><B>OnLine</B></font>"; }?><br>
	  <?php if($row['event_end']<=$now_time){ echo "<font color='#CC0000'><B>活動已結束</B></font>"; } elseif ($row['event_start']>$now_time){ echo "<font color='#696969'><B>活動尚未開始</B></font>"; }else{echo "<font color='#0000CC'><B>活動進行中</B></font>"; }?></td>
    <td class="r_word" align="center"><p><a href="manage_active_do.php?del_activity=<?php echo $row['activity_id']; ?>" onclick="return window.confirm('確認刪除此活動？');">刪除</a><br />
    <a href=manage_edit.php?id=<?php echo $row['activity_id'];?>>修改</a><br />
    <?php if($row['event_end']<=$now_time){ echo "<a href=manage_attend.php?activity_id=".$row['activity_id'].">簽到</a><br />"; }  else {echo "<p>";} ?>
    <a href="out_excel.php?aid=<?php echo $row['activity_id']; ?>">匯出</a></td>
  </tr>
  <?php } ?>
  <tr align="center"><td colspan="7">
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
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>
</table>
</div>
</body>
</html>