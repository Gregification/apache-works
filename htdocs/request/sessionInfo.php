<?php
    if(session_status() == PHP_SESSION_NONE) session_start();
    include_once "/var/private_request/config.php";

    $attrs = explode(',', $_GET['attribute'] ?? '');
    $attrs = array_unique($attrs, SORT_STRING);
    
    //eh
    $whitelist = array(
        'username',
        'chatname',
        'chatid'
    );

    $attrs = array_filter($attrs, function($v) use ($whitelist){
        return in_array($v, $whitelist, false);
    });

    $ret = array();
    foreach($attrs as $v) $ret[$v] = $_SESSION[$v];

    echo json_encode($ret);
?>