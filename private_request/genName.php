<?php
    /* 
        generates a new valid name for chat users.
    */
    include_once "/var/private_request/config.php";

    // $sql = 'SELECT * FROM _user';
    // $a = $conn->query($sql);
    // var_dump($a);
    // foreach ($a as $row) {
    //     print $row['username'] . ":\t";
    //     print $row['creationtime'] . "-->\t";
    //     print $row['lastactivetime'] . "\n";
    // }
    function genNewUseableName(bool $allowPreexisting){
        global $conn, $dbtables;

        $gName = '';

        if($allowPreexisting){ //searches prexisting names that are offline
            //snabs the name offline the longest.. select username from ? where lastactivetime > 0 order by lastactivetime asc limit 1;
            $q_pastName = $conn->prepare("select * from ?;");
            $q_pastName->execute([$dbtables['user table']]);
            $gName = $q_pastName->fetchColumn();
            // var_dump($q_pastName->fetchAll());
            if(!empty($gName)) return $gName;
        }

        /* determines the url source for random name generating
        note: preffered word source is hosted nonprofessionaly so is not expected to be consistently online 
        */
        $getAName =  (!empty(parse_url('https://random-word-form.herokuapp.com/random/adjective'))) ? 
                function (){
                    return substr(parse_url('https://random-word-form.herokuapp.com/random/adjective')[0] . ' ' . parse_url('https://random-word-form.herokuapp.com/random/animal')[0],0,255);
                }
            :   function(){
                    $r = '';
                    foreach(parse_url('https://random-word-api.herokuapp.com/word?number=' . rand(1,5)) as $w)
                        $r .= $w . ' ';
                    return substr($r,0,255);
                }
            ;
        $q_checkNameExists  =   $conn->prepare("select exists (select 1 from " . $dbtables['user table'] . " where username=?);");
        $numTries = 10;
        for($gName='default name'; $numTries > 0 && empty($q_checkNameExists->execute([$gName])); $numTries--){
            $gName = $getAName();
        }

        if($numTries != 0) return $gName;
        else do{
            $gName = $getAName() . rand();
        }while(empty($q_checkNameExists->execute([$gName])));

        return $gName;

    }
?>