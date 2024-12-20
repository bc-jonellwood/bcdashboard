<?php
// Created: 2024/12/12 11:27:44
// Last modified: 2024/12/19 15:50:00

include "dbheader.php";
$sql = "SELECT id, sName, dtDate, iGroupId FROM data_holidays order by dtDate asc";
$result = $conn->query($sql);
$holidays = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    array_push($holidays, $row);
}
header('Content-Type: application/json');
echo json_encode($holidays);
