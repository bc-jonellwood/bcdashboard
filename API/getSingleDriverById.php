<?php
// Created: 2024/12/19 10:35:12
// Last modified: 2024/12/19 12:32:15

include_once "dbheader.php";
// $sUserID = isset($_POST['id']) ? $_POST['id'] : null;
$sUserID = json_decode(file_get_contents('php://input'), true);

if ($sUserID === null) {
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

$sql = "SELECT mpd.id
      ,mpd.sBcgiId
      ,mpd.sEmployeeNumber
      ,mpd.sUserId
      ,mpd.dtDlExpires
      ,mpd.dtFleetTestPassed
      ,mpd.dtFuelCardTestPassed
      ,mpd.dtAcknowledge
      ,mpd.dlFront
      ,mpd.dlBack
      ,mpd.sNotes
      ,au.sFirstName
      ,au.sLastName
  FROM data_mp_vehicle_drivers mpd 
  JOIN app_users au on au.id = mpd.sUserId
  WHERE mpd.sUserId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $sUserID, PDO::PARAM_INT);
$stmt->execute();
$driver = $stmt->fetch(PDO::FETCH_ASSOC);

$response = [];
if ($driver) {
    $response['id'] = $driver['id'];
    $response['sBcgiId'] = $driver['sBcgiId'];
    $response['sEmployeeNumber'] = $driver['sEmployeeNumber'];
    $response['sUserId'] = $driver['sUserId'];
    $response['dtDlExpires'] = $driver['dtDlExpires'];
    $response['dtFleetTestPassed'] = $driver['dtFleetTestPassed'];
    $response['dtFuelCardTestPassed'] = $driver['dtFuelCardTestPassed'];
    $response['dtAcknowledge'] = $driver['dtAcknowledge'];
    $response['dlFront'] = $driver['dlFront'];
    $response['dlBack'] = $driver['dlBack'];
    $response['sNotes'] = $driver['sNotes'];
    $response['sFirstName'] = $driver['sFirstName'];
    $response['sLastName'] = $driver['sLastName'];
} else {
    $response['error'] = 'Driver not found';
}

echo json_encode($response);

$conn = null;
