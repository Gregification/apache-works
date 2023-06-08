<?php
    session_start();
    include_once "/var/private_request/config.php";

    $attrName   = $_GET['attribute'] ?? 'null';

    //eh, it works good enough as is
    $whitelist = array(
        'username'
    );

    //validation
    if(!in_array($attrName, $whitelist, false))     return;

    echo $_SESSION[$attrName];
?>