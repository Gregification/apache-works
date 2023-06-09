<?php
    /*
        given a form with input 'newName'. will see if its avaliable and if so change hte user over to it.
        - assumes a proper session has started
        - transacitons used during any kind of write, not during reads

        $_POST
            :   newName
        $_SESSION
            :   username    (optional)
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
    if(isset($_SESSION['username']) && strcmp($fnewName,$_SESSION['username']) == 0) {
        echo 'fail_sameAsCurrentName';
        return;
    }

    if(!empty($fnewName)){
        //update lastactivetime for the new and old name
        $update_laT = $conn->prepare("update ".$dbinfo['user table']." set lastactivetime = ? where username = ?;");
        $select_laT = $conn->prepare("select lastactivetime from ".$dbinfo['user table']." where username=?;"); 

        $select_laT->execute([$fnewName]);
        $laT = $select_laT->fetchColumn();
        if($laT == null) { //if new username dne
            //add new user
            try{
                $insert_newUsr = $conn->prepare( "insert into ".$dbinfo['user table']." (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1);" );                
                $conn->beginTransaction();
                $insert_newUsr->execute([$fnewName]);
                $conn->commit();

                echo 'success_newUser';
            }catch (PDOException $e) {
                $conn->rollBack();
                echo 'fail_insertion';
            }
        }else{ //name already exists
            if($laT == -1) { //if online
                echo 'fail_userOnline';
                return;
            }
            
            //set new name online
            $update_laT->execute([-1, $fnewName]);

            echo 'success_newName';
        }

        //set former name offline
        if(isset($_SESSION['username'])){
            $update_laT->execute([time(), $_SESSION['username']]);
        }

        $_SESSION['username'] = $fnewName;
        echo ' ' . $_SESSION['username'];
    }
?> 