<?php
// Created: 2024/12/19 11:05:50
// Last modified: 2024/12/30 10:57:00
include_once "dbheader.php";


//$sUserID = isset($_POST['userID']) ? $_POST['userID'] : null;
$data = json_decode(file_get_contents('php://input'), true);
$sUserID = $data['userID'];

if ($sUserID === null) {
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

$sql = "UPDATE data_mp_vehicle_drivers SET dtFleetTestAttempt = GETDATE(), iFleetTestAttemptCount = iFleetTestAttemptCount + 1 WHERE sUserId = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $sUserID, PDO::PARAM_INT);
$itWorked = $stmt->execute();

if ($itWorked) {
    // return http staus code 200
    echo json_encode(
        [
            'status' => 200,
            'success' => 'Fleet test score submitted successfully'
        ]
    );
} else {
    echo json_encode(
        [
            'status' => 500,
            'error' => 'Failed to submit fleet test score'
        ]
    );
}
