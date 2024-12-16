<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/12/13 15:00:58
include "dbheader.php";

$data = [];
$sql = "SELECT sLocUid, sLocName, bIsBcws FROM data_locations where bIsFacilities = 1 order by sLocName ASC";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
