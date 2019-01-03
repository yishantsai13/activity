<?php

	//連線要放function內才不會讓其他非auth的sql混淆
	//$main_database_link=NULL;
	$db=2;//1為Sybase ; 2為postgreSQL
	$use_pg = 1;
	/*function student_conn(){
		//學生資料庫
		//if($db==1){
			//Sybase
			$host = "140.123.30.7:4100";
			$user = "advising";
			$passwd = "!advi!sing";
			$db="academic";
			global $main_database_link;
			if(!$main_database_link=sybase_connect($host, $user, $passwd)){die("mysql_connect failed<br/>無法連結學生資料庫，請聯絡系統管理員，謝謝。<p/>"); }
			if(!sybase_select_db($db,$main_database_link)) { die("mysql_select_db failed<br/>無法開啟學生資料庫，請通知系統管理員，謝謝。<p/>");}
			sybase_query("SET CHARACTER SET 'big5'",$main_database_link);
			sybase_query("SET NAMES 'big5' ",$main_database_link);
		}
		else if($db==2){
			
			//postgreSQL
			$conn_string = "host=140.123.26.159 dbname=academic user=advising password=adv@ising! options='--client_encoding=UTF8'";
			global $main_database_link;
			if(!$main_database_link=pg_connect($conn_string)){
			echo "error msg = ";
			print_r(pg_last_error($main_database_link));
			die("database_connect failed<br/>無法連結學生資料庫，請聯絡系統管理員，謝謝。<p/>"); 
			}
		//}
		
		
		//MySQL
		$host = "localhost";
		$user = "hai_active";
		$passwd = "aUQpTdnX5JDzn9fm";
		$db="hai_active";
		
	}*/
	$main_database_link=NULL;
	function student_conn(){
                $test = 2;

                if( 1 == $test ) {
                  $host = "140.123.26.159";
                }else{
                  $host = "140.123.30.12";
                }

                $conn_string = "host=140.123.30.12 dbname=academic user=advising password=adv@ising! options='--client_encoding=UTF8'";


                $user = "advising";
                $passwd = "adv@ising!";
                $db="academic";

                global $main_database_link;
                if (!($main_database_link=pg_connect($conn_string)) ) {
                  echo "error msg = ";
                  print_r(pg_last_error($main_database_link));
                  die("mysql_connect failed!");
                }

        }



	
	$manager_mysql_link=NULL;	
	function management_conn(){
		//管理者資料庫
		$host = "localhost";
		$user = "advising";
		$passwd = "ccumis_advising"; 
		$db="advising";
		
		
		global $manager_mysql_link;
		if(!$manager_mysql_link=mysql_connect($host, $user, $passwd)){ die("mysql_connect failed<br/>無法連結管理者資料庫，請聯絡系統管理員，謝謝。<p/>");}
		if(!mysql_select_db($db,$manager_mysql_link)) { die("mysql_select_db failed<br/>無法開啟管理者資料庫，請通知系統管理員，謝謝。<p/>");}
		mysql_query("SET CHARACTER SET 'utf-8'",$manager_mysql_link);
		mysql_query("SET NAMES 'utf-8' ",$manager_mysql_link);		
	}
	
///////////////////////////////////////////////////////////////////////

        function my_query($link, $sql)
        {
        	global $use_pg;
        	if( $use_pg == 1 ){
            	$result = pg_query($link, $sql)or die(pg_last_error());
			if (!($result) ) {
               			 echo "<br />query error msg = ";
        			print_r(pg_last_error(pg_query($link, $sql)));
        		}
		}
        	else
        		$result = sybase_query($sql, $link);
        	return $result; 
        }

	function check_student($id,$pw){
		global $main_database_link;
		if($main_database_link==NULL){
			echo "未連結DB";
			student_conn();
		}
		//if($db==1){
		/*	$row=sybase_fetch_array(sybase_query("select * from a11vstd_advise where std_no='".$id."'",$main_database_link));
		}
		else if($db==2){*/
			//$row=pg_fetch_array(pg_query($main_database_link,"select * from a11vstd_advise where std_no='".$id."'"));
		//}
		$sql = "SELECT * FROM a11vstd_advise where std_no like '".$id."'";
        	
		$result = my_query($main_database_link, $sql);
        	$row = pg_fetch_array($result);
		
		if($row['pwd']==$pw){
			return true;
		}
		return false;
	}

        
	
	function get_student_data($id){
		global $main_database_link;
		if($main_database_link==NULL)
			student_conn();
		//if($db==1){
		/*	$row=sybase_fetch_array(sybase_query("select * from a11vstd_advise where std_no='".$id."'", $main_database_link));
			$nameb5 = $row['name'];
			$nameutf=mb_convert_encoding($nameb5,"utf-8","big5");
			$row['name']=$nameutf;
			
			$deptb5 = $row['deptname'];
			$deptutf=mb_convert_encoding($deptb5,"utf-8","big5");
			$row['dept']=$deptutf;
			
			$gradeb5 = $row['now_grade'];
			$gradeutf=mb_convert_encoding($gradeb5,"utf-8","big5");
			$row['grade']=$gradeutf;			
			
			$classb5 = $row['now_class'];
			$classutf=mb_convert_encoding($classb5,"utf-8","big5");
			$row['class']=$classutf;
		}
		else if($db==2){*/
			//$row=pg_fetch_array(pg_query($main_database_link, "select * from a11vstd_advise where std_no='".$id."'"));
		//}
		
		$sql = "SELECT * FROM a11vstd_advise where std_no like '".$id."'";
        	$result = my_query($main_database_link, $sql);
        	$row = pg_fetch_array($result);
		
		if($row==NULL){
			return NULL;
		}
		
		$student_data=array();
		$student_data['sex']=$row['sex_id'];
		$student_data['name']=$row['name'];
		$student_data['dept']=$row['deptname'];
		$student_data['grade']=$row['now_grade'];
		$student_data['class']=$row['now_class'];
		
		
		return $student_data;		
	}


	function check_manager($id,$pw){
		
		global $manager_mysql_link;
		if($manager_mysql_link==NULL)
			management_conn();
		/*
		if($id=="advising" && $pw=="advising@ccu"){
			return true;
		}
		*/
		
		$id=htmlentities($id);
		$row=mysql_fetch_array(mysql_query("select * from hai_active_tblUser where fldName='".$id."'",$manager_mysql_link));
		if($row['fldPasswd']==$pw){
			return true;
		}
		
		return false;		
	}
	
	//檢查管理者的單位
	function check_dept($id){
		global $main_mysql_link;//$manager_mysql_link
		if($main_mysql_link==NULL)
			management_conn();
		/*if($id=="advising")
			return "輔導中心";*/		
		$id=htmlentities($id);
		$row=mysql_fetch_array(mysql_query("select * from hai_active_tblUser where fldName='".$id."'",$main_mysql_link));
		return $row['fldDept'];
	}

?>
