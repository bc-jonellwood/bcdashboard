<?php

// query the database for notifications where the current date and time is between the start and end dates of the notification. Return the results as an array.


// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/26 15:00:49

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

$data = [];
$sql = "SELECT * FROM app_notifications WHERE dtStartDate <= CURRENT_TIMESTAMP AND dtEndDate >= CURRENT_TIMESTAMP AND sStatus = 'active'";

$stmt = $conn->prepare($sql);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
