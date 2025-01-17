<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/17 12:27:51
// if (session_status() !== PHP_SESSION_ACTIVE) {
//   session_start();
// }
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


// $data = [];
$sql = "SELECT * FROM app_events where dtStartDate > GETDATE()  ORDER BY dtStartDate ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     foreach ($row as $key => $value) {
//         $data[$key] = $value;
//     }
//     array_push($data, $row);
// }
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);;
