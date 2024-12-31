<?php
// Created: 2024/12/30 10:58:56
// Last modified: 2024/12/31 08:24:47
include_once "dbheader.php";

$data = json_decode(file_get_contents('php://input'), true);
// $sUserID = $data['userID'];
$sUserID = 'e4bcdd46-0dda-459d-a835-2c8b88b3421e';

$sql = "SELECT dtFleetTestAttempt FROM data_mp_vehicle_drivers WHERE sUserId = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $sUserID, PDO::PARAM_INT);
$itWorked = $stmt->execute();
// get date value of dtFleetTestAttempt and compare to current date
// if current date is greater than dtFleetTestAttempt then return true else return false
if ($itWorked) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $dtFleetTestAttempt = $row['dtFleetTestAttempt'];
    // echo $dtFleetTestAttempt;
    $currentDate = date('Y-m-d');
    // echo $currentDate;
    if ($dtFleetTestAttempt <= $currentDate) {
        echo json_encode(['eligible' => true]);
        exit;
    } else {
        echo json_encode(['eligible' => false]);
        exit;
    }
}
