<?php

// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/24 10:24:24

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
$internal = [];
$external = [];
$sql = "SELECT id, sNameAndAccess, bIsExternal from data_features_and_access";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        if ($row['bIsExternal'] == 1) {
            array_push($external, $row);
        } else {
            array_push($internal, $row);
        }
    }
    array_push($data, ['internal' => $internal]);
    array_push($data, ['external' => $external]);
    // array_push($data, $external);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
};
header('Content-Type: application/json');
echo json_encode($data);
