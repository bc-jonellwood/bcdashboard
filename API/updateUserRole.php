<?php
// Created: 2025/01/15 09:54:17
// Last modified: 2025/01/15 10:03:08

include 'dbheader.php';
include '../functions/logErrors.php';

$id = $_GET['id'];
$iAppRoleId = $_GET['roleId'];

try {

    $sql = "UPDATE app_users SET iAppRoleId = :iAppRoleId WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':iAppRoleId', $iAppRoleId, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    logError("User role updated successfully for user: $id");
} catch (PDOException $e) {
    logError('Database Error: ' . $e->getMessage());
}

echo json_encode(array("success" => true));
