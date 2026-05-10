<?php
require_once("libus.php");

header("Content-Type: application/JSON" );

$data = json_decode(file_get_contents("php://input"), true);


$sql = "DELETE FROM contacts WHERE contactId = ?";
$params = [$data['id']];

$msg = iudQuery($sql, $params);

echo json_encode($msg);

?>