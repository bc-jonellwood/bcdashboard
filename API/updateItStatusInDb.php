<?php
// Created: 2024/11/21 12:45:42
// Last modified: 2025/01/06 14:53:08
include "dbheader.php";


$e_id = $_GET['employee'];
$s_id = $_GET['status'];

$sql = "UPDATE app_users SET iStatus = '$s_id' WHERE sEmployeeNumber = '$e_id'";
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $log_sql = "INSERT INTO app_user_status_log (sEmployeeId, sUpdatedStatusId) VALUES ('$e_id', '$s_id')";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
