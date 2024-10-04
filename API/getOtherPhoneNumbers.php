<?php
// Created: 2024/10/04 11:58:20
// Last modified: 2024/10/04 13:14:12

include_once "../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;


try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT * FROM data_phone_numbers ORDER by sPhoneOrg ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
