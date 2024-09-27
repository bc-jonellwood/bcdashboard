<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/27 15:55:02
// if (session_status() !== PHP_SESSION_ACTIVE) {
//   session_start();
// }
include_once "../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;


try {
  $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

include 'createGUID.php';

function convertToSqlDateTime($dateTimeString)
{
  $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $dateTimeString);
  return $dateTime->format('Y-m-d H:i:s');
}

$GUID = generateGUID();
$userID = '4438'; // for now - it will be SESSION variable later


$sNotificationType = strip_tags($_POST['sNotificationType']);

$sNotificationText = strip_tags($_POST['sNotificationText']);

$dtStartDate = strip_tags($_POST['dtStartDate']);
print_r($dtStartDate);
$dtStartTime = strip_tags($_POST['dtStartTime']);
print_r($dtStartTime);
// $dtStartDate = convertToSqlDateTime($dtStartDate + " " . $dtStartTime);
// print_r($dtStartDate);
$dtEndDate = strip_tags($_POST['dtEndDate']);
print_r($dtEndDate);
$dtEndTime = strip_tags($_POST['dtEndTime']);
print_r($dtEndTime);
// $dtEndDate = convertToSqlDateTime($dtEndDate + " " . $dtEndTime);
// print_r($dtEndDate);
$sStatus = strip_tags($_POST['sStatus']);

$iCreatedBy = $userID;
$dtCreatedDate = time();
print_r($dtCreatedDate);

$sql = "INSERT INTO app_notifications
    (
      id 
      ,sNotificationType
      ,sNotificationText
      ,dtStartDate
      ,dtEndDate
      ,sStatus
      ,iCreatedBy,
      dtCreatedDate
    )
    VALUES
    (?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $GUID);
$stmt->bindParam(2, $sNotificationType);
$stmt->bindParam(3, $sNotificationText);
$stmt->bindParam(4, $dtStartDate);
$stmt->bindParam(5, $dtEndDate);
$stmt->bindParam(6, $sStatus);
$stmt->bindParam(7, $iCreatedBy);
$stmt->bindParam(8, $dtCreatedDate);

// $stmt->execute();
// if ($stmt) {
//   header("Location: ../success.php");
// } 
