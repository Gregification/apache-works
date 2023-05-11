<?php
$data = array("a" => "Apple", "b" => "Ball", "c" => "Cat");

header("Content-Type: application/json");
echo json_encode($data);
//return phpinfo();

echo $_SERVER['PHP_SELF'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo "<br>";
echo $_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo $_SERVER['SCRIPT_NAME'];

exit();
?>