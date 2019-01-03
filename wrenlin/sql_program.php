<?php
	$host_program = "140.123.5.5";
	$user_program  = "progmer";
	$passwd_program  = "#data14105"; 

	if(!mysql_connect($host_program, $user_program, $passwd_program)){ die("mysql_pconnect failed<br/>無法連結資料庫，請聯絡系統管理員，謝謝。<p/>");}
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8' ");
	/*
	function string_escape($content){
		if(!get_magic_quotes_gpc()){ //get_magic_quotes_gpc為0代表它是off
			$content=mysql_real_escape_string($content);//取代包含" '的字元		
		}
		$content=str_replace("<!--","", $content);//取代惡意的網頁註解字元	
		
		return $content;
	}
*/
	/*
	 $result=mysql_query("SELECT * FROM  `tblUser`");
		  while($row=mysql_fetch_array($result)){
		  echo $row['fldName'],$row['fldPasswd'],$row['fldDept'];
		  }
		  */
?>
