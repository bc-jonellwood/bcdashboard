<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/06 11:24:31
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
$sql = "SELECT id,
      sFirstName
      ,sLastName,
      CONCAT(sFirstName,  ' ', sLastName) as sEmployeeName
      ,iEmployeeNumber
      ,sEmail
      ,SMainPhoneNumber
      ,sMainPhoneNumberLabel
      ,sSecondaryPhoneNumber
      ,sSecondaryPhoneNumberLabel
      ,iDepartmentNumber
      ,dtStartDate
      ,dtSeparationDate
      ,bActive
  FROM bcg_intranet.dbo.data_employees
  where iDepartmentNumber = (
    SELECT iDepartmentNumber from bcg_intranet.dbo.data_employees where iEmployeeNumber = '$emp_id'
  ) and dtSeparationDate is null order by sLastName ASC;";


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
