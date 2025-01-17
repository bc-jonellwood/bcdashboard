<?php

// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/17 11:59:21

include_once(dirname(__FILE__) . '../data/appConfig.php');
// include_once(dirname(__FILE__) . '/classes/User.php');

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

$userData = json_decode(file_get_contents("php://input"), true);

$sUserName = strip_tags($userData['sUserName']);
$sFirstName = strip_tags($userData['sFirstName']);
$sLastName = strip_tags($userData['sLastName']);
$sEmail = strip_tags($userData['sEmail']);
$password = strip_tags($userData['sPassword']);
$sHashedPass = password_hash($password, PASSWORD_DEFAULT);
$bIsActive = 1;
$isLDAP = 0;

$sql = "INSERT INTO app_users (sUserName, sFirstName, sLastName, iDepartmentNumber, sEmail, sHashedPass, bIsActive, bIsLDAP)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $sUserName);
    $stmt->bindParam(2, $sFirstName);
    $stmt->bindParam(3, $sLastName);
    $stmt->bindParam(4, $iDepartmentNumber);
    $stmt->bindParam(5, $sEmail);
    $stmt->bindParam(6, $sHashedPass);
    $stmt->bindParam(7, $bIsActive);
    $stmt->bindParam(8, $isLDAP);
    $stmt->execute();
    if ($stmt) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
