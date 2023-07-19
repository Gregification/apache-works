<?php
// $data;
// $rf = ['REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR'];
// foreach($rf as $v) $data += md5($_SERVER[]);


header("Content-Type: application/json");
echo json_encode(uniqid());
exit();
?>