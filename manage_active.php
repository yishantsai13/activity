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
<title>航海王活動報名</title>
<link href="base.css" rel="stylesheet" type="text/css" />
<link href="swfupload/default.css" rel="stylesheet" type="text/css" />
<style type="text/css">

body {
	background-image: url(image/123.jpg);
	background-repeat: repeat;
}

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

<script type="text/javascript">
<!--
/* 宣告與 HTML 按鈕集圖片相對應的 Image 變數，
並指明其圖形檔之位址。 */
var icon1=new Image();
icon1.src="image/to_index.png"; //原本的
var icon1a=new Image();  //變深的
icon1a.src="image/to_index2.png";

/* 宣告與 分類頁 按鈕集圖片相對應的 Image 變數，
並指明其圖形檔之位址。 */
var icon2=new Image();
icon2.src="image/view_act.png";
var icon2a=new Image();
icon2a.src="image/view_act2.png";

/* 宣告與 分類頁 按鈕集圖片相對應的 Image 變數，
並指明其圖形檔之位址。 */
var icon3=new Image();
icon3.src="image/new_act.png";
var icon3a=new Image();
icon3a.src="image/new_act2.png";

/* 宣告與 分類頁 按鈕集圖片相對應的 Image 變數，
並指明其圖形檔之位址。 */
var icon4=new Image();
icon4.src="image/ready_act.png";
var icon4a=new Image();
icon4a.src="image/ready_act2.png";

/* 執行更換 IMG Tag 圖片的 JavaScript 自訂函數
參數功能：
imgname:指明要更換那一個 IMG Tag
gifname:要更換成那個圖形的變數名稱
*/
function MouseThrow(imgname,gifname)
{
    /* 如果 IE or NC 在 4.0 以上才執行 */
    if (navigator.appVersion.substring(0,1) >= 4)
    {
        /* Img Tag 的 src 屬性就是圖片的所在位址，改變 src 
           即可達成更換圖片的效果。 */
        document.images[imgname].src=eval(gifname+".src");
    }
    else
    {
        alert("!!抱歉!!\n你必須使用 IE or NC 4.0 以上的瀏覽器");
    }
}
//-->
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

<body>

<!-- 如果有activity_id代表是看活動內容 -->
<div id="container">
  <?php if($_GET['activity_id']){ 
	  $row=mysql_fetch_array(mysql_query("SELECT *  FROM  `activity` WHERE activity_id=".$_GET['activity_id']));
	  $row_img=mysql_fetch_array(mysql_query("SELECT * FROM activity_file WHERE cover=1 AND activity_id=".$_GET['activity_id']));
	  ?>
<div style="margin:15px">
  <table border="0" cellpadding="0" cellspacing="0" width="780" align="center">
  <tr><td colspan="5" align="center"><img name="top4.jpg" src="image/top4.jpg" width="780" height="205" border="0" id="top4" alt="" /></td></tr>
  <tr>
    <td colspan="5" align="right">
      <a href="manage_active.php" onmouseout="MouseThrow('button2','icon2')" onmouseover="MouseThrow('button2','icon2a')"><img src="image/view_act.png" alt="活動列表" name="button2" width="110" height="50" border="0" id="view_act" /></a>
      <a href="index.php" onmouseout="MouseThrow('button1','icon1')" onmouseover="MouseThrow('button1','icon1a')"><img src="image/to_index.png" alt="返回首頁" name="button1" width="110" height="50" border="0" id="to_index" /></a>
    </td>
  </tr>
    <tr bgcolor="#FFFFFF">
    <td rowspan="7" width="2%"></td>
 	  <td width="50%" align="center" rowspan="7" scope="col"><?php if(!empty($row_img['fname'])){?><img src="<?php echo "./".$row_img['path'];?>" width="300" height="400"  /><?php }?></td>
      <td width="15%" align="right" class="m_word">活動名稱：</td>
      <td width="31%"><?php echo $row['name']; ?></td>
      <td rowspan="7" width="2%"></td>
      </tr><tr bgcolor="#FFFFFF">
      <td width="15%" align="right" class="m_word">活動日期：</td>
      <td width="35%"><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."至".substr($row['event_end'],0,10);} ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" class="m_word">報名截止日期：</td>
      <td><?php echo substr($row['sign_end'],0,10); ?>止</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" class="m_word">名額：</td>
      <td><?php echo $row['max']; ?>位</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" class="m_word" valign="top">活動說明：
        </td>
      <td><?php echo nl2br($row['intro']); ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" class="m_word" valign="top">活動檔案附件：
        </td>
      <td valign="top"><?php 
		$result_filelist=mysql_query("SELECT * FROM activity_file WHERE  activity_id=".$_GET['activity_id']);
		while($row_filelist=mysql_fetch_array($result_filelist)){
		  if(!empty($row_filelist['fname'])){
		  ?>
		  <a href="<?php echo $row_filelist['path'];?>"><?php echo $row_filelist['fname'];?></a><br>
		  <?php  }}?>
	  </td>
    </tr>
	</table>
  </p>
</div>
<p align="center"></p>
<table width="780" border="0" align="center">
<tr><td><img name="center1.jpg" src="image/center1.jpg" width="780" height="40" border="0" id="center1" alt="" /></td></tr>
<tr>
  <td width="100" class="word_b_w"><table width="780" border="0" align="center">
    <tr bgcolor="#CCCCCC">
      <td width="100" class="word_b_w">姓名/電話</td>
      <td width="62" class="word_b_w">學號</td>
      <td width="37" class="word_b_w">便當</td>
      <td width="201" class="word_b_w">系所年級/Email</td>
      <td width="356" class="word_b_w">選項</td>
      <td width="62" class="word_b_w">&nbsp;</td>
    </tr>
    <?php 
		 // $result=mysql_query("SELECT * FROM  `student`,`activity_sign_up` WHERE activity_sign_up.sid=student.sid and activity_id=".$_GET['activity_id']);
		  $result=mysql_query("SELECT * FROM  `activity_sign_up` WHERE activity_id=".$_GET['activity_id']);
		  while($row=mysql_fetch_array($result)){
			  $stu=get_student_data($row['sid']);
		  ?>
    <tr bgcolor="#FFFFFF">
      <td><?php echo $stu['name']." "; if($stu['sex']=="M"){ echo "男";}else{ echo "女"; } ?></td>
      <td><?php echo $row['sid']." "; ?></td>
      <td align="center"><?php echo $row['food']; ?></td>
      <td><?php echo $stu['dept']." ".$stu['grade']; ?></td>
      <td rowspan="2"><?php 
		  //處理學生選項
		  $result_qes=mysql_query("SELECT * FROM `activity_question` WHERE `activity_id`='".$_GET['activity_id']."' ORDER BY `question_num` ASC");	
		  //$result_qes=mysql_query("SELECT * FROM activity_question S1 ,activity_selection S2 WHERE `sid`='".$row['sid']."' AND T1.activity_id='".$_GET['activity_id']."' AND T1.activity_id = T2.activity_id AND T1.`question_num` = T2.`question_num`");	                     		  
		  while($row_qes=mysql_fetch_array($result_qes)){
			  echo  "問題：".$row_qes['question']."<br>";
			  //顯示使用者的作答
			if($row_qes['type']=="D"){	//若為開放式問題
				//$sql_D="SELECT `ans` FROM `activity_sign_up_select` WHERE `sid`='".$row['sid']."' AND activity_id='".$_GET['activity_id']."' AND `select_num`='0'";
				
				$sql_D="SELECT `ans` FROM activity_question S1 ,`activity_sign_up_select` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id='".$_GET['activity_id']."' AND S1.activity_id = S2.activity_id AND S1.`question_num` = S2.`question_num` AND `type`='D'";
				
			    $result_select_D=mysql_query($sql_D);
			while($row_select_D=mysql_fetch_array($result_select_D))
			{
					echo  "回答：".$row_select_D['ans']."<br>"; 
			}
			  }elseif($row_qes['type']=="S"){
			  $sql="SELECT * FROM `activity_sign_up_select` S1, `activity_selection` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$_GET['activity_id']."' and S1.question_num='".$row_qes['question_num']."'";
			  $result_select=mysql_query($sql);
				while($row_select=mysql_fetch_array($result_select)){
					echo  "回答：".$row_select['item']."<br>"; 
			  	}
			  }else{
			  $sql="SELECT * FROM `activity_sign_up_select` S1, `activity_selection` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$_GET['activity_id']."' and S1.question_num='".$row_qes['question_num']."'";
			  $result_select=mysql_query($sql);
			  echo  "回答：";
				while($row_select=mysql_fetch_array($result_select)){
					echo  $row_select['item']." "; 
			  	}
			  echo "<br>";
			  }
		  }
		  
		  
		  ?></td>
      <td rowspan="2" align="center"><a href="edit_data.php?aid=<?php echo $_GET['activity_id'];?>&amp;sid=<?php echo $row['sid'];?>">修改</a><br />
        <a href="manage_active_do.php?del_sign=<?php echo $row['sid']; ?>&amp;activity_id=<?php echo $row['activity_id']; ?>" onclick="delcfm()">刪除</a></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="2"><?php echo $row['phone']; ?></td>
      <td>&nbsp;</td>
      <td><?php echo $row['email']; ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="6"><hr /></td>
    </tr>
    <?php } ?>
  </table></td>
</tr>
</table>

<!-- 新增活動 -->
<p>
  <?php }else if($_GET['add']){  ?>
</p>
 <p align="center"><img name="top3.jpg" src="image/top3.jpg" width="780" height="205" border="0" id="top8" alt="" /></p>
<form action="manage_active_do.php" method="post" enctype="multipart/form-data" name="activity_form" id="activity_form">
<input name="add_activity" type="hidden" value="1" />
<table id="add_table" border="0" cellpadding="0" cellspacing="1" align="center">
  <tr>
    <td width="183"><div align="right"> 活動名稱</div></td>
    <td width="505" valign="top" ><input name="activity_name" type="text" id="activity_name" size="60" class="required" /></td>
  </tr>
  <tr>
    <td align="right" valign="top">活動介紹</td>
    <td><textarea name="introduce" id="introduce" cols="46" rows="10" class="required" ></textarea></td>
  </tr>
  <tr>
    <td align="right">報名期間</td>
    <td><a href="#" onclick="cal.select(document.forms['activity_form'].sign_start_date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">
    <input type="text" name="sign_start_date" id="sign_start_date" size="10" class={required:true,dateISO:true}/>
    </a>
      <!--<select name="sign_start_time_to_hour">
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
</select>-->
~ <a href="#" onclick="cal.select(document.forms['activity_form'].sign_end_date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">
<input type="text" name="sign_end_date" id="sign_end_date" size="10" class={required:true,dateISO:true}/>
</a>
<!--<a href="manage_active_do.php?del_activity=<?php echo $row['activity_id']; ?>" onclick="return window.confirm('確認刪除此活動？');">刪除</a>
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
</select>--></td>
  </tr>
  <tr>
    <td align="right">活動上架期間</td>
    <td><a href="#" onclick="cal.select(document.forms['activity_form'].appear_start_date,'anchor3','yyyy-MM-dd'); return false;" name="anchor3" id="anchor3">
    <input type="text" name="appear_start_date" id="appear_start_date" size="10"/ class={required:true,dateISO:true}>
    </a>
	<!-- 
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
</select>-->
~ <a href="#" onclick="cal.select(document.forms['activity_form'].appear_end_date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">
<input type="text" name="appear_end_date" id="appear_end_date" size="10" class={required:true,dateISO:true} />
</a>
<!--<select name="appear_end_time_to_hour">
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
</select>--></td>
  </tr>
  <tr>
    <td align="right">活動日期</td>
    <td><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].event_start_date,'anchor5','yyyy-MM-dd'); return false;" name="anchor5" id="anchor5">
      <input type="text" name="event_start_date" id="event_start_date" size="10" class={required:true,dateISO:true} />
      </a>
      <!--<select name="event_start_hour">
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
      </select>-->
      ~ <a href="#" onclick="cal.select(document.forms['activity_form'].event_end_date,'anchor6','yyyy-MM-dd'); return false;" name="anchor6" id="anchor6">
        <input type="text" name="event_end_date" id="event_end_date" size="10" class={required:true,dateISO:true} />
        </a>
      <!--<select name="event_end_hour" id="event_end_hour">
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
      </select>-->
    </div></td>
  </tr>
  <tr>
    <td><div align="right">人數限制</div></td>
    <td><div align="left">
      <input name="event_people" id="event_people" type="text"  size="5" class={required:true}/>
      <b id="event_people_check2"></b><b id="event_people_sum_check2"></b> 人</div></td>
  </tr>
  <tr>
    <td height="22" align="right" valign="top">是否提供便當 </td>
    <td><input type="radio" name="need_food" value="1" class="required" />
      是
      <input type="radio" name="need_food" value="0" class="required" />
      否
	  <label for="error"></label></td>
  </tr>
  <tr>
    <td height="108" align="right" valign="top">新增活動選項</td>
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
        <div id="qes_section"><p>&nbsp;</p></div>
        <p>&nbsp;</p></td>
  </tr>
  </table>
<p align="center">
  <input type="submit" name="button2" id="button2" value="送出並前往上傳相關檔案頁面" />
</p>
</form>
<p>&nbsp; </p>

<!-- 編輯活動 -->
<?php }else if($_GET['edit']){ 
	$activity_id=$_GET['id'];
?>
<p align="center"><img name="top5.jpg" src="image/top5.jpg" width="780" height="205" border="0" id="top8" alt="" /></p>
<form name="activity_form" id="activity_form" method="post" action="manage_active_do.php">
<input name="edit_activity" type="hidden" value="1" />
<input name="activity_id" type="hidden" value="<?php echo $activity_id;?>" />
<?php 
	
	$row=mysql_fetch_array(mysql_query("SELECT * FROM  `activity` WHERE activity_id=".$activity_id)); 
?>
  <table id="edit_table" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr>
      <td width="183"><div align="right"> 活動名稱</div></td>
      <td width="505" valign="top" ><input name="edit_activity_name" type="text" id="edit_activity_name" size="60" value="<?php echo $row['name']; ?>" class="required" /></td>
    </tr>
    <tr>
      <td align="right" valign="top">活動介紹</td>
      <td><textarea name="edit_introduce" id="edit_introduce" cols="60" rows="10" class="required" ><?php echo $row['intro'];?></textarea></td>
    </tr>
    <tr>
      <td align="right">報名期間</td>
      <td><a href="#" onclick="cal.select(document.forms['activity_form'].edit_sign_start_date,'edit_anchor1','yyyy-MM-dd'); return false;" name="edit_anchor1" id="edit_anchor1">
        <input type="text" name="edit_sign_start_date" id="edit_sign_start_date" size="10" class={required:true,dateISO:true} value="<?php echo substr($row['sign_start'],0,10);?>" />
        </a>
        <!--<select name="edit_sign_start_time_to_hour">
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
        </select>-->
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].edit_sign_end_date,'edit_anchor2','yyyy-MM-dd'); return false;" name="edit_anchor2" id="edit_anchor2">
          <input type="text" name="edit_sign_end_date" id="edit_sign_end_date" size="10" value="<?php echo substr($row['sign_end'],0,10);?>" class={required:true,dateISO:true}/>
          </a>
        <!--<select name="edit_sign_end_time_to_hour">
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
        </select>--></td>
    </tr>
    <tr>
      <td align="right">活動上架期間</td>
      <td><a href="#" onclick="cal.select(document.forms['activity_form'].edit_appear_start_date,'edit_anchor3','yyyy-MM-dd'); return false;" name="edit_anchor3" id="edit_anchor3">
        <input type="text" name="edit_appear_start_date" id="edit_appear_start_date" size="10" value="<?php echo substr($row['appear_start'],0,10);?>" class={required:true,dateISO:true}/>
        </a>
        <!--<select name="edit_appear_start_time_to_hour">
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
        </select>-->
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].edit_appear_end_date,'edit_anchor4','yyyy-MM-dd'); return false;" name="edit_anchor4" id="edit_anchor4">
          <input type="text" name="edit_appear_end_date" id="edit_appear_end_date" size="10" value="<?php echo substr($row['appear_end'],0,10); ?>" class={required:true,dateISO:true}/>
          </a>
        <!--<select name="edit_appear_end_time_to_hour">
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
        </select>--></td>
    </tr>
    <tr>
      <td align="right">活動日期</td>
      <td><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].edit_event_start_date,'edit_anchor5','yyyy-MM-dd'); return false;" name="edit_anchor5" id="edit_anchor5">
        <input type="text" name="edit_event_start_date" id="edit_event_start_date" size="10" value="<?php echo substr($row['event_start'],0,10); ?>" class={required:true,dateISO:true}/>
        </a>
        <!--<select name="edit_event_start_hour">
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
        </select>-->
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].edit_event_end_date,'edit_anchor6','yyyy-MM-dd'); return false;" name="edit_anchor6" id="edit_anchor6">
          <input type="text" name="edit_event_end_date" id="edit_event_end_date" size="10" value="<?php echo substr($row['event_end'],0,10); ?>" class={required:true,dateISO:true}/>
          </a>
        <!--<select name="edit_event_end_hour" id="edit_event_end_hour">
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
        </select>-->
      </div></td>
    </tr>
    <tr>
      <td><div align="right">人數限制</div></td>
      <td><div align="left">
        <input name="edit_event_people" id="edit_event_people" type="text"  size="5" value="<?php echo $row['max'];?>" class={required:true}/>人</div></td>
    </tr>
    <tr>
      <td height="22" align="right" valign="top">是否提供便當 </td>
      <td><input type="radio" name="edit_need_food" value="1" <?php echo $row['need_food']?'checked="checked"':'';?> class="required"/>
        是
        <input name="edit_need_food" type="radio" value="0" <?php echo $row['need_food']?'':'checked="checked"';?> class="required"/>
        否
		<label for="error"></label></td></td>
    </tr>
	<?php 
		$i=0;//算問題數
	  $result_qes=mysql_query("select * from activity_question where activity_id=".$activity_id);
	  while($row_qes=mysql_fetch_array($result_qes)){  
	  $i++;
	  
	?>
    <tr>
      <td height="108" align="right" valign="top">詢問事項<?php echo $i;?>：</td>
      <td align="left" valign="top"><?php echo $row_qes['question'];?>
        <div id="edit_qes_section">
          <div id="q_ans_section" class="question_item">
        <?php
		//單複選問題
		if($row_qes['type']=="S"||$row_qes['type']=="M"){
		$result_select=mysql_query("select * from activity_selection where activity_id=".$activity_id." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
		$j=0;//算選項
		while($row_select=mysql_fetch_array($result_select)){
			$j++;
			echo "選項".$j."：".$row_select['item']."<br>";		
        }
		//開放式問題
		}else{
		echo '<img src="./image/answer.png" />';
		}
		?>
              </p>
            </p>
          </div></div>
	  </td>
		<br />
	</tr>
        <?php } ?>
        
    
  </table>
  <p align="center">
<!--    <input type="submit" name="button" id="button" value="送出" /> -->
  <input type="submit" name="button" id="button" value="送出並前往上傳相關檔案頁面" />
  </p>
</form>

<!-- 觀看活動 -->
<?php }else{ ?>
<table style="margin-top:10pt;margin-bottom:20pt" width="1000" border="0" cellpadding="0" cellspacing="2" align="center">
<tr><td colspan="9" align="center"><img name="top2.jpg" src="image/top2.jpg" border="0" id="top2" alt="" /></td></tr>
  <tr>
    <td colspan="9" align="right">
      <a href="<?php echo $this_page;?>?add=1" onmouseout="MouseThrow('button3','icon3')" onmouseover="MouseThrow('button3','icon3a')"><img src="image/new_act.png" alt="新增活動" name="button3" width="110" height="50" border="0" id="new_act" /></a>
      <a href="manage_active.php" onmouseout="MouseThrow('button2','icon2')" onmouseover="MouseThrow('button2','icon2a')"><img src="image/view_act.png" alt="活動列表" name="button2" width="110" height="50" border="0" id="view_act" /></a>
      <a href="index.php" onmouseout="MouseThrow('button1','icon1')" onmouseover="MouseThrow('button1','icon1a')"><img src="image/to_index.png" alt="返回首頁" name="button1" width="110" height="50" border="0" id="to_index" /></a>
    </td>
  </tr>
  <tr class="word_b_w">
    <!--<td width="10%" class="title_word" bgcolor="#FFF5D7" align="center">封面</td> -->
    <td height="40px" width="19%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>活動名稱</b></center></font></td>
	  <td height="40px" width="17%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>發布單位</b></center></font></td>
    <td height="40px" width="17%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>報名截止日</b></center></font></td>
    <td height="40px" width="11%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>活動日期</b></center></font></td>
    <td height="40px" width="7%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>限額</b></center></font></td>
    <td height="40px" width="8%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>已報名</b></center></font></td>
	  <td height="40px" width="15%" class="title_word" bgcolor="FFD8AF" align="center"><font face="標楷體" size="5"><center><b>活動狀態</b></center></font></td>
    <td height="40px" width="6%" align="center" class="title_word" bgcolor="FFD8AF">&nbsp;</td>
  </tr>
 
	
  <?php 
  $now_time=date("Y-m-d H:i:s"); //檢查活動是否已下架用
  
		  //$result=mysql_query("SELECT * FROM  `activity` ORDER BY  `event_end` DESC ");
		  $result=mysql_query("SELECT*  FROM `activity`  ORDER BY `activity_id` DESC  LIMIT 0,30");
	
			while($row=mysql_fetch_array($result)){

			  $row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id='".$row['activity_id']."'",$main_mysql_link));
			  $sign_up_num=$row_count[0];

			 
			  $row_img=mysql_fetch_array(mysql_query("SELECT * FROM activity_file WHERE cover=1 AND activity_id=".$row['activity_id']));
		  ?>
  <tr>
    <!--<td class="word" height="138" align="center"><?php if(!empty($row_img['fname'])){?><img src="<?php echo "./".$row_img['path'];?>" width="110" height="138" /><?php }?></td> -->
    <td class="word" align="center"><a href="<?php echo $this_page."?activity_id=".$row['activity_id']; ?>"><?php echo $row['name']; ?></a></td>
	  <td class="word" align="center"><?php echo check_dept($row['poster']);?></td>
    <td class="word" align="center"><?php echo substr($row['sign_end'],0,10); ?></td>
    <td class="word" align="center"><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."<br>".substr($row['event_end'],0,10);} ?></td>
    <td class="word" align="center"><?php echo $row['max']; ?></td>
    <td class="word" align="center"><?php echo $sign_up_num; ?></td>
	  <td class="word" align="center"><?php if($row['sign_end']<=$now_time){ echo "<font color='#CC0000'><B>結束報名</B></font>"; } elseif ($row['sign_start']>$now_time){ echo "<font color='#696969'><B>尚未開放報名</B></font>"; }else{echo "<font color='#0000CC'><B>開放報名中</B></font>"; }?><br>
	  <?php if($row['appear_end']<=$now_time){ echo "<font color='#CC0000'><B>已下架</B></font>"; } elseif ($row['appear_start']>$now_time){ echo "<font color='#696969'><B>未上架</B></font>"; }else{echo "<font color='#0000CC'><B>上架中</B></font>"; }?><br>
	  <?php if($row['event_end']<=$now_time){ echo "<font color='#CC0000'><B>活動已結束</B></font>"; } elseif ($row['event_start']>$now_time){ echo "<font color='#696969'><B>活動尚未開始</B></font>"; }else{echo "<font color='#0000CC'><B>活動進行中</B></font>"; }?></td>
    <td class="r_word" align="center"><p><a href="manage_active_do.php?del_activity=<?php echo $row['activity_id']; ?>" onclick="return window.confirm('確認刪除此活動？');">刪除</a><br />
    <a href="<?php echo $this_page."?edit=1&amp;id=".$row['activity_id']; ?>">修改</a>    
    <p><a href="out_excel.php?aid=<?php echo $row['activity_id']; ?>">輸出</a></td>
  </tr>
  <tr>
    <td colspan="9" class="word" align="center"><hr /></td>
  </tr>
  <?php } ?>
</table>

  <?php } ?>

</div>
</body>
</html>