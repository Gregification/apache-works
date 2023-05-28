<?php
    include_once "/var/private_request/config.php";
    
    /* 
    https://www.php.net/manual/en/function.pg-prepare.php 
        ^ "User Contributed Notes: ... 17 years ago ..." bruh
    https://www.php.net/manual/en/pdo.prepare.php
        ^posted comments are helpful
    -query names are scoped to each session
    -string excape filtering done during pdo->prepare. => can leave as raw string. 
    */

    // $sql = 'SELECT * FROM _user';
    // foreach ($conn->query($sql) as $row) {
        // print $row['username'] . ":\t";
        // print $row['creationtime'] . "-->\t";
        // print $row['lastactivetime'] . "\n";
    // }

    $fname = $_POST['newName'];
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($fname)){
        $ev = $conn->prepare("select not exists (select 1 from _user where username=?);");
        $ev->execute([$fname]);
        if($ev->fetchColumn() == true) {

            //add new user
            try{
                $conn->beginTransaction();
                $ev = $conn->prepare(
                    "insert into _user (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1));"
                    );
                $ev->execute([$fname]);
                $conn->commit();
            }catch (PDOException $e) {
                $conn->rollBack();
                throw $e;
            }
        }else{ //name already exists
            //update row lastactive time to online
            $ev = $conn->prepare(
                "update _user set lastactivetime=-1 where username = ?;"
            );
            $ev->execute([$fname]);
        }
    }

    function setName($name){
        global $conn;
        
    }
?> 