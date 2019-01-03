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
<title>活動報名系統_詳細資訊</title>

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

<body onload="MM_preloadImages('image/choose/22.gif','image/choose/81.gif','image/choose/82.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg">
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
				<td><a href="manage_add.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image62','','image/choose/82.gif',1)"><img src="image/choose/72.gif" alt="新增活動" width="224" height="120" id="Image62" /></a></td>
				<td><img src="image/choose/84.gif" width="224" height="120" alt="詳細資訊" /></td>
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
<?php  
	  $a_id = $_GET['activity_id'];
	  $row=mysql_fetch_array(mysql_query("SELECT *  FROM  `hai_active_activity` WHERE activity_id=".$_GET['activity_id']));
	  $row_img=mysql_fetch_array(mysql_query("SELECT * FROM hai_active_activity_file WHERE cover=1 AND activity_id=".$_GET['activity_id']));
?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
    <tr>
      <td rowspan="7" width="2%"></td>
 	  <td width="33%" rowspan="7" align="center" bgcolor="#CCCCCC" scope="col"><?php if(!empty($row_img['fname'])){?><img src="<?php echo "./".$row_img['path'];?>" width="300" height="400"  />
	  														 <?php }else{ echo "<font size='5' color='#CC0000'><B>無海報！</B></font>";}?></td>
      <td width="11%" align="right" class="m_word" bgcolor="CEE2D0"><font Face="標楷體" size="4"><b>活 動 名 稱：</b></font></td>
      <td width="52%" bgcolor="CEE2D0"><font size="2"><?php echo $row['name']; ?></font></td>
      <td rowspan="7" bgcolor="#FFFFFF" width="2%"></td> 
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>活 動 日 期：</strong></font></td>
      <td><font size="2"><?php echo substr($row['event_start'],0,10)."至".substr($row['event_end'],0,10); ?></font></td>
    </tr>
    <tr bgcolor="CEE2D0">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>報 名 截 止：</strong></font></td>
      <td><font size="2"><?php echo substr($row['sign_end'],0,10); ?>止</font></td>
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word"><font Face="標楷體" size="4"><strong>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;額：</strong></font></td>
      <td><font size="2"><?php echo $row['max']; ?>位</font></td>
    </tr>
    <tr bgcolor="CEE2D0">
      <td align="right" class="m_word" valign="top"><font Face="標楷體" size="4"><strong>活 動 說 明：</strong></font></td>
      <td><font size="2"><?php echo nl2br($row['intro']); ?></font></td>
    </tr>
    <tr bgcolor="DDEADE">
      <td align="right" class="m_word" valign="top"><font Face="標楷體" size="4"><strong>活 動 檔 案：</strong></font></td>
      <td valign="top"><?php 
		$result_filelist=mysql_query("SELECT * FROM hai_active_activity_file WHERE  activity_id=".$a_id);
		while($row_filelist=mysql_fetch_array($result_filelist)){
		  if(!empty($row_filelist['fname'])){
		  ?>
		  <a target="_blank" href="<?php echo $row_filelist['path'];?>"><?php echo $row_filelist['fname'];?></a><br>
		  <?php  }}?>
	  </td>
    </tr>
        </table>
  </p>
</div>
<p align="center"></p>
<table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
<tr><td><img name="center1.jpg" src="image/center1.jpg" width="780" height="40" border="0" id="center1" alt="" /></td></tr>
<tr>
  <td width="100" class="word_b_w">
   <table width="98%" border="0" align="center">
    <tr bgcolor="#CCCCCC" valign="middle">
      <td width="5%" class="word_b_w" align="center">序號</td>
	  <td width="7%" class="word_b_w" align="center">姓名</td>
      <td width="7%" class="word_b_w" align="center">學號</td>
      <td width="5%" class="word_b_w" align="center">性別</td>
      <td width="10%" class="word_b_w" align="center">電話</td>
      <td width="14%" class="word_b_w" align="center">Email</td>
      <td width="5%" class="word_b_w" align="center">便當</td>
      <td width="10%" class="word_b_w" align="center">系所年級</td>
      <td width="25%" class="word_b_w" align="center">選項</td>
      <td width="11%" class="word_b_w" align="center">&nbsp;</td>
    </tr>
    <?php 
		 // $result=mysql_query("SELECT * FROM  `student`,`activity_sign_up` WHERE activity_sign_up.sid=student.sid and activity_id=".$_GET['activity_id']);
		  $result=mysql_query("SELECT * FROM  `hai_active_activity_sign_up` WHERE activity_id='".$_GET['activity_id']."' ORDER BY `snum`");
		  while($row=mysql_fetch_array($result)){
			  $student=get_student_data($row['sid']); 
		  ?>
    <tr bgcolor="#FFFFFF" valign="middle">
      <td align="center"><?php echo $row['snum']; ?></td>
	  <td align="center"><?php echo $student['name']; ?></td>
      <td align="center"><?php echo $row['sid']." "; ?></td>
      <td align="center"><?php  if($student['sex']=="M"){ echo "男";}else{ echo "女"; }  ?></td>
      <td align="center"><?php echo $row['phone']." ";?></td>
      <td align="center"><?php echo $row['email']." ";?></td>
      <td align="center"><?php echo $row['food']; ?></td>
      <td align="center"><?php echo $student['dept']." "; ?></td>
      <td ><?php 
		  //處理學生選項
		  $result_qes=mysql_query("SELECT * FROM `hai_active_activity_question` WHERE `activity_id`='".$_GET['activity_id']."' ORDER BY `question_num` ASC");	
		  //$result_qes=mysql_query("SELECT * FROM activity_question S1 ,activity_selection S2 WHERE `sid`='".$row['sid']."' AND T1.activity_id='".$_GET['activity_id']."' AND T1.activity_id = T2.activity_id AND T1.`question_num` = T2.`question_num`");	                     		  
		  while($row_qes=mysql_fetch_array($result_qes)){
			  echo  "問題：".$row_qes['question']."<br>";
			  //顯示使用者的作答
			if($row_qes['type']=="D"){	//若為開放式問題
				//$sql_D="SELECT `ans` FROM `activity_sign_up_select` WHERE `sid`='".$row['sid']."' AND activity_id='".$_GET['activity_id']."' AND `select_num`='0'";
				
				$sql_D="SELECT `ans` FROM hai_active_activity_question S1 ,`hai_active_activity_sign_up_select` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id='".$_GET['activity_id']."' AND S1.activity_id = S2.activity_id AND S1.`question_num` = S2.`question_num` AND `type`='D'";
				
			    $result_select_D=mysql_query($sql_D);
			while($row_select_D=mysql_fetch_array($result_select_D))
			{
					echo  "回答：".$row_select_D['ans']."<br>"; 
			}
			  }elseif($row_qes['type']=="S"){
			  $sql="SELECT * FROM `hai_active_activity_sign_up_select` S1, `hai_active_activity_selection` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$_GET['activity_id']."' and S1.question_num='".$row_qes['question_num']."'";
			  $result_select=mysql_query($sql);
				while($row_select=mysql_fetch_array($result_select)){
					echo  "回答：".$row_select['item']."<br>"; 
			  	}
			  }else{
			  $sql="SELECT * FROM `hai_active_activity_sign_up_select` S1, `hai_active_activity_selection` S2 WHERE `sid`='".$row['sid']."' AND S1.activity_id = S2.activity_id AND S1.question_num = S2.question_num	AND S1.select_num = S2.select_num and S1.activity_id='".$_GET['activity_id']."' and S1.question_num='".$row_qes['question_num']."'";
			  $result_select=mysql_query($sql);
			  echo  "回答：";
				while($row_select=mysql_fetch_array($result_select)){
					echo  $row_select['item']." "; 
			  	}
			  echo "<br>";
			  }
		  }
		  
		  
		  ?></td>
      <td align="center" valign="middle"><a href="manage_sign.php?aid=<?php echo $_GET['activity_id'];?>&amp;sid=<?php echo $row['sid'];?>">修改</a><br />
        <a href="manage_active_do.php?del_sign=<?php echo $row['sid']; ?>&amp;activity_id=<?php echo $row['activity_id']; ?>" onclick="delcfm()">刪除</a></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="10"><hr /></td>
    </tr>
    <?php } ?>
  </table>
 </td>
</tr>
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
