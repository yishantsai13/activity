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
    <script type="text/javascript" src="uploadify/jquery-1.4.2.min.js"></script>
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
		'scriptData'  : {'activity_id':'<?php echo $_GET['activity_id']; ?>'},
		'queueID'        : 'file-upload-queue',
		'onSelectOnce'   : function(event,data) {
      $('#status-message').text(data.filesSelected + ' files have been added to the queue.');
    },
		'onAllComplete' : function(event,data) { 
			$('#status-message').text(data.filesUploaded + ' files uploaded, ' + data.errors + ' errors.');
			location.reload(true); 
			},
		'onOpen': function(event,data){
				 $(":button").hide("slow");	
				 $(":submit").hide("slow");
				$('#file_list').html("上傳中請等待");
					
			}
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

<body>
<div id="container">
<?php 
	$row=mysql_fetch_array(mysql_query("select * from activity where activity_id='".$_GET['activity_id']."'"));
?>
  <p align="center"><?php echo $row['name']; ?> 檔案管理</p>
  <p align="center">&nbsp;</p>
  <table width="927" border="0" align="center">
    <tr>
      <td width="449" valign="top"><div id="file_upload_section">
        <p align="center">
          <input id="file_upload" type="file" name="Filedata" />
        </p>
        <div id="file-upload-queue"></div>
        <p>&nbsp; </p>
      </div></td>
      <td width="468" valign="top"><p align="center">現有檔案</p>
      <form  method="post" action="manage_active_file_do.php">
      <input name="activity_id" type="hidden" value="<?php echo $_GET['activity_id'];?>" />
        <input name="set_cover" type="hidden" value="1" />
        <table id="file_list" width="441" border="0" align="center">
          <tr>
            <td width="57">封面</td>
            <td width="264" height="25">檔名</td>
            <td width="59">型態</td>
            <td width="43">&nbsp;</td>
          </tr>
          <?php 
	$result=mysql_query("select * from activity_file where activity_id='".$_GET['activity_id']."'");
	while($row=mysql_fetch_array($result)){
	?>
          <tr>
            <td><input type="radio" name="cover_fid" value="<?php echo $row['fid']; ?>" <?php if($row['cover']){ echo 'checked';}?> />
              </td>
            <td><a href="<?php echo $row['path'];?>"><?php echo $row['fname'];?></a></td>
            <td><?php echo $row['ftype']; ?></td>
            <td><a  name="del_file" href="manage_active_file_do.php?del_file=1&amp;fid=<?php echo $row['fid']; ?>">刪除</a></td>
          </tr>
          <?php } ?>
        </table>
        <p align="center">
          <input type="submit"  id="button_set_cover" value="設定封面" />
        </p>
      </form></td>
    </tr>
  </table>
  <p align="center">
    <input type="button" value="結束編輯"  id="end_button" onclick="location='manage_active.php'"/>
  </p>
</div>
</body>
</html>