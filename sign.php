<?php
session_start();
$this_page = basename(__FILE__); 
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
$activity_id = $_GET['activity_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活動報名系統_我要報名</title>

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

<body onload="MM_preloadImages('image/choose/21.gif','image/choose/22.gif','image/choose/23.gif','image/login2.png','image/logout2.png')">
<div id="wrapper">
<table width="1000"border="0" cellspacing="0" cellpadding="0" align="center" background="image/bg5.jpg" id="tablegb">
  <tr  height="195" >
	<td></td>
  </tr>
  <tr height="41">
	<td>
		<?php 
		$student=get_student_data($sid); 
		if($_SESSION['admin']){
			echo '&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5">'.$_SESSION['admin']."，您好</font>";
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			echo '<font Face="細明體" size="5"><a href="manage_active.php">進入管理介面</a></font>';
		?>
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		else if($_SESSION['sid']){
		?>
        &nbsp;&nbsp;
		<font Face="細明體" size="5"><?php echo $student['name']; ?>，您好</font>
        <a href="logout.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogout','','image/logout2.png',1)"><img src="image/logout.png" alt="登出" width="80" height="41" id="Imagelogout" /></a>
		<?php
        }
		else{
		?>
        <a href="login.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagelogin','','image/login2.png',1)"><img src="image/login.png" alt="登入" width="80" height="41" id="Imagelogin" /></a>
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
				<td><a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','image/choose/21.gif',1)"><img src="image/choose/11.gif" alt="活動列表" width="224" height="120" id="Image1" /></a></td>
				<td><a href="regi_activity.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','image/choose/22.gif',1)"><img src="image/choose/12.gif" alt="我的活動" width="224" height="120" id="Image2" /></a></a></td>
				<td><a href="detail_infor_sign.php?aid=<?php echo $activity_id;?>&amp;sid=<?php echo $sid;?>" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','image/choose/23.gif',1)"><img src="image/choose/13.gif" alt="詳細資訊" width="224" height="120" id="Image3" /></a></td>
				<td><img src="image/choose/25.gif" width="224" height="120" alt="我要報名" /></td>
				<td><img src="image/choose/05.gif" width="92" height="120" alt=""></td>
			  </tr>
			</table>
	</td>
  </tr>
  
  <tr>
  	<td>
<!-- Start -->
		<?php    
		$row=mysql_fetch_array(mysql_query("SELECT * FROM `hai_active_activity` WHERE activity_id=".$_GET['activity_id']));
		$row_count=mysql_fetch_array(mysql_query("SELECT count(*) FROM `hai_active_activity_sign_up` WHERE activity_id=".$row['activity_id']));
		if($row_count[0] < $row['max']){   //未額滿才顯示報名表 
			$result_apply=mysql_fetch_array(mysql_query("SELECT `sid` FROM  `hai_active_activity_sign_up` WHERE `sid`=".$_SESSION['sid']." AND activity_id=".$_GET['activity_id']));
			?>
			<form action="sign_do.php" method="post" name="input_form" id="input_form" onsubmit="return check_form();">
			<input name="sign" type="hidden" value="1" />
			<input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id']; ?>" />
<!-- End -->
			<table width="95%" height="500" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
            <tr valign="top"><td>
<!-- Start -->
            <table width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="white" align="center">
			<tbody>
				<tr bgcolor="E5D6E5">
					<td width="14%" align="right" class="m_word"><font Face="標楷體" size="5"><strong>活動編號</strong></font></td>
					<td width="1%" align="right" class="m_word">&nbsp;</td>
					<td width="33%" align="left"><font size="5"><?php echo $row['activity_id']; ?></font></td>
					<td width="12%" align="right"><span class="m_word"><font Face="標楷體" size="5"><strong>活動名稱</strong></font></span></td>
					<td width="1%" align="left">&nbsp;</td>
					<td width="35%" align="left"><span class="m_word"><font size="5"><?php  echo $row['name']; ?></font></span></td>
				</tr>
				<tr bgcolor="EFE9EF">
					<td width="14%" align="right" class="m_word"><font Face="標楷體" size="5"><strong>姓名</strong></font></td>
					<td width="1%" align="right" class="m_word">&nbsp;</td>
					<td width="33%" align="left"><font size="5"><?php echo $student['name']; ?></font></td>
					<td width="12%" align="right"><span class="m_word"><font Face="標楷體" size="5"><strong>學號</strong></font></span></td>
					<td width="1%" align="left">&nbsp;</td>
					<td width="35%" align="left"><span class="m_word"><font size="5"><?php  echo $_SESSION['sid']; ?></font></span></td>
				</tr>
				<tr bgcolor="E5D6E5">
					<td width="14%" align="right" class="m_word"><font Face="標楷體" size="5"><strong>行動電話</strong></font></td>
					<td width="1%" align="right" class="m_word">&nbsp;</td>
					<td align="left" colspan="4"><input name="s_phone" type="text" id="s_phone" maxlength="10" size="10" class="required" /><font size="-3">(例：0900111222)</font></td>
				</tr>
                <tr bgcolor="EFE9EF">
				<?php  
				if($row['need_food']){ //如果有提供便當才會出現此表格 ?>
				
					<td width="14%" align="right" class="m_word"><font Face="標楷體" size="5"><strong>便當</strong></font></td>
					<td width="1%" align="right" class="m_word">&nbsp;</td>
					<td align="left" colspan="4">
						<select name="s_food" id="s_food">
						<option value="葷">葷</option>
						<option value="素">素</option>
						<option value="自理">自理</option>
						</select></td>
				
				<?php }
				else{?>
					<td colspan="6">&nbsp;</td>
				<?php } ?>
                </tr>
      
				<tr bgcolor="E5D6E5">
					<td width="14%" align="right" valign="top" class="m_word"><font Face="標楷體" size="5"><strong>E-mail</strong></font></td>
					<td width="1%" align="right" valign="top" class="m_word">&nbsp;</td>
					<td colspan="4" align="left"><input type="text" size="50" name="s_email" id="s_email" class="required email" /></td>
				</tr>
				<?php 
				$i=1;//算問題數
				$result_qes=mysql_query("select * from hai_active_activity_question where activity_id=".$_GET['activity_id']);
				while($row_qes=mysql_fetch_array($result_qes)){
				if($i % 2 > 0){$bgcolor="EFE9EF";}
                        else{$bgcolor="E5D6E5";}   
				?>
				<tr bgcolor=<?php echo $bgcolor; ?>>
					<td width="14%" align="right" valign="top" class="m_word"><font Face="標楷體" size="5"><strong>詢問事項<?php echo $i;?></strong></font></td>
					<td width="1%" align="right" valign="top" class="m_word">&nbsp;</td>
					<td colspan="4" class="r_word"><?php echo "<font size='5'>".$row_qes['question']."</font><p>"; $i++;
					if($row_qes['type']=="M"){  //多選題 ?>
					<p>
					<?php 
					$result_select=mysql_query("select * from `hai_active_activity_selection` where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
					while($row_select=mysql_fetch_array($result_select)){
					?>              
					<input type="checkbox" value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select[]" class="required" /><?php echo $row_select['item']; ?>
					<br />
					<?php } ?>  
					<br />
					<?php }
					elseif($row_qes['type']=="S"){  //單選題					
					$result_select=mysql_query("select * from `hai_active_activity_selection` where activity_id=".$_GET['activity_id']." and question_num='".$row_qes['question_num']."' ORDER BY `select_num` ASC");
						while($row_select=mysql_fetch_array($result_select)){
						?>
						<input type=radio value="<?php echo $row_select['select_num']; ?>" name="q_<?php echo $row_qes['question_num'];?>_select" class="required" ><?php echo $row_select['item']; echo "<br />";
						} ?>
					<br />
					<?php 
					}
					elseif($row_qes['type']=="D"){  //開放性問題
					?>
					<textarea cols="100" rows="3" name="q_<?php echo $row_qes['question_num'];?>_textans" class="required"></textarea>
					<br />
					<?php }
					else{
						echo "錯誤";
					}?>
					</p></td>
				</tr>
				<?php } 
		  		$row_count=mysql_fetch_array(mysql_query("select max(question_num) from hai_active_activity_question where activity_id=".$_GET['activity_id'])); //計算問題題號最大值
				?>
				<input name="max_qes" type="hidden" value="<?php echo $row_count[0]; ?>" />
			  	<?php	if(++$i % 2 > 0){$bgcolor="E5D6E5";}
                        else{$bgcolor="EFE9EF";} ?>
				<tr bgcolor=<?php echo $bgcolor; ?>>
					<td width="14%" align="right" valign="top" class="m_word"><font Face="標楷體" size="5"><strong>備註</strong></font></td>
					<td width="1%" align="right" valign="top" class="m_word">&nbsp;</td>
					<td colspan="4" align="left"><textarea name="s_other" cols="50" rows="3" id="s_other"><?php echo $row['require']; ?></textarea></td>
				</tr>
				<tr>
					<td colspan="6" valign="middle" height="50" align="center" style="padding-right:20pt"><input id="m" type="submit" name="m" value="報名" onclick="student_check(183)" /></td>
				</tr>
			<tr><td width="14%"></tbody>
			  <td width="1%">                          
			</table>
            </td></tr>
            </table>
			</form>
     </td>
  </tr>
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>

        <?php 
		} //未額滿顯示報名表
	    else{  //如果額滿
	    ?>
		<table width="95%" border="0" cellspacing="1" cellpadding="0" align="center" bgcolor="#FFFFFF">
		<tr bgcolor="#FFFFFF" height="500" align="center"><td><font Face="標楷體" size="10" color="#FF0000">本活動已額滿</font></td></tr>
		</table>
     </td>
  </tr>
  <tr height="68" >
	<td colspan="2" align="right"><br /><br /><strong>國立中正大學輔導中心</strong></td>
  </tr>	    <?php
	    } 
        ?>
<!-- End -->
</table>
</div>
</body>
</html>
