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
    //     print $row['username'] . ":\t";
    //     print $row['creationtime'] . "-->\t";
    //     print $row['lastactivetime'] . "\n";
    // }
    $fnewName = $_POST['newName'];
    if(!empty($_SESSION['username']) && $fnewName == $_SESSION['username']) return 'fail_sameAsUsername';

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($fnewName)){
        $ev = $conn->prepare("select lastactivetime from ".$dbtables['user table']." where username=?;"); 
        $ev->execute([$fnewName]);
        $a = $ev->fetchColumn();
        if($a == null) { 
            //add new user
            try{
                $conn->beginTransaction();
                $ev = $conn->prepare(
                    "insert into ".$dbtables['user table']." (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1);"
                    );
                $ev->execute([$fnewName]);
                $conn->commit();

                echo 'success_newUser';
            }catch (PDOException $e) {
                $conn->rollBack();

                echo 'fail_insertion';
            }
        }else{ //name already exists
            
            //if online
            if($a == -1) {
                echo 'fail_userOnline';
                return;
            }

            //update lastactivetime for the new and old name
            $ev = $conn->prepare("update ".$dbtables['user table']." set lastactivetime = ? where username = ?;");
            if(!empty($_SESSION['username'])){
                echo 'session[username]:' . $_SESSION['username'];
                try{
                    $conn->beginTransaction();
                    $ev->execute(['extract(epoch from now())', $_SESSION['username']]);//set former name offline
                    $conn->commit();
                }catch(PDOException $e){    $conn->rollBack();  }
            }
            $ev->execute([-1, $fnewName]);//set new name online

            $_SESSION['username'] = $fnewName;

            echo 'success_adoptedNewName';
        }
    }
?> 