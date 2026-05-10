<?php
require_once("libus.php");

header("Content-Type: application/JSON" );

$data = json_decode(file_get_contents("php://input"), true);


$sql = "SELECT * FROM contacts";
$params = [];

$rows = selectQuery($sql, $params);

echo json_encode($rows);

?>