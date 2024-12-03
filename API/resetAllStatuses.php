<?php
// Created: 2024/11/21 12:45:42
// Last modified: 2024/11/25 15:33:43
include "dbheader.php";

$sql = "UPDATE app_users set iStatus = 0
  WHERE bIsActive = 1
  AND (iDepartmentNumber = '41515' OR iDepartmentNumber = '41514');";

// We use '0000' for employee ID to indicate that the status was reset by the system
try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $log_sql = "INSERT INTO app_user_status_log (sEmployeeId, sUpdatedStatusId) VALUES ('0000', '0')";
    $log_stmt = $conn->prepare($log_sql);
    $log_stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
