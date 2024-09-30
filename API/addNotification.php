<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/09/30 11:05:48
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

function convertToSqlDate($dateString)
{
  $dateTime = DateTime::createFromFormat('Y-m-d', $dateString);
  return $dateTime->format('Y-m-d');
}
function converToSqlTime($timeString)
{
  $timestamp = strtotime($timeString);
  $time = date('H:i:s', $timestamp);
  return $time;
}

$userID = '4438'; // for now - it will be SESSION variable later


$GUID = generateGUID();
$sNotificationType = strip_tags($_POST['sNotificationType']);
$sNotificationText = strip_tags($_POST['sNotificationText']);
$dtStartDate = strip_tags($_POST['dtStartDate']);
$dtStartDate = convertToSqlDate($dtStartDate);
echo "</br>";
print_r($dtStartDate);
$dtStartTime = strip_tags($_POST['dtStartTime']);
$dtStartTime = converToSqlTime($dtStartTime);
echo "</br>";
print_r($dtStartTime);
echo "</br>";
$startDateTime = $dtStartDate . " " . $dtStartTime;
print_r($startDateTime);
echo "</br>";
$dtEndDate = strip_tags($_POST['dtEndDate']);
$dtEndDate = convertToSqlDate($dtEndDate);
echo "</br>";
print_r($dtEndDate);
$dtEndTime = strip_tags($_POST['dtEndTime']);
$dtEndTime = converToSqlTime($dtEndTime);
echo "</br>";
print_r($dtEndTime);
echo "</br>";
$endDateTime = $dtEndDate . " " . $dtEndTime;
print_r($endDateTime);
echo "</br>";
$sStatus = strip_tags($_POST['sStatus']);
$iCreatedBy = $userID;
$dtCreatedDate = time();

$sql = "INSERT INTO app_notifications
    (
      id 
      ,sNotificationType 
      ,sNotificationText 
      ,dtStartDate 
      ,dtStartTime 
      ,dtEndDate 
      ,dtEndTime
      ,sStatus
      ,iCreatedBy
      ,dtCreatedDate
    )
    VALUES
    (?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $GUID);
$stmt->bindParam(2, $sNotificationType);
$stmt->bindParam(3, $sNotificationText);
$stmt->bindParam(4, $dtStartDateTime);
$stmt->bindParam(5, $dtStartTime);
$stmt->bindParam(6, $dtEndDateTime);
$stmt->bindParam(7, $dtEndTime);
$stmt->bindParam(8, $sStatus);
$stmt->bindParam(9, $iCreatedBy);
$stmt->bindParam(10, $dtCreatedDate);

$stmt->execute();
if ($stmt) {
  header("Location: ../success.php");
}
