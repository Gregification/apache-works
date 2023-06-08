<?php
    session_start();
    include_once "/var/private_request/config.php";

    $term   = isset($_POST['searchTerm']) ?  $_POST['searchTerm'] : "";//any string
    $ordby  = isset($_POST['orderBy']) ?     strtolower($_POST['orderBy'])    : 'username';//assume is a column name
    $cmpari = isset($_POST['cmpari']) ?      strtolower($_POST['cmpari'])     : 'username';//assume is a column name
    $dr     = isset($_POST['dr']) ?          $_POST['dr']         : 'asc';//assume is "acending" or "decending'
    $limit  = isset($_POST['batchsize']) ?   $_POST['batchsize']  : 10;//assume is a number or "all"(case insensitive)
    $offset = isset($_POST['pgnum']) ?       $_POST['pgnum']      : 0;//assume is a number

    //validation
    if(!is_numeric($limit) && !strcasecmp($limit, 'all'))   $limit  = 'all';
    if(!strcasecmp($dr, 'asc') && !strcasecmp($dr, 'desc')) $dr     = 'asc';
    if(!in_array($ordby, $dbinfo['user columns'], false))   $ordby  = 'username';
    if(!in_array($cmpari, $dbinfo['user columns'], false))  $cmpari = 'username';
    if(!is_numeric($offset))    $offset = 0;    else    if(is_numeric($limit)) $offset *= $limit;

    $srch   = $conn->prepare("select username,creationtime,lastactivetime,description from ".$dbinfo['user table']." where $cmpari like :term order by $ordby $dr limit $limit offset $offset;");
    $srch->execute(['term' => ('%'.addcslashes($term, '%_').'%')]);
    // echo print_r("term: " . $term . "\r\nordby: " . $ordby . "\r\ncmpari: " . $cmpari . "\r\ndr: " . $dr . "\r\nlimit: " . $limit . "\r\noffset: " . $offset . "\r\n");
    echo json_encode($srch->fetchAll(PDO::FETCH_ASSOC));
?>