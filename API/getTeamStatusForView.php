<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/22 10:33:32
require_once '../data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
  $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$emp_id = '4438';

// $sql = "SELECT * from curr_emp_ref where deptNumber = (
//     SELECT deptNumber from curr_emp_ref where empNumber = '$emp_id'
// )";
$sql = "WITH LatestStatus AS (
  SELECT sEmployeeId, MAX(dtLogTime) AS LatestLogTime
  FROM 
    app_user_status_log
  GROUP BY 
    sEmployeeId
)
SELECT 
  au.sFirstName,
  au.sPreferredName,
  au.sLastName,
  au.sEmployeeNumber,
  au.iStatus,
  aust.sStatusName,
  lst.LatestLogTime
FROM 
  bcg_intranet.dbo.app_users au
  INNER JOIN app_user_status_types aust 
    ON au.iStatus = aust.id
  LEFT JOIN LatestStatus lst 
    ON au.sEmployeeNumber = lst.sEmployeeId
WHERE 
  au.bIsActive = 1
  AND (au.iDepartmentNumber = '41515' OR au.iDepartmentNumber = '41514') 
ORDER BY 
  au.sFirstName ASC;";

$data = array();

$stmt = $conn->prepare($sql);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  foreach ($row as $key => $value) {
    $row[$key] = trim($value);
  }
  array_push($data, $row);
}

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
