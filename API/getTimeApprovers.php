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

$sFeatureAccessId = $_GET['sFeatureAccessId'];

$data = [];

$sql = "SELECT du.sUserId, CONCAT(au.sFirstName, ' ', au.sLastName) as empName
FROM data_features_access_users du
JOIN data_features_and_access da on da.id = du.sFeatureAccessId 
JOIN app_users au on au.id = du.sUserId
WHERE du.sFeatureAccessId = '$sFeatureAccessId'
ORDER by empName ASC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
header('Content-Type: application/json');
echo json_encode($data);
