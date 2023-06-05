<?php 
    // include_once "/var/private_request/genName.php"; 
    // genSet_useablename(false); 
    // echo $_SESSION['username'];

    include_once "/var/private_request/config.php";
    $q = $conn->prepare("select * from ".$dbinfo['user table'].";");
    $q->execute();
    $res = $q->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($res);
?>