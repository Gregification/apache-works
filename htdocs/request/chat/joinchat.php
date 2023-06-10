<?php
    session_start();
    include_once "/var/private_request/config.php";

    $title   = $_POST['title'] ?? 'default chat';

    //validation
    if(empty($title))   return;

    $table_chatmeta = $dbinfo['chat table'];
    $id             = 1;
    $tabledbpth     = 'schema.tablename';

    $q  = $conn->prepare("select id from ".$table_chatmeta." where title = ?;");
    $q->execute([$title]);
    $id = $q->fetchColumn();

    if(empty($id)){//if table not exist in meta
        $t = time();

        //create meta
        $q = $conn->prepare("insert into ".$table_chatmeta." (title,usersonline,creationtime,lastactivetime) values (:title,0,:ct,:lat) returning id;");
        $q->execute(['title' => $title, 'ct' => $t, 'lat' => $t]);

        $id = $q->fetchColumn();
    }
    /* else{
        $q = $conn->prepare("select exists (select from pg_tables where schemaname=? and tablename=?;");
        $q->execute([$dbinfo['chat schema'],$dbinfo['chat id prefix'] . $id]);
        if($q->fetchColumn()){//if table dne by meta exists

        }
    } */

    //create table from template
    
    //create table if not exists
    $tabledbpth = $dbinfo['chat schema'].'.'.$dbinfo['chat id prefix'].$id;
    $q = $conn->prepare("create table if not exists " .$tabledbpth. " as table " .$dbinfo['chat template']. ";");
    $q->execute();

    //decrement old chat user count
    $q = $conn->prepare("update ".$dbinfo['chat table']." set usersonline=usersonline+? where id=?;");
    if(isset($_SESSION['chatid'])){
        $q->execute([-1,$_SESSION['chatid']]);
    }

    //increment new chat user count
    $q->execute([1, $id]);

    $_SESSION['chatid']     = $id;
    $_SESSION['chatdbpath'] = $tabledbpth;
    $_SESSION['chatname']   = $title;

    echo "joined chat:\r\t".$tabledbpth."\r\ntitle:\r\t".$title;
?>