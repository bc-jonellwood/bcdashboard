<?php
// Created: 2025/01/06 14:38:52
// Last modified: 2025/01/06 15:06:22

include "dbheader.php";

$id = $_GET['userId'];
// echo $id;

$depString = $_GET['departments'];
$departments = explode(",", $depString);
echo "<pre>";
print_r($departments);
echo "</pre>";
// echo $depString;

// Loop over de IDs
$sql = "DELETE FROM data_emp_departments WHERE sUserId = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_STR);
$stmt->execute();

$sql = "
            INSERT INTO data_emp_departments (sUserId, iDepartmentNumber)
            VALUES (:id, :departmentNumber)
        ";

$stmt = $conn->prepare($sql);

foreach ($departments as $departmentNumber) {
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':departmentNumber', $departmentNumber, PDO::PARAM_INT);
    $stmt->execute();
}
