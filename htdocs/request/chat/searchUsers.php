<?php
    session_start();
    include_once "/var/private_request/config.php";

    $term   = isset($_GET['searchTerm']) ?  $_GET['searchTerm'] : "";//any string
    $ordby  = isset($_GET['orderBy']) ?     strtolower($_GET['orderBy'])    : 'username';//assume is a column name
    $cmpari = isset($_GET['cmpari']) ?      strtolower($_GET['cmpari'])     : 'username';//assume is a column name
    $dr     = isset($_GET['dr']) ?          $_GET['dr']         : 'asc';//assume is "acending" or "decending'
    $limit  = isset($_GET['batchsize']) ?   $_GET['batchsize']  : 10;//assume is a number or "all"(case insensitive)
    $offset = isset($_GET['pgnum']) ?       $_GET['pgnum']      : 0;//assume is a number

    //validation w/ defaults
    if(!is_numeric($offset))    $offset = 0;
    if(!is_numeric($limit) && !strcasecmp($limit, 'all'))    $limit  = 'all';
    if(!strcasecmp($dr, 'asc') && !strcasecmp($dr, 'desc')) $dr     = 'asc';
    if(!in_array($ordby, $dbinfo['user columns'], false))    $ordby  = 'username';
    if(!in_array($cmpari, $dbinfo['user columns'], false))   $cmpari = 'username';

    $srch   = $conn->prepare("select username,creationtime,lastactivetime,description from ".$dbinfo['user table']." where $cmpari like :term order by $ordby $dr limit $limit offset $offset;");
    $srch->execute(['term' => ('%'.addcslashes($term, '%_').'%')]);
  //  echo print_r("term: " . $term . "\r\nordby: " . $ordby . "\r\ncmpari: " . $cmpari . "\r\ndr: " . $dr . "\r\nlimit: " . $limit . "\r\noffset: " . $offset . "\r\n");
    echo json_encode($srch->fetchAll(PDO::FETCH_ASSOC));
?>