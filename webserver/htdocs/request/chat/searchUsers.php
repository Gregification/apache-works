<?php
  /**
   * 
   * 
   * output sample
   * {"21321":[[]],"bleak frock":[[]]}
  **/
    include_once "/var/private_request/config.php";

    $def_batchsize  = 10;
    $def_column     = '*';
    $def_dr         = 'asc';
    $def_searchterm = '';

    $term   = $_GET['searchTerm']   ?? $def_searchterm; //any string
    $ordby  = $_GET['orderBy']      ?? $def_column;     //assume is a column name
    $cmpari = $_GET['cmpari']       ?? $def_column;     //assume is a column name
    $dr     = $_GET['dr']           ?? $def_dr;         //assume is "acending" or "decending'
    $limit  = $_GET['batchsize']    ?? $def_batchsize;  //assume is a number or "all"(case insensitive)
    $offset = $_GET['pgnum']        ?? 0;           //assume is a number
    $select = $_GET['select']       ?? '';          //csv str of column names. default set during validation

    $userCols = $dbinfo['user columns'];

    //validation w/ defaults
    if(!is_numeric($offset))                                $offset = 0;
    if(!is_numeric($limit) && strcasecmp($limit, 'all'))    $limit  = $def_batchsize;
    if(!strcasecmp($dr, 'asc') && !strcasecmp($dr, 'desc')) $dr     = $def_dr;
    if(!in_array($ordby, $userCols, false))                 $ordby  = $def_column;
    if(!in_array($cmpari, $userCols, false))                $cmpari = $def_column;
    if(str_contains($select, ',')){
        $selectionArr = explode(',',$select); 
        $select = '';
        
        foreach($selectionArr as $v) 
          if(in_array($v, $userCols)) $select .= $v . ',';
        
        if(empty($select))  $select = $def_column;
        else                $select = substr($select,0,-1);//trim off trailing comma
      }
    else if(!in_array($select, $userCols, false) && $select != "*")     $select = $def_column;

    $srch   = $conn->prepare("select $select from ".$dbinfo['user table']." where $cmpari like :term order by $ordby $dr limit $limit offset $offset;");
    $srch->execute(['term' => ('%'.addcslashes($term, '%_').'%')]);
    // echo print_r("term: " . $term . "\r\nordby: " . $ordby . "\r\ncmpari: " . $cmpari . "\r\ndr: " . $dr . "\r\nlimit: " . $limit . "\r\noffset: " . $offset . "\r\n");
    echo json_encode($srch->fetchAll(PDO::FETCH_ASSOC));
    /*
    PDO::FETCH_GROUP {"21321":[{"description":null,"1":null}],}
    PDO::FETCH_BOUND [true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true,true]
    PDO::FETCH_FUNC <-needs exactly 2 selected
    PDO::FETCH_SERIALIZE [{"username":"bleak frock","0":"bleak frock","description":null,"1":null,"creationtime":1686521703,"2":1686521703},
    PDO::FETCH_ASSOC [{"username":"bleak frock","description":null,"creationtime":1686521703}
    */
?>