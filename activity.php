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
<title>航海王活動報名</title>
<link href="base.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(image/123.jpg);
	background-repeat: repeat;
}
-->
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
<script type="text/javascript" src="jQuery.js"></script>
<script src="./plugin/jquery-validation-1.9.0/lib/jquery.js" type="text/javascript"></script>
<script src="./plugin/jquery-validation-1.9.0/lib/jquery.metadata.js" type="text/javascript"></script>
<script type="text/javascript" src="./plugin/jquery-validation-1.9.0/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){
	$("#input_form").validate({
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
function check_form(){
	  //判斷行動電話格式
	  var re =/^09+([0-9]{8})*$/;
	　if (!re.test(document.input_form.s_phone.value)) {
	　　alert("行動電話格式有錯喔！");
	　	document.input_form.s_phone.focus();
	　　return false;
	　} 
}
</script>
<body>
<div id="container">
<p align="center" class="word_b">
  <?php
			if($_GET['activity_id'])
			{ 
				$row=mysql_fetch_array(mysql_query("SELECT * FROM `activity` WHERE activity_id=".$_GET['activity_id']));
				
				$row_img=mysql_fetch_array(mysql_query("SELECT * FROM activity_file WHERE cover=1 AND activity_id=".$_GET['activity_id']));
		?>
</p>
  <table border="0" cellpadding="0" cellspacing="0" width="780" align="center">
    <tr><td align="center"><img name="top4.jpg" src="image/top4.jpg" border="0" id="top4" alt="" /></td></tr>
    <tr><td align="right">
      <a href="<?php echo $this_page;?>" onmouseout="MouseThrow('button2','icon2')" onmouseover="MouseThrow('button2','icon2a')"><img src="image/view_act.png" alt="活動列表" name="button2" width="110" height="50" border="0" id="view_act" /></a>
      <a href="index.php" onmouseout="MouseThrow('button1','icon1')" onmouseover="MouseThrow('button1','icon1a')"><img src="image/to_index.png" alt="返回首頁" name="button1" width="110" height="50" border="0" id="to_index" /></a>
    </td></tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" width="780" align="center">
    <tr bgcolor="#FFFFFF">
    <td width="50%" rowspan="7" scope="col"><?php if(!empty($row_img['fname'])){?><img src="<?php echo "./".$row_img['path'];?>" width="100%"  /><?php }?></td>
      <td width="15%" align="right" class="m_word">活動名稱：</td>
      <td width="35%"><?php echo $row['name']; ?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="right" class="m_word">活動日期：</td>
      <td><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."至".substr($row['event_end'],0,10);}  ?></td>
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
    <tr><td></td><td></td></tr>
  </table>
</div>
<?php    
	$row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
	if($row_count[0] < $row['max']){   //未額滿才顯示報名表
?>
<hr />
<p align="center" class="m_word_b">報名表 </p>
<br />
<?php if($_SESSION['sid']){ //學生登入才給報名   
 
	$result_apply=mysql_fetch_array(mysql_query("SELECT `sid` FROM  `activity_sign_up` WHERE `sid`=".$_SESSION['sid']." AND activity_id=".$_GET['activity_id']));
		if(!empty($result_apply['sid'])){
		echo "<p align='center'><font color='#CC0000'><B>你已經報名此活動了！</B></font></p>";
		}else{  
 ?>
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
        <td align="left" colspan="2"><input name="s_phone" type="text" id="s_phone" maxlength="10" size="10" class="required" /> 
        <font size="-3">(例：0900111222)</font>
		</td>
	  </tr>
		<?php if($row['need_food']){ //如果有提供便當才會出現此表格 ?>
		<tr>
		<td align="right" class="m_word">便當：</td>
		<td>
          <select name="s_food" id="s_food">
            <option value="葷">葷</option>
            <option value="素">素</option>
            <option value="自理">自理</option>
            </select></td></tr>
          <?php } ?>
      
      <tr>
        <td align="right" valign="top" class="m_word">E-mail：</td>
        <td colspan="2" align="left"><input type="text" size="50" name="s_email" id="s_email" class="required email" /></td>
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
if($row_qes['type']=="M"){  
//多選題
		?>
          <p>
<?php 
	$result_select=mysql_query("select * from `activity_selection` where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
	while($row_select=mysql_fetch_array($result_select))
	{
?>              
<input type="checkbox" value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select[]" class="required" /><?php echo $row_select['item']; ?>
<?php } ?>  
            <br />
            <?php
}elseif($row_qes['type']=="S"){  
//單選題 
			$result_select=mysql_query("select * from activity_selection where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
			while($row_select=mysql_fetch_array($result_select)){
			?>
<input type=radio value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select" class="required" ><?php echo $row_select['item']; } ?>
            <br />
<?php 
}elseif($row_qes['type']=="D"){  
//開放性問題
	//$row_select=mysql_fetch_array(mysql_query("select * from activity_question where activity_id=".$_GET['activity_id']." and type='D' and question_num=".$row_qes['question_num']));
?>
<textarea cols="50" rows="3" name="q_<?php echo $row_qes['question_num'];?>_textans" class="required"></textarea>
			
<br />
<?php 
}else{
echo "錯誤";
}		
?>
			
			</p></td></tr>
			 <?php } 
		  		$row_count=mysql_fetch_array(mysql_query("select max(question_num) from activity_question where activity_id=".$_GET['activity_id']));
				//計算問題題號最大值
		   ?><input name="max_qes" type="hidden" value="<?php echo $row_count[0]; ?>" />

      <tr>
        <td align="right" valign="top" class="m_word">備註：</td>
        <td colspan="2" align="left"><textarea name="s_other" cols="50" rows="3" id="s_other"><?php echo $row['require']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="3" valign="middle" height="50" align="right" style="padding-right:20pt"><input id="m" type="submit" name="m" value="報名" onclick="student_check(183)" /></td>
      </tr>
    </tbody>
  </table>
</form>
<?php 
}
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

		  }
		  
		  else
		  { //判斷是否有活動id來顯示報名表，無就顯示列表  
		  
		  ?>
</p>

<table style="margin-top:10pt;margin-bottom:20pt" width="75%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr><td colspan="8"><img name="top9.jpg" src="image/top9.jpg" width="100%" height="205" border="0" id="top9" alt="" /></td></tr>
  <tr>
    <td colspan="9" align="right">
<?php if(!empty($_SESSION['sid'])){//學生才顯示此選項，未登入或管理者都不給使用
	 ?>
      <a href="regi_activity.php" onmouseout="MouseThrow('button4','icon4')" onmouseover="MouseThrow('button4','icon4a')"><img src="image/ready_act.png" alt="已報名活動" name="button4" width="130" height="50" border="0" id="ready_act" /></a>
<?php } ?>
      <a href="index.php" onmouseout="MouseThrow('button1','icon1')" onmouseover="MouseThrow('button1','icon1a')"><img src="image/to_index.png" alt="返回首頁" name="button1" width="110" height="50" border="0" id="to_index" /></a>
    </td>
  </tr>
  <tr bordercolor="#FFCC33">
  <td width="3%" bgcolor="#FFFFFF"></td>
    <td align="center" width="30%" class="title_word" bgcolor="#FEFADA">活動名稱</td>
    <td align="center" width="25%" class="title_word" bgcolor="#FEFADA">活動公告單位</td>
    <td align="center" width="25%" class="title_word" bgcolor="#FEFADA">報名截止日期</td> 
    <td align="center" width="14%" class="title_word" bgcolor="#FEFADA">活動日期</td>
    <td width="3%" bgcolor="#FFFFFF"></td>
  </tr>
  <?php 
	$now_time=date("Y-m-d H:i:s"); //檢查活動是否已下架用

		  $result=mysql_query("SELECT * FROM `activity` WHERE appear_start<='".$now_time."' AND appear_end >='".$now_time."' ORDER BY `sign_end` ASC ");
		  
		  while($row=mysql_fetch_array($result)){
			  $row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `activity_sign_up` WHERE activity_id=".$row['activity_id']));
	//檢視活動的時效性
	$getdate = date("Y-m-d",mktime(date(m), date(d), date(Y)));		//yyyy-mm-dd

	?>
         
  <tr bgcolor="#FFFFFF">
  <td></td>
    <td class="r_word" align="center" style="padding-left:10pt">
    <?php if($row['sign_end'] >=$now_time){ ?><a href="<?php echo $this_page."?activity_id=".$row['activity_id']; ?>"><?php } ?><?php echo $row['name']; ?></a></td>
    <td class="r_word" align="center"><?php echo $row['dept']; ?></td>
    <td class="r_word" align="center"><?php echo substr($row['sign_end'],0,10); ?></td>
    <td class="r_word" align="center"><?php if(substr($row['event_start'],0,10)==substr($row['event_end'],0,10)){ echo substr($row['event_start'],0,10);}else{ echo substr($row['event_start'],0,10)."<br>至<br>".substr($row['event_end'],0,10);} ?></td>
  <td></td></tr>
  <tr><td colspan="6" bgcolor="#FFFFFF">&nbsp;</td></tr>
  <?php } ?>
  <tr>
  <td bgcolor="#FFFFFF"></td>
  <td colspan="4" bgcolor="#FFE5A2" align="right">  
<br /><br /><strong>國立中正大學輔導中心</strong>
  <?php } ?></td>
   <td bgcolor="#FFFFFF"></td>
  </tr>
</table>
</div>
</body>
</html>