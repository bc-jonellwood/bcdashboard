<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 11:02:15
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
$sql = "SELECT au.sFirstName, au.sLastName, au.sMainPhoneNumber, dd.sDepartmentName, au.dtSeparationDate FROM app_users au
JOIN data_departments dd ON au.iDepartmentNumber = dd.iDepartmentNumber
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
