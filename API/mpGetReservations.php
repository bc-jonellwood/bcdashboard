<?php
// Created: 2024/12/17 10:37:02
// Last modified: 2024/12/17 10:38:00

include "dbheader.php";

$sql = "SELECT mvb.sBookUid, mvb.sUserId, mvb.dtStart, mvb.dtEnd, mvb.sVehUid, mvb.sNotes, mv.sVehName, mv.sVehUnitNum, 
concat(au.sFirstName, ' ', au.sLastName) as sEmpName, au.sEmail
  FROM data_mp_vehicle_bookings mvb
  LEFT JOIN data_mp_vehicles mv on mv.sVehUid = mvb.sVehUid
  LEFT JOIN app_users au on au.id = mvb.sUserId
  ORDER BY dtStart ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($data);
