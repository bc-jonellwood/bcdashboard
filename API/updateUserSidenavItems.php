<?php
// Created: 2025/01/07 09:45:30
// Last modified: 2025/01/08 15:41:44
include "dbheader.php";

$id = $_GET['userId'];

$itemString = $_GET['items'];
$items = explode(",", $itemString);

$sql = "DELETE FROM data_sidenav_users WHERE sUserId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();

$sql = " INSERT INTO data_sidenav_users (sUserId, sItemId) VALUES (:id, :sItemId)";
$stmt = $conn->prepare($sql);

foreach ($items as $sItemId) {
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':sItemId', $sItemId, PDO::PARAM_STR);
    $stmt->execute();
}
