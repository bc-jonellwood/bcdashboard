<?php
// Created: 2024/09/12 13:12:49
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

$phoneNumber = $_GET['phoneNumber'];
// print_r($phoneNumber);
$data = [];

$sql =
    "SELECT de.sFirstName, de.sLastName, de.sMainPhoneNumber, de.iDepartmentNumber, dd.sDepartmentName 
        FROM data_employees de
        JOIN data_departments dd on dd.iDepartmentNumber = de.iDepartmentNumber
        WHERE de.sMainPhoneNumber LIKE '%" . $phoneNumber . "%' AND de.dtSeparationDate is null";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($data);
