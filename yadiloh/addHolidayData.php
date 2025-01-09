<?php
// Created: 2025/01/09 11:46:18
// Last modified: 2025/01/09 11:53:28

include(dirname(__FILE__) . '/../API/dbheader.php');

$sName = $_POST['sName'];
$dtDate = $_POST['dtDate'];
$iGroupId = $_POST['iGroupId'];

$sql = "INSERT INTO data_holidays (sName, dtDate, iGroupId) VALUES (:sName, :dtDate, :iGroupId);";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sName', $sName);
    $stmt->bindParam(':dtDate', $dtDate);
    $stmt->bindParam(':iGroupId', $iGroupId);

    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => '200']);
    } else {
        echo json_encode(['status' => '400']);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
