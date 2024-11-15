<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/11/15 08:43:12
include "dbheader.php";

$data = [];
$sql = "SELECT * FROM data_link where sClass = '" . $_GET['type'] . "' order by sText ASC";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
