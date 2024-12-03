<?php
// Created: 2024/11/27 06:43:00
// Last modified: 2024/11/27 07:04:37

include "dbheader.php";

$data = [];
$sql = "SELECT sl.id
      ,sl.sLogId
      ,sl.dtLogTime
      ,sl.sEmployeeId
      ,sl.sUpdatedStatusId
      ,au.sUserName
      ,st.sStatusName 
  FROM app_user_status_log sl
  JOIN app_users au on au.sEmployeeNumber = sl.sEmployeeId
  JOIN app_user_status_types st on st.id = sl.sUpdatedStatusId
  ORDER BY dtLogTime DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
header('Content-Type: application/json');
echo json_encode($data);
