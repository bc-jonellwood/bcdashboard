<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/26 14:29:19
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
$dtStartDate = convertToSqlDateTime($dtStartDate);
$dtEndDate = strip_tags($_POST['dtEndDate']);
$dtEndDate = convertToSqlDateTime($dtEndDate);
$sStatus = strip_tags($_POST['sStatus']);

$iCreatedBy = $userID;

$sql = "INSERT INTO app_notifications
    (
      id 
      ,sNotificationType
      ,sNotificationText
      ,dtStartDate
      ,dtEndDate
      ,sStatus
      ,iCreatedBy
    )
    VALUES
    (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $GUID);
$stmt->bindParam(2, $sNotificationType);
$stmt->bindParam(3, $sNotificationText);
$stmt->bindParam(4, $dtStartDate);
$stmt->bindParam(5, $dtEndDate);
$stmt->bindParam(6, $sStatus);
$stmt->bindParam(7, $iCreatedBy);

$stmt->execute();
if ($stmt) {
  header("Location: ../success.php");
} else {
  // echo "Fail";
}
