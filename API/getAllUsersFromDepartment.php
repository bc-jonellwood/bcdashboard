<?php
// Created: 2024/12/02 12:36:43
// Last Modified: 2024/12/13 11:09:06
session_start();
include "dbheader.php";

// $dept = $_GET['dept'];
$dept = $_SESSION['DepartmentNumber'];

// $data = [];

$sql = "SELECT DISTINCT au.id as userId, au.sFirstName, au.sMiddleName, au.sLastName, au.sPreferredName, au.sEmployeeNumber, au.iDepartmentNumber, dd.sDepartmentName, au.dtStartDate, au.sEmail
from app_users au
JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
where au.bIsActive = 1
AND au.iDepartmentNumber = '$dept'
order by au.sFirstName ASC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
header('Content-Type: application/json');
echo json_encode($result);
