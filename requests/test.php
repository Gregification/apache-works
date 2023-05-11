<?php
    foreach(array('PHP_SELF', 'SERVER_NAME','HTTP_HOST','HTTP_REFERER','HTTP_USER_AGENT','SCRIPT_NAME'
        ) as $v){
        echo $v . ': ' . $_SERVER[$v] . "<br>";
    }

    try{
        $con = pg_connect("host=localhost port=5432 dbname=fiddle user=postgres password=pasword");
        if($con){
            echo "connected";
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
?>