<?php
// Created: 2024/12/09 10:49:52
// Last modified: 2024/12/09 11:58:51

include_once "dbheader.php";

$sql = "SELECT sCardId, sCardName, sCardClass, iCardOrder FROM data_cards";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    $response = $e->getMessage();
}
