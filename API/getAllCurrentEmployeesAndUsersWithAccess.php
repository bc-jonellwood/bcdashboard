<?php
// Created: 2020/10/09 11:33:11
// Last modified: 2025/01/17 11:59:21

include_once(dirname(__FILE__) . '../data/appConfig.php');

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
$sql = "SELECT DISTINCT au.id as userId, au.sFirstName, au.sMiddleName, au.sLastName, au.sPreferredName, au.sEmployeeNumber, au.iDepartmentNumber, dd.sDepartmentName, au.dtStartDate
from app_users au
JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
JOIN data_features_access_users du on du.sUserId = au.id 
where au.dtSeparationDate is null 
order by au.dtStartDate DESC";

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
