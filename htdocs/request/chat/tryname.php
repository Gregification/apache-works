<?php
    /*
        given a form with input 'newName'. will see if its avaliable and if so change hte user over to it.
        - assumes a proper session has started
        - transacitons used during any kind of write, not during reads
    */

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
    $fnewName = $_POST['newName'];
    if($fnewName == $_SESSION['username']) return 'fail_sameAsUsername';

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!empty($fnewName)){
        $ev = $conn->prepare("select lastactivetime from ".$dbtables['user table']." where username=?;"); 
        $ev->execute([$fnewName]);
        $a = $ev->fetchColumn();
        if($a == null) { 
            //add new user
            try{
                $ev = $conn->prepare( "insert into ".$dbtables['user table']." (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1);" );
                $conn->beginTransaction();
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
            $ev->execute(['extract(epoch from now())', $_SESSION['username']]);//set former name offline
            $ev->execute([-1, $fnewName]);//set new name online

            $_SESSION['username'] = $fnewName;

            echo 'success_adoptedNewName';
        }
    }
?> 