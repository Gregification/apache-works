<?php
    include_once "/var/private_request/config.php";

    $chatid     = $_GET['ctid']     ?? null;
    $chattitle  = $_GET['cttitle']  ?? null;
    $limit      = $_GET['count']    ?? 1;
    $offset     = $_GET['ofst']     ?? 0;
    $dr         = $_GET['dr']       ?? 'desc';
    $aftertime  = $_GET['aftT']     ?? 0;

    if(!is_int($offset))        $offset = 0;
    if(!is_numeric($aftertime) && $aftertime >= 0)  $aftertime  = 0;
    if(!is_numeric($limit) && strcasecmp($limit, 'all'))    $limit = 1;
    if(empty($chatid) ? empty($chattitle) : !is_numeric($chatid))   return;
    if(!in_array($dr, ['asc', 'desc']))     $dr = 'asc';

    $chattablepath  = $getTablePath(intval($chatid) ?? $chattitle);
    if(empty($chattablepath))   return;
 
    $q  = $conn->query("select timedelivered as td,\"by\",message as msg from {$chattablepath} where timedelivered > $aftertime order by timedelivered $dr limit $limit offset $offset;");

    // echo "\r\naftT: $aftertime\r\n";
    echo json_encode($q->fetchAll(PDO::FETCH_ASSOC));
?>