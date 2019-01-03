<?php
session_start();
$this_page = basename(__FILE__); 
require_once("mysql.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>航海王活動報名</title>
<link href="base.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="jQuery.js"></script>
<script language="javascript">
function check_form(){
	  //判斷行動電話格式
	  var re =/^09+([0-9]{8})*$/;
	　if (!re.test(document.input_form.s_phone.value)) {
	　　alert("行動電話格式有錯喔！");
	　	document.input_form.s_phone.focus();
	　　return false;
	　} 
	
	//判斷email格式
	  var re =/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/;
	　if (!re.test(document.input_form.s_email.value)) {
	　　alert("email格式有錯喔！");
	　	document.input_form.s_email.focus();
	　　return false;
	　} 
	//判斷行動電話未填
	if(document.input_form.s_phone.value==""){
		alert('請填寫連絡電話');
		document.input_form.s_phone.focus();
		return false;
	}
	//判斷email未填
	if(document.input_form.s_email.value==""){
		alert('請填寫email');
		document.input_form.s_email.focus();
		return false;
	}
	return true;
	}
</script>
<body>
<div id="container">
<p align="center" class="word_b">
  <?php
			if($_GET['activity_id'])
			{ 
				$row=mysql_fetch_array(mysql_query("SELECT * FROM `activity` WHERE activity_id=".$_GET['activity_id']));
		?>
</p>
<p align="right">→<a href="<?php echo $this_page;?>">回活動列表</a>←</p>
<hr />
<div style="margin:15px">
  <p align="center" class="m_word_b"><?php echo $row['name']; ?></p>
  <br />
  <table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
    <tr>
      <td width="115" align="right" class="m_word">活動時間：</td>
      <td width="485"><?php echo substr($row['event_start'],0,16)."~".substr($row['event_end'],0,16); ?></td>
    </tr>
    <tr>
      <td align="right" class="m_word">報名截止日期：</td>
      <td><?php echo substr($row['sign_end'],0,16); ?>止</td>
    </tr>
    <tr>
      <td align="right" class="m_word">名額：</td>
      <td><?php echo $row['max']; ?>位</td>
    </tr>
    <tr>
      <td colspan="2" align="left"><br />
        <span class="m_word">活動說明：</span><br />
        <?php echo nl2br($row['intro']); ?></td>
    </tr>
  </table>
</div>
<?php    
	$row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
	if($row_count[0] < $row['max']){   //未額滿才顯示報名表
?>
<hr />
<p align="center" class="m_word_b">報名表 </p>
<br />
<?php if($_SESSION['sid']){ //學生登入才給報名    ?>
<form action="sign_do.php" method="post" name="input_form" id="input_form" onsubmit="return check_form();">
  <input name="sign" type="hidden" value="1" />
  <input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id']; ?>" />
  <?php
		$row_user=mysql_fetch_array(mysql_query("SELECT * FROM `student` WHERE sid=".$_SESSION['sid']));
		?>
  <table width="650" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
    <tbody>
      <tr>
        <td width="100" align="right" class="m_word">姓名：</td>
        <td width="280" align="left"><?php 
			  	echo $row_user['name']; ?>
</td>
        <td width="270" align="left"><span class="m_word">學號：
          <?php 
				    echo $row_user['sid'];
					
					 ?>
        </span></td>
      </tr>
      <tr>
        <td align="right" class="m_word">行動電話：</td>
        <td align="left"><input name="s_phone" type="text" id="s_phone" maxlength="10" size="10" /> 
        <font color="#FF0000" size="-3">(例：0900111222)</font></td>
        <td align="left" class="m_word"><?php if($row['need_food']){?>
          便當：
          <select name="s_food" id="s_food">
            <option value="葷">葷</option>
            <option value="素">素</option>
            <option value="自理">自理</option>
            </select>
          <?php } ?></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="m_word">E-mail：</td>
        <td colspan="2" align="left"><input type="text" size="50" name="s_email" id="s_email" /></td>
      </tr>
      <?php 
		$i=1;//算問題數
	  $result_qes=mysql_query("select * from activity_question where activity_id=".$_GET['activity_id']);
	  while($row_qes=mysql_fetch_array($result_qes)){  
	  ?>
      <tr>
        <td align="right" valign="top" class="m_word">詢問事項<?php echo $i;?>：</td>
        <td colspan="2" class="r_word">
        <?php 
		echo $row_qes['question']."<p>";
		
		 $i++;
		 if($row_qes['type']=="M"){  //多選題
		?>
          <p>
<?php 
	$result_select=mysql_query("select * from activity_selection where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
	while($row_select=mysql_fetch_array($result_select))
	{
?>               
<input type=checkbox value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select[]" /><?php echo $row_select['item']; ?>
<?php } ?>  
            <br />
            <?php }else{  
			//單選題 
			$result_select=mysql_query("select * from activity_selection where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
			while($row_select=mysql_fetch_array($result_select)){
			?>
            <input type=radio value="<?php echo $row_select['select_num']; ?>" name="群組名稱"><?php echo $row_select['item']; } ?>
            <br />
            <?php } ?>
			</p></td></tr>
			 <?php } 
		  		$row_count=mysql_fetch_array(mysql_query("select max(question_num) from activity_question where activity_id=".$_GET['activity_id']));
				//計算問題題號最大值
		   ?><input name="max_qes" type="hidden" value="<?php echo $row_count[0]; ?>" />

      <tr>
        <td align="right" valign="top" class="m_word">備註：</td>
        <td colspan="2" align="left"><textarea name="s_other" cols="60" rows="5" id="s_other"><?php echo $row['require']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3" valign="middle" height="50" align="right" style="padding-right:20pt"><input id="m" type="submit" name="m" value="報名" onclick="student_check(183)" /></td>
      </tr>
    </tbody>
  </table>
</form>
<?php 
}else{//學生登入才給報名
	echo '<p align="center">請使用學生帳號登入</p>';
}
		}
	  else
	  {  
	  ?>
<p align="center"><font size="4" color="#FF0000">本活動已額滿</font></p>
<p align="center">&nbsp;</p>
<?php
	  } 
	  ?>
<hr />
<br />
<p align="center" class="m_word_b"><?php echo $row['name']; ?>已報名名單</p>
<br />
<table width="400" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr align="center">
    <td width="150" class="word_b_w">姓名</td>
    <td width="250" class="word_b_w">系所</td>
  </tr>
  <?php 
	$result_apply=mysql_query("SELECT * FROM  `activity_sign_up`,`student` WHERE `activity_sign_up`.`sid`=`student`.`sid` AND activity_id=".$_GET['activity_id']);
	while($row_apply=mysql_fetch_array($result_apply)){
	?>
  <tr>
    <td align="center"><?php echo $row_apply['sid']; ?></td>
    <td align="center"><?php echo $row_apply['dept']; ?></td>
  </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
<p>
  <?php 
		  }
		  
		  else
		  { //判斷是否有活動id來顯示報名表，無就顯示列表  
		  
		  ?>
</p>
<p class="m_word_b"><img src="images/regist.png" /></p>
<div align="center"><img name="top1.jpg" src="top2.jpg" width="75%" height="205" border="0" id="top2" alt="" /></div>
<div align="right"><a href="regi_activity.php">查看已報名活動</a></div>
<table style="margin-top:10pt;margin-bottom:20pt" width="75%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr bordercolor="#FFCC33" bgcolor="#FFF5D7">
    <td align="left" width="40%" class="title_word">活動名稱</td>
    <td align="left" width="25%" class="title_word">活動公告單位</td>
    <td align="center" width="20%" class="title_word">報名截止時間</td> 
    <td align="center" width="15%" class="title_word">活動狀態</td>
  </tr>
   <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <?php 
		  $result=mysql_query("SELECT * FROM `teacher`,`activity` ORDER BY `sign_end` ASC ");
		  while($row=mysql_fetch_array($result)){
			  $row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
	//檢視活動的時效性
	$getdate = date("Y-m-d",mktime(date(m), date(d), date(Y)));		//yyyy-mm-dd
	?>
         
  <tr>
    <td class="r_word" align="left" style="padding-left:10pt">
    <?php if(substr($row['event_end'],0,10)>$getdate){ ?><a href="<?php echo $this_page."?activity_id=".$row['activity_id']; ?>"><?php } ?><?php echo $row['name']; ?></a></td>
    <td class="r_word" align="left"><?php echo $row['dept']; ?></td>
    <td class="r_word" align="center"><?php echo substr($row['sign_end'],0,16); ?></td>
    <td class="r_word" align="center"><?php if(substr($row['event_end'],0,10)<$getdate){ echo "<font color='#CC0000'><B>結束報名</B></font>"; } elseif ($row_count[0] < $row['max']){ echo "<font color='#0000CC'><B>開放報名中</B></font>"; }else{ echo "已額滿"; }?></td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <?php } ?>
</table>
<p align="center"><a href="index.php">回首頁</a></p>
<p>
  <?php } ?>
</p>
<p></p>
</div>
</body>
</html>