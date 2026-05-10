<?php
require_once("libus.php");

header("Content-Type: application/JSON" );

$data = json_decode(file_get_contents("php://input"), true);


$sql = "UPDATE contacts SET fullName = ?, email = ?, contactNumber = ?, status = ?, address = ?, city = ?, country = ? WHERE contactId = (?)";
$params = [$data['fullName'], $data['email'], $data['contactNumber'], $data['status'], $data['address'], $data['city'], $data['country'], $data['contactId']];

iudQuery($sql, $params);

echo ("updated successfully");
?>