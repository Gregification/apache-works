<?php 
    $conn;//pdo conneciton
    $dbtables = array(
        'user table' =>  '_users',
        'image table'   =>  '_images',
        'chat table'    =>  '_chats',
        'chat table templet'    =>  '_chattemplet'
    );

    try {
        $connectionInfo = json_decode(file_get_contents('/var/private_request/psqlConnectionInfo.json'), true);
        
        $host = $connectionInfo['iPv4'];
        $port = $connectionInfo['port'];
        $dbname = "chatdb";
        $user = "postgres";
        $password = "password";
        
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>