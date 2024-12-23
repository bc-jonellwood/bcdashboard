<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/12/23 09:09:22
include "dbheader.php";

$data = [];
$sql = "SELECT id, sLinkId, sHref, sIcon, sText, sClass ,bIsActive
  FROM data_link
  where bIsActive = 1
  ORDER By sText ASC;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
