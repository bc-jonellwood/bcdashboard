<?php
// Created: 2024/12/18 14:00:38
// Last modified: 2024/12/18 15:18:32
include_once "dbheader.php";

$data = json_decode(file_get_contents('php://input'), true);
$sVehUid = $data['sVehUid'];
echo $sVehUid;

$sql = "UPDATE data_mp_vehicles SET bIsAvailable = 1 WHERE sVehUid = :sVehUid";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':sVehUid', $sVehUid, PDO::PARAM_STR);
$stmt->execute();
