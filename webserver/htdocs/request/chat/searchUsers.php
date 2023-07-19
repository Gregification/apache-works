<?php
    include_once "/var/private_request/config.php";

    $term   = $_GET['searchTerm']   ?? "";//any string
    $ordby  = $_GET['orderBy']      ?? 'username';//assume is a column name
    $cmpari = $_GET['cmpari']       ?? 'username';//assume is a column name
    $dr     = $_GET['dr']           ?? 'asc';//assume is "acending" or "decending'
    $limit  = $_GET['batchsize']    ?? 10;//assume is a number or "all"(case insensitive)
    $offset = $_GET['pgnum']        ?? 0;//assume is a number
    $select = $_GET['select']       ?? '';//csv str of column names. default set during validation

    $userCols = $dbinfo['user columns'];

    //validation w/ defaults
    if(!is_numeric($offset))                                $offset = 0;
    if(!is_numeric($limit) && strcasecmp($limit, 'all'))    $limit  = '10';
    if(!strcasecmp($dr, 'asc') && !strcasecmp($dr, 'desc')) $dr     = 'asc';
    if(!in_array($ordby, $userCols, false))                 $ordby  = 'username';
    if(!in_array($cmpari, $userCols, false))                $cmpari = 'username';
    if(str_contains($select, ',')){
        $a = explode(',',$select); $select = '';
        foreach($a as $v) if(in_array($v, $userCols)) $select .= $v . ',';
        if(empty($select))  $select = 'username';
        else                $select = substr($select,0,-1);
      }
    else if(!in_array($select, $userCols, false))     $select = 'username';

    $srch   = $conn->prepare("select $select from ".$dbinfo['user table']." where $cmpari like :term order by $ordby $dr limit $limit offset $offset;");
    $srch->execute(['term' => ('%'.addcslashes($term, '%_').'%')]);
    // echo print_r("term: " . $term . "\r\nordby: " . $ordby . "\r\ncmpari: " . $cmpari . "\r\ndr: " . $dr . "\r\nlimit: " . $limit . "\r\noffset: " . $offset . "\r\n");
    echo json_encode($srch->fetchAll(PDO::FETCH_ASSOC));
?>