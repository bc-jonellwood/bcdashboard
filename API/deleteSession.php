<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/02 14:11:20

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
// I know this is the not the best way to do this, but it works for now. We will beed to come back to this later and bind_param values.
$id = "'" . $_REQUEST['id'] . "'";

$sql = "DELETE app_events_timeSlots WHERE slot_id = $id";

$stmt = $conn->prepare($sql);
echo $sql;
$stmt->execute();
