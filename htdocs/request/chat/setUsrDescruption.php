<?php
    include_once "/var/private_request/config.php";

    $des        = $_POST['description'];
    $username   = $_POST['username'];

    if(empty($des)) $des = ' ';
    if(empty($username)) return;

    $q = $conn->prepare("update". $dbinfo['user table'] ."set description = :des where username = :usr return creationtime;");
    echo $q->execute(['des' => $des, 'usr' => $username]);
    return;
?>