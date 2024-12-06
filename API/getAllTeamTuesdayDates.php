<?php
include_once "./dbheader.php";

$sql = "SELECT dtPublishDate, dtExpireDate, sTitle FROM data_team_tuesday ORDER BY dtPublishDate ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
