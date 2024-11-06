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

include 'createGUID.php';

$GUID = generateGUID();

$sUserName = strip_tags($_POST['sUserName']);
$sFirstName = strip_tags($_POST['sFirstName']);
$sLastName = strip_tags($_POST['sLastName']);
$iDepartmentNumber = strip_tags($_POST['iDepartmentNumber']);
$sEmail = strip_tags($_POST['sEmail']);
$sHashedPass = strip_tags($_POST['sPassword']);
$sMainPhoneNumber = strip_tags($_POST['sMainPhoneNumber']);
$sMainPhoneNumberLabel = strip_tags($_POST['sMainPhoneNumberLabel']);
$bIsActive = 1;
$isLDAP = 1;

$sql = "INSERT INTO app_users (sUserName, sFirstName, sLastName, iDepartmentNumber, sEmail, sHashedPass, sMainPhoneNumber, sMainPhoneNumberLabel, bIsActive, bIsLDAP)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $sUserName);
    $stmt->bindParam(2, $sFirstName);
    $stmt->bindParam(3, $sLastName);
    $stmt->bindParam(4, $iDepartmentNumber);
    $stmt->bindParam(5, $sEmail);
    $stmt->bindParam(6, $sHashedPass);
    $stmt->bindParam(7, $sMainPhoneNumber);
    $stmt->bindParam(8, $sMainPhoneNumberLabel);
    $stmt->bindParam(9, $bIsActive);
    $stmt->bindParam(10, $isLDAP);
    $stmt->execute();
    if ($stmt) {
        echo json_encode(['success' => true, 'userID' => $GUID]);
    } else {
        echo json_encode(['success' => false]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
