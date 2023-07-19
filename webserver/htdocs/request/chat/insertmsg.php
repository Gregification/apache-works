<?php /* requres session and post to discourage out of line access */
    include_once "/var/private_request/config.php";

    if(!isset($_SESSION['username']) || !isset($_SESSION['chatid']))   return;

    $msg    = $_POST['message'] ?? null;
    // echo "usr:\r\t".$_SESSION['username']."\r\nmsg:\r\t".$msg."\r\n";
    if(empty($msg)) return;

    $time = time();

    $q  = $conn->prepare("
        update {$dbinfo['chat table']} set lastactivetime=:time where id=:id;
        insert into {$_SESSION['chatdbpath']} (timedelivered,\"by\",message) values (:time,:by,:msg) returning timedelivered,\"by\",message;
        ");
    $q->execute([
        'time'  => $time,
        'by'    => $_SESSION['username'],
        'msg'   => $msg,
        'id'    => $_SESSION['chatid']
    ]);

    echo json_encode($q->fetchAll(PDO::FETCH_ASSOC));
?>
