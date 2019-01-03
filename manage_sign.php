<?php
session_start();
//學生登入或管理者登入
if(empty($_SESSION['sid']) && empty($_SESSION['admin'])){
	echo "請登入";
	exit;
}
//避免有學號session和get不同的情形
if(empty($_SESSION['admin']))
	$sid=$_SESSION['sid'];
else	
	$sid=$_GET['sid'];

require_once("mysql.php");
require_once("user_auth.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_報名管理</title>

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

<body onload="MM_preloadImages('image/choose/81.gif','image/choose/82.gif','image/choose/84.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<?php
$activity_id = $_GET['aid'];
$sid = $_GET['sid'];
$row=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_activity` WHERE activity_id=".$activity_id));
$row_user=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_activity_sign_up`,`activity` WHERE `hai_active_activity_sign_up`.`activity_id`= `activity`.`activity_id` AND `hai_active_activity_sign_up`.`sid`='".$sid."' AND `hai_active_activity_sign_up`.`activity_id`=".$activity_id));
$student=get_student_data($sid); 
?>
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
			<table id="___01" width="1000" height="120" border="0" cellpadding="0" cellspacing="0">
              <tr>
				<td><img src="image/choose/00.png" width="12" height="120" alt=""></td>
				<td><a href="manage.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image61','','image/choose/81.gif',1)"><img src="image/choose/71.gif" alt="活動管理" width="224" height="120" id="Image61" /></a></td>
				<td></a><a href="manage_add.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image62','','image/choose/82.gif',1)"><img src="image/choose/72.gif" alt="新增活動" width="224" height="120" id="Image62" /></a></td>
				<td><a href="manage_detail.php?activity_id=<?php echo $activity_id;?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image64','','image/choose/84.gif',1)"><img src="image/choose/74.gif" alt="詳細資訊" width="224" height="120" id="Image64" /></a></td>
				<td><img src="image/choose/85.gif" width="224" height="120" alt="報名管理" /></td>
				<td><img src="image/choose/05.gif" width="92" height="120" alt=""></td>
			  </tr>
			</table>
	</td>
  </tr>
  <tr>
  	<td>
    	<form action="edit_data_do.php?sid=<?php echo $sid; ?>&a_id=<?php echo $activity_id; ?>" method="post" name="input_form" id="input_form" onsubmit="return check_form();">
    	<table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
        <tr valign="top"><td>
<!-- Start -->
		<table width="80%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
  <tr>
    <td align="right" class="m_word">活動名稱：</td>
    <td colspan="2" align="left"><?php echo $row['name']; ?></td>
    </tr>
  <tr>
  <td width="100" align="right" class="m_word">姓名：</td>
  <td width="300" align="left"><?php echo $student['name']; ?></td>
  <td width="300" align="left"><span class="m_word">學號：<?php echo $sid; ?></span></td>
  </tr>
  <tr>
  <td align="right" class="m_word">連絡電話：</td>
  <td align="left">
  <input name="s_phone" type="text" id="s_phone" size="20" value="<?php echo $row_user['phone']?>" class="required"/></td>
  <td align="left" class="m_word"><?php if($row_user['need_food']){?> 便當：
  <select name="s_food" id="s_food">
  <option value ="<?php echo $row_user['food']?>" ><?php echo $row_user['food']?></option>
  <option value="葷">葷</option>
  <option value="素">素</option>
  <option value="自理">自理</option>
  </select>
  <?php } ?></td>
  </tr>
  <tr>
  <td align="right" valign="top" class="m_word">E-mail：</td>
  <td colspan="2" align="left">
  <input type="text" size="50" name="s_email" id="s_email" value="<?php echo $row_user['email']?>" class="required"/></td>
  </tr>
  <?php 
	$i=1;//算問題數
	$result_qes=mysql_query("select * from activity_question where activity_id=".$activity_id);
	while($row_qes=mysql_fetch_array($result_qes)){  
?>
  <tr>
  <td align="right" valign="top" class="m_word">詢問事項<?php echo $i;?>：</td>
  <td colspan="2" class="r_word">
  <?php 
		echo $row_qes['question']."<p>";	//問題題目
		
		 $i++;
if($row_qes['type']=="M"){  
//多選題
?>
  </p>
  <p>
  <?php 
	$result_select=mysql_query("select * from `hai_active_activity_selection` where activity_id=".$activity_id." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
	//$result_select_up=mysql_query("select DISTINCT * from `activity_sign_up_select`,`activity_selection` where `activity_sign_up_select`.`activity_id`=`activity_selection`.`activity_id` AND `activity_sign_up_select`.`select_num`=`activity_selection`.`select_num` AND `activity_sign_up_select`.`activity_id`=45 and `activity_sign_up_select`.`question_num`='1' ORDER BY `activity_selection`.`select_num` ASC");
	$num_i=1;
	while($row_select=mysql_fetch_array($result_select))
	{
	
?>               
  <input type=checkbox value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select[]" /><?php echo $row_select['item']; ?>
  <?php $num_i++;?>
  <br/>
  <?php } ?>  
    
  <?php 
}elseif($row_qes['type']=="S"){ //單選題
    $result_select=mysql_query("select * from hai_active_activity_selection where activity_id='".$activity_id."' and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
	while($row_select=mysql_fetch_array($result_select)){
	?>
    <input type=radio value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select"><?php echo $row_select['item']; 
	?>
	<br />
	<?php
	} 
	
}elseif($row_qes['type']=="D"){ //開放式問題
//activity_id	sid	question_num	select_num	ans
	$result_select_D=mysql_query("select * from `hai_active_activity_sign_up_select` where activity_id=".$activity_id." and sid='".$sid."' and question_num='".$row_qes['question_num']."'");
	while($row_select_D=mysql_fetch_array($result_select_D)){
	//echo $row_select_D[0];
	?>
    <textarea cols="50" rows="3" name="q_<?php echo $row_qes['question_num'];?>_textans" class="required"><?php echo $row_select_D['ans']; ?></textarea>
    <?php 
	}
	?>
    <br />
  <?php
}else{
echo "錯誤";
}
} //結束迴圈
	$row_count=mysql_fetch_array(mysql_query("SELECT max(question_num) FROM `hai_active_activity_question` WHERE `activity_id`=".$activity_id));
	//計算問題題號最大值
	?><input name="max_qes" type="hidden" value="<?php echo $row_count[0]; ?>" />
    </p></td>
  </tr>
  
  <tr>
    <td align="right" valign="top" class="m_word">備註：</td>
    <td colspan="2" align="left"><textarea name="s_other" cols="60" rows="5" id="s_other"><?php echo $row_user['others']; ?></textarea></td>
    </tr>
  <tr>
    <td colspan="3" valign="middle" height="50" align="center" style="padding-right:20pt">
      
      <p><input id="m" type="submit" name="m" value="確認修改" onclick="student_check(183)" /></p></td>
    </tr>
  </tbody>
        </table>
<!-- End -->
        </td></tr>
        </table>
  </form>
    </td>
  </tr>
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>
</table>
</div>
</body>
</html>
