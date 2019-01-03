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
<style type="text/css">
.select_item {
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #03C;
	border-right-color: #03C;
	border-bottom-color: #03C;
	border-left-color: #03C;
}
.question_item {
	border-bottom-style: none;
	border-top-color: #60F;
	border-right-color: #60F;
	border-bottom-color: #60F;
	border-left-color: #60F;
	border-top-style: none;
	border-right-style: none;
	border-left-style: none;
}
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="Calendar/CalendarPopup.js"></SCRIPT><!-- 日期編輯器 -->
<SCRIPT LANGUAGE="JavaScript">
var cal = new CalendarPopup();//日期選單
</script>
<script language="javascript">

function add_ans(ans_table){
	var x=document.getElementById(ans_table).insertRow(-1);
	x.insertCell(0).innerHTML='<input type="text" name="'+ans_table+'_ans[]" /><input type="button" value="刪除選項"  onclick="del_ans(this,\''+ans_table+'\')"/>';
//	x.insertCell(1).innerHTML='';
}

function del_ans(r,ans_table){
	var i;
	i=r.parentNode.rowIndex;
	document.getElementById(ans_table).deleteRow(i);
}

function add_qes(){
	var x=document.getElementById("qes_table").insertRow(-1);
	var i=document.getElementById("qes_table").rows.length;
	i=i+1;

	var qes='<p>詢問事項<input name="q'+i+'_qes" type="text" size="30" /><select name="q'+i+'_select_multiple"><option value="S">單選</option><option value="M">複選</option></select></p><p>選項<input type="button" value="增加選項"  onclick="add_ans(\'q'+i+'\');"/><br /></p>';
	qes+='<table width="328" id="q'+i+'" class="select_item"><tr><td><input type="text" name="q'+i+'_ans[]" /><input type="button" value="刪除選項"  onclick="del_ans(this,\'q'+i+'\')"/></td></tr></table><hr>';
	x.insertCell(0).innerHTML=qes;
	x.insertCell(1).innerHTML='<p><input type="button" value="刪除問題"  onclick="del_qes(this)"/>';
	
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
  <?php }else{  ?>
</p>
<p>&nbsp; </p>
<p align="center">活動報名管理介面</p>
<table width="905" border="0" align="center">
  <tr class="word_b_w">
    <td width="238">活動名稱</td>
    <td width="136">截止時間</td>
    <td width="244">活動期間</td>
    <td width="87">限額</td>
    <td width="87">報名人數</td>
    <td width="87" align="center">&nbsp;</td>
  </tr>
  <?php 
		  $result=mysql_query("SELECT * FROM  `activity` ORDER BY  `end_date` ASC ");
		  while($row=mysql_fetch_array($result)){
			  $row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
			  
		  ?>

  <tr>
    <td class="word"><a href="<?php echo $this_page."?activity_id=".$row['activity_id']; ?>"><?php echo $row['name']; ?></a></td>
    <td class="word"><?php echo substr($row['end_date'],0,16); ?></td>
    <td class="word"><?php echo substr($row['event_start'],0,16)."~".substr($row['event_end'],0,16); ?></td>
    <td class="word"><?php echo $row['max']; ?></td>
    <td class="word"><?php echo $row_count[0]; ?></td>
    <td class="word"><a href="manage_active_do.php?del_activity=<?php echo $row['activity_id']; ?>">刪除</a></td>
  </tr>  <tr>
    <td colspan="6" class="word"><hr /></td>
    </tr>
  <?php } ?>
</table>
<p>&nbsp;</p>
<p align="center">新增活動 </p>
<form name="activity_form" id="activity_form" method="post" action="manage_active_do.php">
  <table  border="0" cellpadding="0" cellspacing="1" bgcolor="white" align="center">
    <tr>
      <td width="183" bgcolor="#EAEAEA"><div align="right"> 活動名稱</div></td>
      <td width="505"  bgcolor="#EAEAEA" valign="top" ><input name="activity_name" type="text" id="activity_name" size="60" /></td>
    </tr>
    <tr>
      <td align="right" valign="top" bgcolor="#EAEAEA" >活動介紹</td>
      <td bgcolor="#EAEAEA"><textarea name="introduce" id="introduce" cols="60" rows="10"></textarea> </td>
    </tr>
    <tr>
      <td align="right" bgcolor="#EAEAEA">報名期間</td>
      <td bgcolor="#EAEAEA"><a href="#" onclick="cal.select(document.forms['activity_form'].start_date,'anchor1','yyyy-MM-dd'); return false;" name="anchor1" id="anchor1">
      <input type="text" name="start_date" id="start_date" size="10"/>
      </a>
        <select name="start_time_to_hour">
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
<select name="start_time_to_min">
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
~
<a href="#" onclick="cal.select(document.forms['activity_form'].end_date,'anchor2','yyyy-MM-dd'); return false;" name="anchor2" id="anchor2">
        <input type="text" name="end_date" id="end_date" size="10"/>
        </a>
        <select name="end_time_to_hour">
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
        <select name="end_time_to_min" id="end_time_to_min">
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
      <td align="right" bgcolor="#EAEAEA">活動日期</td>
      <td bgcolor="#EAEAEA"><div align="left"> <a href="#" onclick="cal.select(document.forms['activity_form'].event_start_date,'anchor3','yyyy-MM-dd'); return false;" name="anchor3" id="anchor3">
        <input type="text" name="event_start_date" id="event_date" size="10"/>
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
          <option value="17" >17</option>
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
        ~ <a href="#" onclick="cal.select(document.forms['activity_form'].event_end_date,'anchor4','yyyy-MM-dd'); return false;" name="anchor4" id="anchor4">
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
      <td bgcolor="#EAEAEA"><div align="right">人數限制</div></td>
      <td bgcolor="#EAEAEA"><div align="left">
        <input name="event_people" id="event_people" type="text"  size="5" />
        <b id="event_people_check"></b><b id="event_people_sum_check"></b> 人</div></td>
    </tr>
    <tr>
      <td height="22" align="right" valign="top" bgcolor="#EAEAEA" >是否提供便當 </td>
      <td bgcolor="#EAEAEA"><input type="radio" name="need_food" value="1" />
        是
        <input type="radio" name="need_food" value="0" />
        否 </td>
    </tr>
    <tr>
      <td height="108" align="right" valign="top" bgcolor="#EAEAEA" >新增活動選項</td>
      <td bgcolor="#EAEAEA"><p>
        <input type="button" value="增加問題"  onclick="add_qes();"/>
      </p>
        <table width="511" id="qes_table" class="question_item">
          <tr>
            <td width="375"><p>
              
              詢問事項
              <input name="q0_qes" type="text" size="30" />
              <select name="q0_select_multiple">
                <option value="S">單選</option>
                <option value="M">複選</option>
                </select>
              </p>
              <p>選項
                <input type="button" value="增加選項"  onclick="add_ans('q0');"/>
                <br />
                </p>
              <table width="328" id="q0" class="select_item">
                <tr>
                  <td><input type="text" name="q0_ans[]" /><input type="button" value="刪除選項"  onclick="del_ans(this,'q0')"/></td>
                  </tr>
              </table></td>
            <td width="126"><p>
              <input type="button" value="刪除問題"  onclick="del_qes(this)"/>
              </td>
          </tr>
          <tr><td><hr /></td><td></td></tr>
        </table>
        <p>
          </p>
        </p></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" name="button" id="button" value="送出" />
  </p>
</form>
<p align="center"><a href="index.php">回首頁</a></p>
<p>
  <?php } ?>
</p>
<p>&nbsp; </p>
<p></p>
</div>
</body>
</html>