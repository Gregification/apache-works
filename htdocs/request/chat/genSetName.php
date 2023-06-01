<?php
    /* 
        same as /var/genName.php except calls it automatically
    */
    session_start();
    include_once "/var/private_request/genName.php";

    $v = 'usePreexistingName';
    setNewUseableName(isset($_POST[$v]) ? $_POST[$v] : false);
    return;
?>