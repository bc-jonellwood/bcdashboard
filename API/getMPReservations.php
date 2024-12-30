<?php
// Created: 2024/12/30 10:58:56
// Last modified: 2024/12/30 11:32:10
session_start();
include_once "dbheader.php";

// $data = json_decode(file_get_contents('php://input'), true);
// $sUserID = $_SESSION['userID'];

$sUserID = 'e1ae1ea7-3fa8-4d55-90fd-00a60ed1f9d8';
$sql = "SELECT id, sBookUid, sUserId, dtStart, dtEnd, sVehUid, sNotes FROM data_mp_vehicle_bookings WHERE sUserId = :id and dtStart >= GETDATE() ORDER BY dtStart ASC";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $sUserID, PDO::PARAM_INT);
$itWorked = $stmt->execute();

if ($itWorked) {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($result);
}
