<?php
// Created: 2025/01/07 09:45:30
// Last modified: 2025/01/07 09:59:38
include "dbheader.php";

$id = $_GET['userId'];

$cardString = $_GET['cards'];
$cards = explode(",", $cardString);

$sql = "DELETE FROM data_cards_users WHERE sUserId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();

$sql = " INSERT INTO data_cards_users (sUserId, sCardId) VALUES (:id, :sCardId)";
$stmt = $conn->prepare($sql);

foreach ($cards as $sCardId) {
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':sCardId', $sCardId, PDO::PARAM_STR);
    $stmt->execute();
}
