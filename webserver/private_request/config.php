<?php 
    error_reporting(E_ALL);

    if(session_status() == PHP_SESSION_NONE) session_start();

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
        'chat title charlimit'          => 255,
        'chat description charlimit'    => 1500,
        'chat message charlimit'        => 2000,
        'chat schema'       => 'chats',
        'chat meta columns' => array(
                'title',
                'lastactivetime',
                'creationtime',
                'description',
                'usersonline',
                'id'
            ),
        'chat columns'      => array(
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
            : chatdbpath        x
    */

    try {
        $connectionInfo = json_decode(file_get_contents('/var/private_request/psqlConnectionInfo.json'), true);
        
        $host       = $connectionInfo['iPv4'];
        $port       = $connectionInfo['port'];
        $dbname     = "chatdb";
        $user       = "postgres";
        $password   = "password";
        
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, 1);
    } catch (PDOException $e) {
        trigger_error("failed to connect to db\t" . $e->getMessage(), E_USER_ERROR);
    }

    ////////////////////////////////////////////////////////////////////
    //funcitons
    ////////////////////////////////////////////////////////////////////

    //standard way to get a tables name
    $getTableName = function (int $id) use ($dbinfo) : string {
            return $dbinfo['chat id prefix'] . $id;
        };
    
    //standard way to get a full pgsql path for a table. preffered over config.php/.getTableName()
    $getTablePath = function ($id) use ($dbinfo, $conn, $getTableName) {
            if(!is_int($id)){
                $q  = $conn->prepare("select id from {$dbinfo['chat table']} where title=?");
                $q->execute([$id]);
                $id = $q->fetchColumn();
            }
            return empty($id) ? null : $dbinfo['chat schema'] . '.' . $getTableName(intval($id));
        };
?>