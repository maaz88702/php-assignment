<?php
require_once("libus.php");

header("Content-Type: application/JSON" );

$data = json_decode(file_get_contents("php://input"), true);


$sql = "INSERT INTO contacts (fullName, email, contactNumber, status, address, city, country) VALUES (?, ?, ?, ?, ?, ?, ?)";
$params = ([$data['fullName'], $data['email'], $data['contactNumber'], $data['status'], $data['address'], $data['city'], $data['country']]);

iudQuery($sql, $params);

echo ("contact inserted successfully");
?>