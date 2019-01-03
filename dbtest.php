<?PHP

    $use_pg = 2;

        $main_sybase_link = NULL;

        student_conn();
        echo "link = ";
        print_r($main_sybase_link);


        $sql = "SELECT * FROM a11vstd_advise";
        $result = my_query($main_sybase_link, $sql);
        $row = pg_fetch_array($result);
        echo "學生資料是: ";
        print_r($row);

        ///////////////////////////////////////////////////////////////////////
        function my_query($link, $sql)
        {
          global $use_pg;
          if( $use_pg == 1 )
            $result = pg_query($link, $sql);
          else
            $result = sybase_query($sql, $link);
          return $result;
        }
        ////////////////////////////////////////////////////////////////////////
        function student_conn(){
                $test = 1;

                if( 1 == $test ) {
                  $host = "140.123.26.159";
                }else{
                  $host = "140.123.30.12";
                }

                $conn_string = "host=" . $host . " dbname=academic user=advising
password=adv@ising! options='--client_encoding=UTF8'";


                $user = "advising";
                $passwd = "adv@ising!";
                $db="academic";

                global $main_sybase_link;
                if (!($main_sybase_link=pg_connect($conn_string)) ) {
                  echo "error msg = ";
                  print_r(pg_last_error($main_sybase_link));
                  die("mysql_connect failed!");
                }

        }


?>