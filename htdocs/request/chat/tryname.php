<?php
    session_start();
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
    $fnewName = $_POST['newName'];
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($fnewName)){
        $ev = $conn->prepare("select lastactivetime from ? where username=?;"); 
        $ev->execute([$dbtables['user table'], $fnewName]);
        $a = $ev->fetchColumn();
        if($a == null) { 
            //add new user
            try{
                $conn->beginTransaction();
                $ev = $conn->prepare(
                    "insert into ? (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1);"
                    );
                $ev->execute([$dbtables['user table'], $fnewName]);
                $conn->commit();

                echo 'success_newUser';
            }catch (PDOException $e) {
                $conn->rollBack();

                echo 'fail_insertion';
            }
        }else{ //name already exists
            
            //if online
            if($a == -1){
                echo 'fail_userOnline'; 
                return;
            }

            //update lastactivetime
            $ev = $conn->prepare("update ? set lastactivetime = ? where username = ?;");
            try{
                $conn->beginTransaction();
                $ev->execute([$dbtables['user table'], 'extract(epoch from now())', $_SESSION['username']]);//set former name offline
                $conn->commit();
            }catch(PDOException $e){    $conn->rollBack();  } //expected to fail if the orgional name dosent exist, in case susch as a new user
            $ev->execute([$dbtables['user table'], -1, $fnewName]);//set new name online

            $_SESSION['username'] = $fnewName;

            echo 'success_adoptedNewName';
        }
    }
?> 