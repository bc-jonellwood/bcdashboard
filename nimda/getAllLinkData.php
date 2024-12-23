<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/12/23 10:57:29

include(dirname(__FILE__) . '/../API/dbheader.php');

$data = [];
$sql = "SELECT id, sLinkId, sHref, sIcon, sText, sClass ,bIsActive
  FROM data_link
  ORDER By id ASC;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
