<?php
    include_once "/var/private_request/config.php";

    /* 
    https://www.php.net/manual/en/function.pg-prepare.php 
        ^ "User Contributed Notes: ... 17 years ago ..." bruh
    -query names are scoped to each session    
    */
    $fname = $_POST['newName'];
    
    if(empty($fname)){
        echo 'name is empty';
    }else{
        echo 'name to try: ' . $fname;
    }
?> 