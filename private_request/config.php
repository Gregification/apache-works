<?php 
    $conn;    
    try {
        $connectionInfo = json_decode(file_get_contents('/var/private_request/psqlConnectionInfo.json'), true);
        
        $host = $connectionInfo['iPv4'];
        $port = $connectionInfo['port'];
        $dbname = "chatdb";
        $user = "postgres";
        $password = "password";
        $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
        echo "Connected to the database successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>