<?php
// Created: 2024/11/07 16:04:31
// Last modified: 2024/11/25 14:08:20

include "dbheader.php";

$sql = "SELECT au.sEmployeeNumber
from data_it_on_call oc 
JOIN app_users au on au.id = oc.sOnCallUserId
where dtWeekStart <= GETDATE() and dtWeekEnd >= GETDATE();";
$data = [];

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach ($row as $key => $value) {
            $row[$key] = trim($value);
        }
        array_push($data, $row);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
