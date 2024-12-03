<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/11/25 09:54:57
include "dbheader.php";

$data = [];
$sql = "SELECT * FROM data_facilities_request_types where id = 101 order by sType ASC";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
