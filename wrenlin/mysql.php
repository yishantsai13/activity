<?php
	$host = "localhost";
	$user = "wrenlinm_hai";
	$passwd = "HD%xD1k-G&4("; 

	if(!mysql_connect($host, $user, $passwd)){ die("mysql_pconnect failed<br/>無法連結資料庫，請聯絡系統管理員，謝謝。<p/>");}
	if(!mysql_select_db("wrenlinm_hai")) { die("mysql_select_db failed<br/>無法開啟資料庫，請通知系統管理員，謝謝。<p/>");}
	mysql_query("SET CHARACTER SET 'utf8'");
	mysql_query("SET NAMES 'utf8' ");
	
	$upload_path='upload';
	
	function string_escape($content){
		if(!get_magic_quotes_gpc()){ //get_magic_quotes_gpc為0代表它是off
			$content=mysql_real_escape_string($content);//取代包含" '的字元		
		}
		$content=str_replace("<!--","", $content);//取代惡意的網頁註解字元	
		
		return $content;
	}

?>
