<?php
    /* 
        generates a new valid name for chat, then sets it to the current user.
            - itll go untill it dies trying.
        running on serverside because can it potentially make mutiple of successive db calls.

        note: https://www.youtube.com/watch?v=nb7e_7UJxAY
    */
    include_once "/var/private_request/config.php";

    function setNewUseableName(bool $allowPreexisting){
        global $conn, $dbinfo;

        $gName = '';

        try{
            $update_laT = $conn->prepare("update ".$dbinfo['user table']." set lastactivetime = ? where username = ?;");

            $conn->beginTransaction();
            if($allowPreexisting){ //searches prexisting names that are offline
                //snabs the name offline the longest
                $q_pastName = $conn->prepare("select username from ".$dbinfo['user table']." where lastactivetime > 0 order by lastactivetime asc limit 1;");
                $q_pastName->execute();
                $gName = $q_pastName->fetchColumn();

            }

            if(empty($gName)){
                /* determines the url source for random name generating
                note: preffered word source is hosted nonprofessionaly so is not expected to be consistently online 
                */
                $getAName =  (!empty(file_get_contents('https://random-word-form.herokuapp.com/random/adjective'))) ? 
                        function (){ global $dbinfo;
                            return substr(json_decode(file_get_contents('https://random-word-form.herokuapp.com/random/adjective'))[0] . ' ' . json_decode(file_get_contents('https://random-word-form.herokuapp.com/random/noun'))[0],0,$dbinfo['username charlimit']);
                        }
                    :   function(){ global $dbinfo;
                            $r = '';
                            foreach(json_decode(file_get_contents('https://random-word-api.herokuapp.com/word?number=' . rand(1,5))) as $w)
                                $r .= $w . ' ';
                            return substr($r,0, $dbinfo['username charlimit']);
                        }
                    ;
                $q_checkNameExists  =   $conn->prepare("select exists (select 1 from " . $dbinfo['user table'] . " where username=?);");
                $numTries = 10;
                do{
                    $gName = $getAName();
                    $q_checkNameExists->execute([$gName]);
                    $numTries--;
                }while($q_checkNameExists->fetchColumn() && $numTries >= 0);

                //if name still dne
                if($q_checkNameExists->fetchColumn()) {
                    //if this dosent solve it theres bigger problems...
                    $gName = hash('sha512', $gName);
                    do{
                        $gName += rand();
                        $gName = substr($gName,0,$dbinfo['username charlimit']);
                        $q_checkNameExists->execute([$gName]);
                    }while($q_checkNameExists->fetchColumn());
                }

                /*
                *   $gName will have a usable name after this point
                */

                //insert new online user
                $insert_newUsr = $conn->prepare( "insert into ".$dbinfo['user table']." (username,creationtime,lastactivetime) values (?, extract(epoch from now()), -1);" );
                $insert_newUsr->execute([$gName]);

            }else{ //a used name was selected. set it online
                $update_laT->execute([-1, $gName]);
            }
            
            //set former name, if avaliable, offline
            if(isset($_SESSION['username']))    $update_laT->execute(['extract(epoch from now())', $_SESSION['username']]);
            
            $_SESSION['username'] = $gName;

            $conn->commit();
        }catch(PDOException $e){ 
            $conn->rollBack();
        }

        return $gName;
    }
?>