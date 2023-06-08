<?php
    session_start();
    include_once "/var/private_request/config.php";

    $des        = $_POST['description'] ?? null;
    $username   = $_SESSION['username'] ?? null;

    if(empty($username))    return;
    if(empty($des))         return;

    try{
        $conn->beginTransaction();
        $q = $conn->prepare("update ". $dbinfo['user table'] ." set description = :des where username = :usr;");
        $q->execute(['des' => $des, 'usr' => $username]);
        $conn->commit();
    }catch(PDOException $e){ 
        $conn->rollBack();
    }
    // echo "\r\nusr: ".$username."\r\ndescrition: ".$des."\r\n";
?>