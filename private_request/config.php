<?php 
    $conn;//pdo conneciton

    //all table columns should be lowercase
    $dbinfo = array(
        'user table' =>  '_users',
        'image table'   =>  '_images',
        'chat table'    =>  '_chats',
        'chat table templet'    =>  '_chattemplet',
        'username charlimit' => 255,
        'chat title charlimit' => 255,
        'chat description charlimit' => 1500,
        'user columns' => array(
                'username',
                'lastactivetime',
                'creationtime',
                'description'
            ),
        'chat columns' => array(
                'title',
                'lastactivetime',
                'creationtime',
                'description',
                'usersonline'
            )
    );

    /* 
        $_SESSION
            : username
            : chatname
    */

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