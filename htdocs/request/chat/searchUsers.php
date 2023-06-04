<?php
    session_start();
    include_once "/var/private_request/config.php";

    $term   = $_POST['searchTerm'];//any string
    $ordby  = $_POST['orderBy'];//assume is a column name
    $dr     = $_POST['dr'];//assume is "acending" or "decending'
    $limit  = $_POST['batchsize'];//assume is a number or "all"(case insensitive)
    $offset = $_POST['pgnum'];//assume is number

    if(strcasecmp($limit,'all'))    0;
    else                            $_POST['pgnum'] * $limit;
    if(empty($term))                $term = '*';

    //params inserted during exe. to prevent sql injection
    $srch   = $conn->prepare("select (username,creationtime,lastactivetime) 
        where username like :term 
        order by :ordby 
        limit :limit 
        offset :offset");
    $srch->execute(['term' => $term, 'ordby' => $ordby, 'limit' => $limit, 'offset' => $offset]);
    return var_dump($srch->fetchall());
?>