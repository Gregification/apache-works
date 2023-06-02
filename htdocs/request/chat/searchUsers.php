<?php
    session_start();
    include_once "/var/private_request/config.php";

    $term   = $_POST['searchTerm'];
    $ordBy  = $_POST['orderBy'];
    $dr     = $_POST['dr'];

    $srch   = $conn->prepare("select (username,creationtime,lastactivetime) where username like ");
?>