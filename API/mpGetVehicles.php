<?php
// Created: 2024/12/17 11:06:11
// Last modified: 2024/12/17 11:43:01

include "dbheader.php";

$sql = "SELECT dmv.iLegacyId, dmv.sVehUid, dmv.sVehName, dmv.iVehMaxOccupancy, dmv.iVehOdometer
      ,dmv.bIsRetired, dmv.sVehUnitNum, dmv.sVehVin
      ,dmv.bVehCargoSpace, dmv.iVehNextServiceOdometer, dmv.bOutForService, dmv.bIsAvailable,
      dl.sLocName
  FROM data_mp_vehicles dmv
  JOIN data_locations dl on dl.sLocUid = dmv.sVehLocationId
  ORDER by dmv.bIsRetired ASC, dmv.sVehName ASC
  ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
