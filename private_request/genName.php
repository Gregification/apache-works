<?php
    /* 
        generates a new valid name for chat users.
    */
    include_once "/var/private_request/config.php";

    function genNewUseableName(bool $allowPreexisting){
        global $conn, $dbtables;

        $gName = '';

        if($allowPreexisting){ //searches prexisting names that are offline
            //snabs the name offline the longest
            $q_pastName = $conn->prepare("select username from ".$dbtables['user table']." where lastactivetime > 0 order by lastactivetime asc limit 1;");
            $q_pastName->execute();
            $gName = $q_pastName->fetchColumn();
            if(!empty($gName)) return $gName;
        }

        /* determines the url source for random name generating
        note: preffered word source is hosted nonprofessionaly so is not expected to be consistently online 
        */
        $getAName =  (!empty(file_get_contents('https://random-word-form.herokuapp.com/random/adjective'))) ? 
                function (){
                    return substr(json_decode(file_get_contents('https://random-word-form.herokuapp.com/random/adjective'))[0] . ' ' . json_decode(file_get_contents('https://random-word-form.herokuapp.com/random/noun'))[0],0,255);
                }
            :   function(){
                    $r = '';
                    foreach(json_decode(file_get_contents('https://random-word-api.herokuapp.com/word?number=' . rand(1,5))) as $w)
                        $r .= $w . ' ';
                    return substr($r,0,255);
                }
            ;
        $q_checkNameExists  =   $conn->prepare("select exists (select 1 from " . $dbtables['user table'] . " where username=?);");
        $numTries = 10;
        do{
            $gName = $getAName();
            $q_checkNameExists->execute([$gName]);
        }while($q_checkNameExists->fetchColumn() && $numTries > 0);

        if(!$q_checkNameExists->fetchColumn()) return $gName;
        else {
            //if this dosent catch it thers bigger problems..
            $gName = hash('sha512', $gName);
            do{
                $gName += rand();
                $q_checkNameExists->execute([$gName]);
            }while($q_checkNameExists->fetchColumn());
        }

        return $gName;

    }
?>