<?php
    /* 
        same as /var/genName.php except calls it automatically
    */
    session_start();
    include_once "/var/private_request/genName.php";
    
    $usePreexisting = $_POST['usepreexisting'] ?? false;
    
    if(!isset($usePreexisting) || !is_bool($usePreexisting)) $usePreexisting = true;

    genSet_useablename($usePreexisting);
    echo $_SESSION['username'];
    return;
?>