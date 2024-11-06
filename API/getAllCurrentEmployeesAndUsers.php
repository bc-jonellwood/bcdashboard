<?php
// Created: 2020/10/09 11:33:11
// Last modified: 2024/11/06 11:24:31

include_once "../data/appConfig.php";

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
    // echo "Connection failed: " . $e->getMessage();
}
$data = [];
$sql = "SELECT au.id as userId, au.sFirstName, de.sMiddleName, au.sLastName, de.sPreferredName, au.sEmployeeNumber, au.iDepartmentNumber,  dd.sDepartmentName, de.dtStartDate
from app_users au
JOIN data_employees de on de.iEmployeeNumber = au.sEmployeeNumber
JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
where de.dtSeparationDate is null 
order by de.dtStartDate DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
header('Content-Type: application/json');
echo json_encode($result);
