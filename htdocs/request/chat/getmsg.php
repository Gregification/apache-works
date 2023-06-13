<?php
    include_once "/var/private_request/config.php";

    $chatid     = $_GET['ctid']     ?? null;
    $chattitle  = $_GET['cttitle']  ?? null;
    $limit      = $_GET['count']    ?? 1;
    $offset     = $_GET['ofst']     ?? 0;
    $dr         = $_GET['dr']       ?? 'asc';

    if(!is_numeric($offset))            $offset = 0;
    if(!is_numeric($limit))             $limit  = 1;
    if(empty($chatid) ? empty($chattitle) : !is_numeric($chatid)) return;
    if(!in_array($dr, ['asc', 'desc'])) $dr     = 'asc';

    $chattablepath  = $getTablePath(intval($chatid) ?? $chattitle);
    if(empty($chattable))   return;

    $q  = $conn->prepare("select title from {$chattablepath} orderby timedelivered $dr limit $limit offset $offset;");
    echo json_encode($q->fetchAll(PDO::FETCH_ASSOC));
?>