<?php
// Created: 2024/12/23 12:26:24
// Last modified: 2024/12/23 13:26:40

include(dirname(__FILE__) . '/../API/dbheader.php');

$sText = $_POST['sText'];
$sHref = $_POST['sHref'];
$sIcon = $_POST['sIcon'];
$sClass = $_POST['sClass'];
$bIsActive = $_POST['bIsActive'];
$sLinkId = $_POST['sLinkId'];

$sql = "INSERT INTO data_link (sLinkId, sText, sHref, sIcon, sClass, bIsActive) VALUES (:sLinkId,:sText, :sHref, :sIcon, :sClass, :bIsActive);";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':sLinkId', $sLinkId);
    $stmt->bindParam(':sText', $sText);
    $stmt->bindParam(':sHref', $sHref);
    $stmt->bindParam(':sIcon', $sIcon);
    $stmt->bindParam(':sClass', $sClass);
    $stmt->bindParam(':bIsActive', $bIsActive);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => '200']);
    } else {
        echo json_encode(['status' => '400']);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
