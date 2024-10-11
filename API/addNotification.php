<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/11 14:32:50
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

// function convertToSqlDateTime($dateString, $timeString)
// {
//   $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $dateString + ' ' + $timeString);
//   return $dateTime->format('Y-m-d H:i:s');
// }

$userID = '4438'; // for now - it will be SESSION variable later


$GUID = generateGUID();
$sNotificationType = strip_tags($_POST['sNotificationType']);
$sNotificationText = strip_tags($_POST['sNotificationText']);


$dtStartDate = strip_tags($_POST['dtStartDate']);
$startTimeStamp = strtotime($dtStartDate);
$sqlStartDate = date('Y-m-d H:i:s', $startTimeStamp);


$dtEndDate = strip_tags($_POST['dtEndDate']);
$endTimeStamp = strtotime($dtEndDate);
$sqlEndDate = date('Y-m-d H:i:s', $endTimeStamp);

$sStatus = strip_tags($_POST['sStatus']);
$iCreatedBy = $userID;
$dtCreatedDate = time();

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
$stmt->bindParam(4, $sqlStartDate);
$stmt->bindParam(5, $sqlEndDate);
$stmt->bindParam(6, $sStatus);
$stmt->bindParam(7, $iCreatedBy);

$stmt->execute();
if ($stmt) {
  header("Location: ../success.php");
}
