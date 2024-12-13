<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 12:42:39
session_start();
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

// $emp_id = '4438';
$emp_id = $_SESSION['employeeID'];

// $sql = "SELECT * from curr_emp_ref where deptNumber = (
//     SELECT deptNumber from curr_emp_ref where empNumber = '$emp_id'
// )";
$sql = "SELECT 
  au.id,
  au.sFirstName,
  au.sLastName,
  CONCAT(au.sFirstName,  ' ', au.sLastName) as sEmployeeName,
  au.sEmployeeNumber,
  au.sEmail,
  au.SMainPhoneNumber,
  au.sMainPhoneNumberLabel,
  au.sSecondaryPhoneNumber,
  au.sSecondaryPhoneNumberLabel,
  au.iDepartmentNumber,
  au.dtStartDate,
  au.dtSeparationDate,
  au.bISActive,
  aust.sStatusName,
  au.iStatus
FROM 
  bcg_intranet.dbo.app_users au
  INNER JOIN app_user_status_types aust ON au.iStatus = aust.id
WHERE 
  au.iDepartmentNumber = (
    SELECT iDepartmentNumber from bcg_intranet.dbo.app_users where sEmployeeNumber = '$emp_id'
  ) 
  AND au.dtSeparationDate is null
ORDER BY 
  au.sLastName ASC";


$data = array();

$stmt = $conn->prepare($sql);
$stmt->execute();

// if (!$stmt) {
//     echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
// }
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  foreach ($row as $key => $value) {
    $row[$key] = trim($value);
  }
  array_push($data, $row);
}

// while ($row = $result->fetch_assoc()) {
//     $data[] = $row;
// }

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
