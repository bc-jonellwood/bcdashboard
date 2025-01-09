<?php
// Created: 2024/12/23 12:26:24
// Last modified: 2025/01/09 11:41:59

include(dirname(__FILE__) . '/../API/dbheader.php');

$sName = $_POST['sName'];
$dtDate = $_POST['dtDate'];
$iGroupId = $_POST['iGroupId'];
$id = $_POST['id'];

$sql = "UPDATE data_holidays
  SET sName = :sName, dtDate = :dtDate, iGroupID = :iGroupId
  WHERE id = :id;";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sName', $sName);
    $stmt->bindParam(':dtDate', $dtDate);
    $stmt->bindParam(':iGroupId', $iGroupId);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => '200']);
    } else {
        echo json_encode(['status' => '400']);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
