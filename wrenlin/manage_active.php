<?php
session_start();
$this_page = basename(__FILE__); 
require_once("mysql.php");
$tmp_pk=md5(rand(1,1000000));//當作臨時的PK來辨認上傳的檔案
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>航海王活動報名</title>
<link href="base.css" rel="stylesheet" type="text/css" />
<link href="swfupload/default.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.select_item {
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #000;
	border-right-color: #000;
	border-bottom-color: #000;
	border-left-color: #000;
}
.question_item {
	border: thin solid #F96;
	background-color: #FFFFAC;
	width: 450px;
}
#add_table {
	background-color: #78A4F5;
}
#edit_table {
	background-color: #E0C0C0;
}
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="Calendar/CalendarPopup.js"></SCRIPT><!-- 日期編輯器 -->
<SCRIPT LANGUAGE="JavaScript">
var cal = new CalendarPopup();//日期選單
</script>
<script language="javascript" src="jQuery.js"></script>
    <script type="text/javascript" src="uploadify/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="uploadify/swfobject.js"></script>
    <script type="text/javascript" src="uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
      $('#file_upload').uploadify({
        'uploader'  : 'uploadify/uploadify.swf',
        'script'    : 'uploadify/uploadify.php',
        'cancelImg' : 'uploadify/cancel.png',
        'folder'    : '<?php echo $upload_path;  //define in mysql.php  ?>',
		'multi'  : true,
        'auto'      : true,
		'scriptData'  : {'activity_id':'<?php echo $_SESSION['mid']; ?>'},
		'queueID'        : 'file-upload-queue',
		'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
		'onAllComplete' : function(event,data) { 
		$('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
		location.reload(true); }
      });
    });
    // ]]>
	
    </script>
        <style type="text/css">
#file_upload_section .uploadifyQueueItem {
  background-color: #FFFFFF;
  border: none;
  border-bottom: 1px solid #E5E5E5;
  font: 11px Verdana, Geneva, sans-serif;
  height: 50px;
  margin-top: 0;
  padding: 10px;
  width: 350px;
}
#file_upload_section .uploadifyError {
  background-color: #FDE5DD !important;
  border: none !important;
  border-bottom: 1px solid #FBCBBC !important;
}
#file_upload_section .uploadifyQueueItem .cancel {
  float: right;
}
#file_upload_section .uploadifyQueue .completed {
  color: #C5C5C5;
}
#file_upload_section .uploadifyProgress {
  background-color: #E5E5E5;
  margin-top: 10px;
  width: 100%;
}
#file_upload_section .uploadifyProgressBar {
  background-color: #0099FF;
  height: 3px;
  width: 1px;
}
#file_upload_section #file-upload-queue {
	border: 1px solid #666;
	margin:auto;
	height: 213px;
	margin-bottom: 10px;
	width: 370px;
}				

        </style>

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
		$('#q'+qes_id+'_selector').attr("disabled", true); //開放式問答不須選項
	}else{
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
		qes='<p>詢問事項'+i+'<textarea name="q'+i+'_qes" cols="45" rows="3" /></textarea>';
		qes+='<select id="q'+i+'_select_qes_type" name="q'+i+'_select_qes_type" onchange="init_ans_desc(\''+i+'\');"><option value="S">單選</option><option value="M">複選</option><option value="D">開放性問答</option></select></p>';
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

<body>
<div id="container">
  <?php if($_GET['activity_id']){ //有代表是看活動內容
	  $row=mysql_fetch_array(mysql_query("SELECT *  FROM  `activity` WHERE activity_id=".$_GET['activity_id']));
	  ?>
</a>
<p align="center"><a href="manage_active.php">回活動列表</a></p>
<div style="margin:15px">
  <p align="center"><?php echo $row['name']; ?></p>
  <p align="left"> 活動時間：<?php echo substr($row['event_start'],0,16)."~".substr($row['event_end'],0,16); ?><br />
    報名截止日期：<?php echo substr($row['end_date'],0,16); ?>止 名額：<?php echo $row['max']; ?>位<br />
    活動說明：<br />
    <?php echo nl2br($row['intro']); ?></p>
</div>
<p align="center"><?php echo $row['name']; ?>已報名名單</p>
<table width="844" border="0" align="center">
  <tr>
    <td width="100" class="word_b_w">姓名/電話</td>
    <td width="62" class="word_b_w">學號</td>
    <td width="37" class="word_b_w">便當</td>
    <td width="201" class="word_b_w">系所年級/Email</td>
    <td width="356" class="word_b_w">選項</td>
    <td width="62" class="word_b_w">&nbsp;</td>
  </tr>
  <?php 
		  $result=mysql_query("SELECT * FROM  `student`,`activity_sign_up` WHERE activity_sign_up.sid=student.sid and activity_id=".$_GET['activity_id']);
		  while($row=mysql_fetch_array($result)){
		  ?>

  <tr>
    <td><?php echo $row['name']." "; if($row['sex']=="M"){ echo "男";}else{ echo "女"; } ?></td>
    <td><?php echo $row['sid']." "; ?></td>
    <td><?php echo $row['food']; ?></td>
    <td><?php echo $row['dept']." ".$row['grade']; ?></td>
    <td rowspan="2"><?php 
		  //處理學生選項
		  $result_qes=mysql_query("select * from activity_question where activity_id='".$_GET['activity_id']."'");//選出問題
		  while($row_qes=mysql_fetch_array($result_qes)){
			  echo  $row_qes['question']."<br>";
			  $sql="SELECT * 
						FROM  `activity_sign_up_select` S,  `activity_selection` I
						WHERE I.activity_id = S.activity_id
						AND S.question_num = I.question_num
						AND S.select_num = I.select_num and S.activity_id='".$_GET['activity_id']."' and S.question_num='".$row_qes['question_num']."'";
			   $result_select=mysql_query($sql);
				while($row_select=mysql_fetch_array($result_select)){
					echo  $row_select['item'].", "; 
			  	}
				echo "<br>";
		  }
		  ?></td>
    <td rowspan="2" align="center"><input type="submit" name="button3" id="button3" value="修改" />
      <br />
      <a href="manage_active_do.php?del_sign=<?php echo $row['sign_id']; ?>&amp;activity_id=<?php echo $row['activity_id']; ?>">刪除</a></td>
    </tr>
  <tr>
    <td colspan="2"><?php echo $row['phone']; ?></td>
    <td>&nbsp;</td>
    <td><?php echo $row['email']; ?></td>
    </tr>  <tr>
    <td colspan="6"><hr /></td>
    </tr>
  <?php } ?>
</table>
<p>
  <?php }else if($_GET['add']){  ?>
</p>
<p align="center">新增活動</p>
<form action="manage_active_do.php?add_activity=1" method="post" enctype="multipart/form-data" name="activity_form" id="activity_form">
<input name="tmp_pk" type="hidden" value="<?php echo $tmp_pk;?>" />
<table id="add_table" border="0" cellpadding="0" cellspacing="1" align="center">
  <tr>
    <td width="183"><div align="right"> 活動名稱</div></td>
    <td width="505" valign="top" ><input name="activity_name" type="text" id="activity_name" size="60" /></td>
  </tr>
  <tr>
    <td align="right" valign="top">活動介紹</td>
    <td><textarea name="introduce" id="introduce" cols="60" rows="10"></textarea></td>
  </tr>
  <tr>
    <td align="right">報名期間</td>
    <td><a href="#" onclick="cal.select(document.forms['activity_form'].sign_start_date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">
    <input type="text" name="sign_start_date" id="sign_start_date" size="10"/>
    </a>
      <select name="sign_start_time_to_hour">
        <option value="07">7</option>
        <option value="08" selected="selected">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="22">23</option>
        <option value="22">24</option>
      </select>
:
<select name="sign_start_time_to_min">
  <option value="00">00</option>
  <option value="05">05</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25">25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
</select>
~ <a href="#" onclick="cal.select(document.forms['activity_form'].sign_end_date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">
<input type="text" name="sign_end_date" id="sign_end_date" size="10"/>
</a>
<select name="sign_end_time_to_hour">
  <option value="07">7</option>
  <option value="08">8</option>
  <option value="09">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17" selected="selected">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="22">23</option>
  <option value="22">24</option>
</select>
:
<select name="sign_end_time_to_min" id="sign_end_time_to_min">
  <option value="00">00</option>
  <option value="05">05</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25">25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
</select></td>
  </tr>
  <tr>
    <td align="right">活動上架期間</td>
    <td><a href="#" onclick="cal.select(document.forms['activity_form'].appear_start_date,'anchor3','yyyy-MM-dd'); return false;" name="anchor3" id="anchor3">
    <input type="text" name="appear_start_date" id="appear_start_date" size="10"/>
    </a>
      <select name="appear_start_time_to_hour">
        <option value="07">7</option>
        <option value="08" selected="selected">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="22">23</option>
        <option value="22">24</option>
      </select>
:
<select name="appear_start_time_to_min">
  <option value="00">00</option>
  <option value="05">05</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25">25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
</select>
~ <a href="#" onclick="cal.select(document.forms['activity_form'].appear_end_date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">
<input type="text" name="appear_end_date" id="appear_end_date" size="10"/>
</a>
<select name="appear_end_time_to_hour">
  <option value="07">7</option>
  <option value="08">8</option>
  <option value="09">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17" selected="selected">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="22">23</option>
  <option value="22">24</option>
</select>
:
<select name="appear_end_time_to_min" id="end_time_to_min">
  <option value="00">00</option>
  <option value="05">05</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25">25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
</select></td>
  </tr>
  <tr>
    <td align="right">活動日期</td>
    <td><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].event_start_date,'anchor5','yyyy-MM-dd'); return false;" name="anchor5" id="anchor5">
      <input type="text" name="event_start_date" id="event_start_date" size="10"/>
      </a>
      <select name="event_start_hour">
        <option value="07">7</option>
        <option value="08" selected="selected">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="22">23</option>
        <option value="22">24</option>
      </select>
      :
      <select name="event_start_min" id="event_start_min">
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
      ~ <a href="#" onclick="cal.select(document.forms['activity_form'].event_end_date,'anchor6','yyyy-MM-dd'); return false;" name="anchor6" id="anchor6">
        <input type="text" name="event_end_date" id="event_end_date" size="10"/>
        </a>
      <select name="event_end_hour" id="event_end_hour">
        <option value="07">7</option>
        <option value="08">8</option>
        <option value="09">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17" selected="selected">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="22">23</option>
        <option value="22">24</option>
      </select>
      :
      <select name="event_end_min" id="event_end_min">
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td><div align="right">人數限制</div></td>
    <td><div align="left">
      <input name="event_people" id="event_people" type="text"  size="5" />
      <b id="event_people_check2"></b><b id="event_people_sum_check2"></b> 人</div></td>
  </tr>
  <tr>
    <td height="22" align="right" valign="top">是否提供便當 </td>
    <td><input type="radio" name="need_food" value="1" />
      是
      <input type="radio" name="need_food" value="0" />
      否 </td>
  </tr>
  <tr>
    <td align="right" valign="top">新增活動選項</td>
    <td align="left" valign="top">
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
      <div id="qes_section"><p>&nbsp;</p></div></td>
  </tr>
  <tr>
  <td align="right">檔案上傳</td>
    <td>
  </td>
  </tr>

</table>
<p align="center">
  <input type="submit" name="button2" id="button2" value="送出" />
</p>
</form>
<p>&nbsp; </p>
<?php }else if($_GET['edit']){ ?>
<p>&nbsp;</p>
<p align="center">修改活動 </p>
<form name="activity_form" id="activity_form" method="post" action="manage_active_do.php?edit_activity=1">
<input name="activity_id" type="hidden" value="<?php echo $_GET['edit'];?>" />
<?php 
	$row=mysql_fetch_array(mysql_query("SELECT * FROM  `activity` WHERE activity_id=".$_GET['edit'])); 
?>
  <table id="edit_table" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr>
      <td width="183"><div align="right"> 活動名稱</div></td>
      <td width="505" valign="top" ><input name="edit_activity_name" type="text" id="edit_activity_name" size="60" value="<?php echo $row['name']; ?>"/></td>
    </tr>
    <tr>
      <td align="right" valign="top">活動介紹</td>
      <td><textarea name="edit_introduce" id="edit_introduce" cols="60" rows="10"><?php echo $row['intro'];?></textarea></td>
    </tr>
    <tr>
      <td align="right">報名期間</td>
      <td><a href="#" onclick="cal.select(document.forms['activity_form'].sign_start_date,'edit_anchor1','yyyy-MM-dd'); return false;" name="edit_anchor1" id="edit_anchor1">
        <input type="text" name="edit_sign_start_date" id="edit_sign_start_date" size="10" value="<?php echo substr($row['sign_start'],0,10);?>"/>
        </a>
        <select name="edit_sign_start_time_to_hour">
        <option value="<?php echo substr($row['sign_start'],11,2);?>"><?php echo substr($row['sign_start'],11,2);?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_sign_start_time_to_min">
        <option value="<?php echo substr($row['sign_start'],14,2);?>"><?php echo substr($row['sign_start'],14,2);?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select>
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].sign_end_date,'edit_anchor2','yyyy-MM-dd'); return false;" name="edit_anchor2" id="edit_anchor2">
          <input type="text" name="edit_sign_end_date" id="edit_sign_end_date" size="10" value="<?php echo substr($row['sign_end'],0,10);?>"/>
          </a>
        <select name="edit_sign_end_time_to_hour">
         <option value="<?php echo substr($row['sign_end'],11,2); ?>"><?php echo substr($row['sign_end'],11,2); ?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_sign_end_time_to_min" id="edit_sign_end_time_to_min">
        <option value="<?php echo substr($row['sign_end'],14,2); ?>"><?php echo substr($row['sign_end'],14,2); ?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select></td>
    </tr>
    <tr>
      <td align="right">活動上架期間</td>
      <td><a href="#" onclick="cal.select(document.forms['activity_form'].appear_start_date,'edit_anchor3','yyyy-MM-dd'); return false;" name="edit_anchor3" id="edit_anchor3">
        <input type="text" name="edit_appear_start_date" id="edit_appear_start_date" size="10" value="<?php echo substr($row['appear_start'],0,10);?>"/>
        </a>
        <select name="edit_appear_start_time_to_hour">
        <option value="<?php echo substr($row['appear_start'],11,2); ?>"><?php echo substr($row['appear_start'],11,2); ?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_appear_start_time_to_min">
        <option value="<?php echo substr($row['appear_start'],14,2); ?>"><?php echo substr($row['appear_start'],14,2); ?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select>
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].appear_end_date,'edit_anchor4','yyyy-MM-dd'); return false;" name="edit_anchor4" id="edit_anchor4">
          <input type="text" name="edit_appear_end_date" id="edit_appear_end_date" size="10" value="<?php echo substr($row['appear_end'],0,10); ?>"/>
          </a>
        <select name="edit_appear_end_time_to_hour">
         <option value="<?php echo substr($row['appear_end'],11,2); ?>"><?php echo substr($row['appear_end'],11,2); ?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_appear_end_time_to_min" id="edit_appear_end_time_to_min">
        <option value="<?php echo substr($row['appear_end'],14,2); ?>"><?php echo substr($row['appear_end'],14,2); ?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select></td>
    </tr>
    <tr>
      <td align="right">活動日期</td>
      <td><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].event_start_date,'edit_anchor5','yyyy-MM-dd'); return false;" name="edit_anchor5" id="edit_anchor5">
        <input type="text" name="edit_event_start_date" id="edit_event_start_date" size="10" value="<?php echo substr($row['event_start'],0,10); ?>"/>
        </a>
        <select name="edit_event_start_hour">
        <option value="<?php echo substr($row['event_start'],11,2); ?>"><?php echo substr($row['event_start'],11,2); ?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_event_start_min" id="edit_event_start_min">
        <option value="<?php echo substr($row['event_start'],14,2); ?>"><?php echo substr($row['event_start'],14,2); ?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select>
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].event_end_date,'edit_anchor6','yyyy-MM-dd'); return false;" name="edit_anchor6" id="edit_anchor6">
          <input type="text" name="edit_event_end_date" id="edit_event_end_date" size="10" value="<?php echo substr($row['event_end'],0,10); ?>"/>
          </a>
        <select name="edit_event_end_hour" id="edit_event_end_hour">
        <option value="<?php echo substr($row['event_end'],11,2); ?>"><?php echo substr($row['event_end'],11,2); ?></option>
          <option value="07">7</option>
          <option value="08">8</option>
          <option value="09">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="22">23</option>
          <option value="22">24</option>
        </select>
        :
        <select name="edit_event_end_min" id="edit_event_end_min">
        <option value="<?php echo substr($row['event_end'],14,2); ?>"><?php echo substr($row['event_end'],14,2); ?></option>
          <option value="00">00</option>
          <option value="05">05</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
          <option value="25">25</option>
          <option value="30">30</option>
          <option value="35">35</option>
          <option value="40">40</option>
          <option value="45">45</option>
          <option value="50">50</option>
          <option value="55">55</option>
        </select>
      </div></td>
    </tr>
    <tr>
      <td><div align="right">人數限制</div></td>
      <td><div align="left">
        <input name="edit_event_people" id="edit_event_people" type="text"  size="5" value="<?php echo $row['max'];?>"/>人</div></td>
    </tr>
    <tr>
      <td height="22" align="right" valign="top">是否提供便當 </td>
      <td><input type="radio" name="edit_need_food" value="1" <?php echo $row['need_food']?'checked="checked"':'';?>/>
        是
        <input name="edit_need_food" type="radio" value="0" <?php echo $row['need_food']?'':'checked="checked"';?> />
        否 </td>
    </tr>
    <tr>
      <td height="108" align="right" valign="top">活動選項</td>
      <td align="left" valign="top"><p>
        <?php
      $result_qes=mysql_query("select * from activity_question where activity_id=".$_GET['edit']);
	  while($row_qes=mysql_fetch_array($result_qes)){  ?>
		</p>
        <div id="edit_qes_section">
          <div id="q_ans_section" class="question_item">
            <p>詢問事項:<?php echo $row_qes['question'];?></p>
            <p>選項:<br />
              <?php 
		$result_select=mysql_query("select * from activity_selection where activity_id=".$_GET['edit']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
		while($row_select=mysql_fetch_array($result_select)){ ?>
              
              <?php echo $row_select['item'];?><br />
              <?php }?>
              </p>
            </p>
          </div>
		<br />
        <?php } ?>
        </div></td>
    </tr>
    <tr><td align="right">上傳檔案</td><td>
    <?php 
		$result_file=mysql_query("SELECT * FROM `activity_file` WHERE cover=0 AND activity_id='".$_GET['edit']."'");
		while($row=mysql_fetch_array($result_file)){
			?>
			<a href="<?php echo "upload/".$row['f_name']; ?>"><?php echo $row['f_name']; ?></a><br>
		<?php
        }
	?>
    </td></tr>
  </table>
  <p align="center">
<!--    <input type="submit" name="button" id="button" value="送出" /> -->
  <input type="submit" name="button" id="button" value="送出" />
  </p>
</form>
<p align="center"><a href="index.php">回首頁</a></p>
<?php }else{ ?>
<p align="center">活動報名管理介面</p>
<table width="972" border="0" align="center">
  <tr class="word_b_w">
    <td width="110">&nbsp;</td>
    <td width="178">活動名稱</td>
    <td width="181">截止時間</td>
    <td width="174">活動期間</td>
    <td width="153">限額</td>
    <td width="85">報名人數</td>
    <td width="61" align="center">&nbsp;</td>
  </tr>
  <?php 
		  $result=mysql_query("SELECT * FROM  `activity` ORDER BY  `event_end` ASC ");
		  while($row=mysql_fetch_array($result)){
			  $row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
			  $row_img=mysql_fetch_array(mysql_query("SELECT * FROM activity_file WHERE cover=1 AND activity_id=".$row['activity_id']));
		  ?>
  <tr>
    <td class="word"><?php if(!empty($row_img['f_name'])){?><img src="<?php echo "upload/".$row_img['f_name'];?>" width="110" height="138" /><?php }?></td>
    <td class="word"><a href="<?php echo $this_page."?activity_id=".$row['activity_id']; ?>"><?php echo $row['name']; ?></a></td>
    <td class="word"><?php echo substr($row['end_date'],0,16); ?></td>
    <td class="word"><?php echo substr($row['event_start'],0,16)."~".substr($row['event_end'],0,16); ?></td>
    <td class="word"><?php echo $row['max']; ?></td>
    <td class="word"><?php echo $row_count[0]; ?></td>
    <td class="word"><p><a href="manage_active_do.php?del_activity=<?php echo $row['activity_id']; ?>">刪除</a><br />
      <a href="<?php echo $this_page."?edit=".$row['activity_id']; ?>">修改</a></td>
  </tr>
  <tr>
    <td colspan="7" class="word"><hr /></td>
  </tr>
  <?php } ?>
</table>
<p align="center"><a href="<?php echo $this_page;?>?add=1">新增活動</a></p>
<p>
  <?php } ?>
</p>
<p>&nbsp; </p>
<p></p>
</div>
</body>
</html>