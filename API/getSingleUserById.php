<?php
// Created: 2024/11/05 10:31:55
// Last modified: 2025/01/16 15:54:08

require_once '../classes/User.php';

$sUserID = isset($_GET['id']) ? $_GET['id'] : null;

if ($sUserID === null) {
    echo json_encode(['error' => 'User ID is required']);
    exit;
}
$user = new User();
$userData = $user->getUser($sUserID);

echo json_encode($userData);

// Close the database connection
$conn = null;
