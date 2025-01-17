<?php
// Created: 2020/10/09 11:33:11
// Last modified: 2025/01/17 12:27:51

include_once "../data/appConfig.php";
// include_once "../data/appConfig.php";;
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
$sql = "SELECT sFirstName, sLastName, sEmployeeNumber from app_users where dtSeparationDate is null order by dtStartDate DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// $conn = null;
header('Content-Type: application/json');
echo json_encode($result);
