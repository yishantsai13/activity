<?php
session_start();
require_once("mysql.php");
include_once("user_auth.php");


	$db=1;//1為Sybase ; 2為postgreSQL
	function my_query($link, $sql)
    {
		global $db;
		if( $db == 1 )
            $result = sybase_query($sql, $link);
		else if ( $db == 2)
            $result = pg_query($link, $sql);
		return $result;
    }
	
	function mu_fetch_array($link, $sql)
	{
		if( $db == 1 )
            $result = sybase_fetch_array(myquery($link,$sql));
		else if ( $db == 2)
            $result = pg_fetch_array(myquery($link,$sql));
		return $result;
	}
		
	

?>