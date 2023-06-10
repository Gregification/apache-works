<?php 
    $conn;//pdo conneciton

    //all table columns should be lowercase
    $dbinfo = array(
        'image table'   => 'public._images',
        'user table'    => 'public._users',
        'username charlimit'    => 255,
        'user columns'  => array(
                'username',
                'lastactivetime',
                'creationtime',
                'description'
            ),
        'chat table'    => 'public._chats',
        'chat template' => 'public._chattemplate',
        'chat title charlimit'  => 255,
        'chat description charlimit'    => 1500,
        'chat message charlimit'    => 2000,
        'chat schema'   => 'chats',
        'chat meta columns'  => array(
                'title',
                'lastactivetime',
                'creationtime',
                'description',
                'usersonline',
                'id'
            ),
        'chat columns'  => array(
                'timedelivered',
                'message',
                'by'
            ),
        'chat id prefix'    => '_'
    );

    /* 
        - no premission restrictions. r/w/x everything ... 

        $_SESSION           jsavaliable
            : username          
            : chatname      
            : chatid            x
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