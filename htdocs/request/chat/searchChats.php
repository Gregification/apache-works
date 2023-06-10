<?php
    include_once "/var/private_request/config.php";

    $term   = $_GET['searchTerm']   ?? "";//any string
    $ordby  = $_GET['orderBy']      ?? 'title';//assume is a column name
    $cmpari = $_GET['cmpari']       ?? 'title';//assume is a column name
    $dr     = $_GET['dr']           ?? 'asc';//assume is "asc" or "desc'
    $limit  = $_GET['limit']        ?? 10;//assume is a number or "all"(case insensitive)
    $offset = $_GET['offset']       ?? 0;//assume is a number
    $iscount= $_GET['iscount']      ?? 0;// t/f
    $select = $_GET['select']       ?? 'title';//csv of column names ex: "title,usersonline,description"

    //format
    $ordby  = strtolower($ordby);
    $cmpari = strtolower($cmpari);
    $dr     = strtolower($dr);
    $term   = '%' . addcslashes($term, '%_'). '%';

    $chatCols = $dbinfo['chat meta columns'];

    //validation w/ defaults
    if(!is_numeric($offset))    $offset = 0;
    if(!is_numeric($limit) && !strcasecmp($limit, 'all'))   $limit  = '10';
    if(!in_array($dr, ['asc','desc']))                      $dr     = 'asc';
    if(!in_array($ordby, $chatCols, false))   $ordby  = 'title';
    if(!in_array($cmpari, $chatCols, false))  $cmpari = 'title';
    if(str_contains($select, ',')){
            $a = explode(',',$select); $select = '';
            foreach($a as $v) if(in_array($v, $chatCols)) $select .= $v . ',';
            if(empty($select))  $select = 'title';
            else                $select = substr($select,0,-1);
        }
    else if(!in_array($select, $chatCols, false))     $select = 'title';

    if($iscount){//counting or getting?
        $srch   = $conn->prepare("select count(*) from ".$dbinfo['chat table']." where $cmpari like :term;");
        $srch->execute(['term' => $term]);
        echo $srch->fetchColumn();
    }else{
        $srch   = $conn->prepare("select $select from ".$dbinfo['chat table']." where $cmpari like :term order by $ordby $dr limit $limit offset $offset;");
        $srch->execute(['term' => $term]);
        // echo print_r("term: " . $term . "\r\nordby: " . $ordby . "\r\ncmpari: " . $cmpari . "\r\ndr: " . $dr . "\r\nlimit: " . $limit . "\r\noffset: " . $offset . "\r\niscount: " . $iscount . "\r\nselect: " . $select . "\r\n");
        echo json_encode($srch->fetchAll(PDO::FETCH_ASSOC));
    }
?>