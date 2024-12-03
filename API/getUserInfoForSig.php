<?php
// Created:  
// Last modified: 2024/12/03 10:42:55
include "dbheader.php";
session_start();

$sql = "SELECT au.sFirstName, au.sLastName, au.sPreferredName, au.sJobTitle, au.sMainPhoneNumber, au.sEmail, dd.sDepartmentName
        FROM app_users au 
        JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
        WHERE au.sEmployeeNumber = :id";
$data = [];

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['employeeID']);
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
