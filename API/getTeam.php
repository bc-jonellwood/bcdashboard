<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/19 13:20:58
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
$sql = "SELECT 
  de.id,
  de.sFirstName,
  de.sLastName,
  CONCAT(de.sFirstName,  ' ', de.sLastName) as sEmployeeName,
  de.iEmployeeNumber,
  de.sEmail,
  de.SMainPhoneNumber,
  de.sMainPhoneNumberLabel,
  de.sSecondaryPhoneNumber,
  de.sSecondaryPhoneNumberLabel,
  de.iDepartmentNumber,
  de.dtStartDate,
  de.dtSeparationDate,
  de.bActive,
  aust.sStatusName,
  au.iStatus
FROM 
  bcg_intranet.dbo.data_employees de
  INNER JOIN app_users au ON de.iEmployeeNumber = au.sEmployeeNumber
  INNER JOIN app_user_status_types aust ON au.iStatus = aust.id
WHERE 
  de.iDepartmentNumber = (
    SELECT iDepartmentNumber from bcg_intranet.dbo.data_employees where iEmployeeNumber = '$emp_id'
  ) 
  AND de.dtSeparationDate is null
ORDER BY 
  de.sLastName ASC";


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
