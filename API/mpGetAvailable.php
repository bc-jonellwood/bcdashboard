<?php
// Created: 2024/12/16 10:05:53
// Last modified: 2024/12/16 15:12:42

include "dbheader.php";
// use get file contents to get the data being sent to this file
//$req = file_get_contents('php://input');
$req = json_decode(file_get_contents('php://input'), true);
$iMaxOccupancy = $req['mp-occupancy'];
$bVehCargoSpace = $req['mp-cargo'];
$dtStart = $req['sqlPickupDate'];
$dtEnd = $req['sqlReturnDate'];
// $userId = $_SESSION['userID'];
// if bVehCargoSpace is false omit it from the query
// iMaxOccupancy query should be >= $iMaxOccupancy not = $iMaxOccupancy

// $iMaxOccupancy = 5;
// $bVehCargoSpace = 1;
// $dtStart = '2024-12-16 08:00:00';
// $dtEnd = '2024-12-16 17:00:00';


$sql = "SELECT TOP(1) dmv.sVehUid, dmv.sVehName, dmv.iVehMaxOccupancy, dmv.iVehOdometer, dmv.sVehUnitNum, 
dmv.bVehCargoSpace, dl.sLocName
FROM data_mp_vehicles dmv
JOIN data_locations dl on dl.sLocUid = dmv.sVehLocationId
WHERE bIsRetired = 0 
AND iVehMaxOccupancy >= $iMaxOccupancy ";
if ($bVehCargoSpace) {
    $sql .= " AND bVehCargoSpace = $bVehCargoSpace";
}
$sql .= " ORDER BY iVehOdometer DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// take the sVehUid and query the data_mp_bookins table to see if the vehicle is reserved for the dates selected
// if the vehicle is reserved for the dates selected remove it from the data array
// return as an array
$available = [];
foreach ($data as $key => $value) {
    $sVehUid = $value['sVehUid'];
    //echo $sVehUid;

    $sql = "SELECT sVehUid FROM data_mp_vehicle_bookings WHERE sVehUid = '$sVehUid' AND dtStart <= '$dtStart' AND dtEnd >= '$dtEnd'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $available[] = $value;
    }
}

header('Content-Type: application/json');
echo json_encode($available);
