<?php
$data = array("a" => "Apple", "b" => "Ball", "c" => "Cat", "asdpaaeiocnpaec"=>"weeeeeeeeeeee");

header("Content-Type: application/json");
echo json_encode($data);
//return phpinfo();
exit();
?>