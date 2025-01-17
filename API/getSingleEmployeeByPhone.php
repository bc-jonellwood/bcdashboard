<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/17 12:27:51
include_once "../data/appConfig.php";;

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

$phoneNumber = $_GET['phoneNumber'];
// print_r($phoneNumber);
$data = [];

$sql =
    "SELECT au.sFirstName, au.sLastName, au.sMainPhoneNumber, au.iDepartmentNumber, dd.sDepartmentName 
        FROM app_users au
        JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
        WHERE au.sMainPhoneNumber LIKE '%" . $phoneNumber . "%' AND au.dtSeparationDate is null";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
