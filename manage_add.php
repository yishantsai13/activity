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
<title>活動報名系統_新增活動</title>

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
		qes='<p>問題標題'+i+'：<br><textarea name="q'+i+'_qes" cols="100" rows="1"></textarea></p>';
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

<body onload="MM_preloadImages('image/choose/22.gif','image/choose/81.gif','image/login2.png','image/logout2.png')">
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
				<td><a href="manage.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image61','','image/choose/81.gif',1)"><img src="image/choose/71.gif" alt="活動管理" width="224" height="120" id="Image61" /></a></a></td>
				<td><img src="image/choose/82.gif" width="224" height="120" alt="新增活動" /></td>
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
            <tr valign="middle"><td>
<!-- Start -->
            <form action="manage_active_do.php" method="post" enctype="multipart/form-data" name="activity_form" id="activity_form">
			<input name="add_activity" type="hidden" value="1" />
            <table width="97%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
  <tr>
    <td width="8%"><div align="right"> 活動名稱</div></td>
    <td width="2%">&nbsp;</td>
    <td width="90%" valign="top" ><input name="activity_name" type="text" id="activity_name" size="60" class="required" /></td>
  </tr>
  <tr>
    <td width="8%" align="right" valign="top">活動介紹</td>
    <td width="2%" align="right" valign="top">&nbsp;</td>
    <td width="90%"><textarea name="introduce" id="introduce" cols="46" rows="10" class="required" ></textarea></td>
  </tr>
  <tr>
    <td width="8%" align="right">報名期間</td>
    <td width="2%" align="right">&nbsp;</td>
    <td width="90%"><a href="#" onclick="cal.select(document.forms['activity_form'].sign_start_date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">
    	<input type="text" name="sign_start_date" id="sign_start_date" size="10" class={required:true,dateISO:true}/></a>
		至
        <a href="#" onclick="cal.select(document.forms['activity_form'].sign_end_date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">
		<input type="text" name="sign_end_date" id="sign_end_date" size="10" class={required:true,dateISO:true}/></a>
	</td>
  </tr>
  <tr>
    <td width="8%" align="right" valign="middle"><p>活動上架期間</p></td>
    <td width="2%" align="right" valign="middle">&nbsp;</td>
    <td width="90%"><a href="#" onclick="cal.select(document.forms['activity_form'].appear_start_date,'anchor3','yyyy-MM-dd'); return false;" name="anchor3" id="anchor3">
    	<input type="text" name="appear_start_date" id="appear_start_date" size="10"/ class={required:true,dateISO:true}></a>
		至
        <a href="#" onclick="cal.select(document.forms['activity_form'].appear_end_date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">
		<input type="text" name="appear_end_date" id="appear_end_date" size="10" class={required:true,dateISO:true} /></a>
	</td>
  </tr>
  <tr>
    <td width="8%" align="right">活動日期</td>
    <td width="2%" align="right">&nbsp;</td>
    <td width="90%"><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].event_start_date,'anchor5','yyyy-MM-dd'); return false;" name="anchor5" id="anchor5">
        <input type="text" name="event_start_date" id="event_start_date" size="10" class={required:true,dateISO:true} /></a>
        至
        <a href="#" onclick="cal.select(document.forms['activity_form'].event_end_date,'anchor6','yyyy-MM-dd'); return false;" name="anchor6" id="anchor6">
        <input type="text" name="event_end_date" id="event_end_date" size="10" class={required:true,dateISO:true} /></a>
    </div></td>
  </tr>
  <tr>
    <td width="8%"><div align="right">人數限制</div></td>
    <td width="2%">&nbsp;</td>
    <td width="90%"><div align="left">
        <input name="event_people" id="event_people" type="text"  size="5" class={required:true}/>
        <b id="event_people_check2"></b><b id="event_people_sum_check2"></b> 人</div>
    </td>
  </tr>
  <tr>
    <td width="8%" height="22" align="right" valign="top">是否提供便當 </td>
    <td width="2%" align="right" valign="top">&nbsp;</td>
    <td width="90%"><input type="radio" name="need_food" value="1" class="required" />
      是
      <input type="radio" name="need_food" value="0" class="required" />
      否
	  <label for="error"></label></td>
  </tr>
  <tr>
    <td width="8%" height="108" align="right" valign="top">新增活動選項</td>
    <td width="2%" align="right" valign="top">&nbsp;</td>
    <td width="90%" align="left" valign="top">
        <p>詢問題數
          <select name="qes_num" id="qes_num" onchange="init_qes();">
            <option>請選擇</option>
            <option value="0">不需問題</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        題</p>
        <div id="qes_section"><p>&nbsp;</p></div>
        <p>&nbsp;</p></td>
  </tr>
        </table>
<p align="center">
  <input type="submit" name="button2" id="button2" value="送出並前往上傳相關檔案頁面" />
</p>
</form>
<p>&nbsp; </p>
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