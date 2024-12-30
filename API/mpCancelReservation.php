<?php
// Created: 2024/12/30 14:05:33
// Last modified: 2024/12/30 14:16:14

include "dbheader.php";
// $reservationId = json_decode(file_get_contents('php://input'), true);
$reservationId = $_GET['id'];
$sql = "UPDATE data_mp_vehicle_bookings SET bIsCancelled = 1 WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
