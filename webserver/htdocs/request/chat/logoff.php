<?php
    //replace all

    session_start();
    include_once "/var/private_request/config.php";

    $usr    = $_SESSION['username'] ?? null;

    if(empty($usr)) return;
    
    $q  = $conn->prepare("update ".$dbinfo['user table']." set lastactivetime=? where username=?;");
    $q->execute([time(), $usr]);

    if(isset($_SESSION['chatid'])){
        $q = $conn->prepare("update ".$dbinfo['chat table']." set usersonline=usersonline+? where id=?;");
        $q->execute([-1,$_SESSION['chatid']]);
    }
?>