<?php
// Created: 2024/12/17 14:45:29
// Last modified: 2024/12/17 15:08:58
session_start();
include_once "dbheader.php";

$reservation = json_decode(file_get_contents('php://input'), true);
$sVehUid = $reservation['sVehUid'];
$dtStart = $reservation['dtStart'];
$dtEnd = $reservation['dtEnd'];
// $userId = $reservation['userId'];
$userId = $_SESSION['userID'];
// $notes = $reservation['notes'];
$notes = "Test notes";

$sql = "INSERT INTO data_mp_vehicle_bookings (sVehUid, sUserId, dtStart, dtEnd, sNotes) VALUES ('$sVehUid', '$userId', '$dtStart', '$dtEnd', '$notes')";
$stmt = $conn->prepare($sql);
$stmt->execute();
$insertId = $conn->lastInsertId();
if ($insertId) {
    $response = ['status' => 'success', 'message' => 'Reservation created successfully. Id # is ' . $insertId, 'reservationId' => $insertId];
} else {
    $response = ['status' => 'error', 'message' => 'Failed to create reservation'];
}

header('Content-Type: application/json');
echo json_encode($response);
