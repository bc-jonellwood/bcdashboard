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

// $sql = "SELECT *
// FROM `emp_ref`
// WHERE seperation_date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
//                           AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
// ORDER BY seperation_date DESC";
$data = [];
$sql = "SELECT e.sFirstName, e.sLastName, e.sMainPhoneNumber, d.sDepartmentName, e.dtSeparationDate FROM data_employees e
JOIN data_departments d ON e.iDepartmentNumber = d.iDepartmentNumber
WHERE dtSeparationDate BETWEEN DATEADD(DAY, -7, CAST(GETDATE() AS DATE))
                           AND DATEADD(DAY, 7, CAST(GETDATE() AS DATE))
ORDER BY dtSeparationDate DESC";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
