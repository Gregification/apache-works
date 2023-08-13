<?php
    //header("Content-Type: application/json");
    
    foreach(array('PHP_SELF', 'SERVER_NAME','HTTP_HOST','HTTP_USER_AGENT','SCRIPT_NAME','REMOTE_ADDR'
        ) as $v){
        echo $v . ': ' . $_SERVER[$v] . "<br>";
    }
    // echo '&emsp;name by address: ' . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "<br>";

    $connectionInfo = json_decode(file_get_contents('/var/private_request/psqlConnectionInfo.json'), true);

    $host = $connectionInfo['iPv4'];
    $port = $connectionInfo['port'];
    $dbname = "chatdb";
    $user = "postgres";
    $password = "password";
    
    try {
        $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
        echo "Connected to the database successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>