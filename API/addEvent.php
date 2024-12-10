<?php

// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/09 15:42:11

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

$userID = $_SESSION["userID"]; // eventually 
// $userID = '4438';

$GUID = generateGUID();

$sEventName = strip_tags($_POST['sEventName']);
$sEventDescription = strip_tags($_POST['sEventDescription']);

$dtStartDate = strip_tags($_POST['dtStartDate']);
$startTimeStamp = strtotime($dtStartDate);
$sqlStartDate = date('Y-m-d H:i:s', $startTimeStamp);


$dtEndDate = strip_tags($_POST['dtEndDate']);
$endTimeStamp = strtotime($dtEndDate);
$sqlEndDate = date('Y-m-d H:i:s', $endTimeStamp);

$sEventLocation = strip_tags($_POST['sEventLocation']);
$sStatus = strip_tags($_POST['sStatus']);
$iCreatedBy = $userID;
// $dtCreatedDate = time();

$sql = "INSERT INTO app_events
    (event_id, sTitle, sDescription, sLocation, dtStartDate, dtEndDate, sStatus, iCreatedBy)
    VALUES
    (?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);

$stmt->bindParam(1, $GUID);
$stmt->bindParam(2, $sEventName);
$stmt->bindParam(3, $sEventDescription);
$stmt->bindParam(4, $sEventLocation);
$stmt->bindParam(5, $sqlStartDate);
$stmt->bindParam(6, $sqlEndDate);
$stmt->bindParam(7, $sStatus);
$stmt->bindParam(8, $iCreatedBy);
// $stmt->bindParam(9, $dtCreatedDate);

$stmt->execute();
if ($stmt) {
    echo json_encode(['success' => true, 'eventID' => $GUID]);
} else {
    echo json_encode(['success' => false]);
}
