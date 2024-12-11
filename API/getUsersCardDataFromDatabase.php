<?php
// Created: 2024/12/09 10:49:52
// Last modified: 2024/12/11 11:32:24
session_start();
include_once "dbheader.php";

$userID = $_SESSION["userID"];

$sql = 'SELECT dc.sCardFilePath 
  FROM app_user_component_order uco
  left join data_cards dc on dc.sCardId = uco.sComponentId
  WHERE sUserId = :userID
  ORDER BY iDisplayorder';

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    $response = $e->getMessage();
}
