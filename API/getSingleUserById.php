<?php
// Created: 2024/11/05 10:31:55
// Last modified: 2024/11/05 12:23:36

require_once '../data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

$sUserID = isset($_GET['id']) ? $_GET['id'] : null;

if ($sUserID === null) {
    echo json_encode(['error' => 'User ID is required']);
    exit;
}

// SQL query to fetch user
$sql = "SELECT au.id,
            au.sUserName,
            au.sEmployeeNumber,
            au.sFirstName,
            au.sPreferredName,
            au.sLastName,
            au.iDepartmentNumber,
            dd.sDepartmentName,
            au.sEmail,
            au.sMainPhoneNumber,
            au.sMainPhoneNumberLabel,
            au.bIsActive,
            au.bIsLDAP,
            au.bIsAdmin,
            au.bHideBirthday
            from app_users au
            join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
            where au.id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $sUserID, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Structuring the response
$response = [];
if ($user) {
    $response['id'] = $user['id'];
    $response['sUserName'] = $user['sUserName'];
    $response['sEmployeeNumber'] = $user['sEmployeeNumber'];
    $response['sFirstName'] = $user['sFirstName'];
    $response['sPreferredName'] = $user['sPreferredName'];
    $response['sLastName'] = $user['sLastName'];
    $response['iDepartmentNumber'] = $user['iDepartmentNumber'];
    $response['sDepartmentName'] = $user['sDepartmentName'];
    $response['sEmail'] = $user['sEmail'];
    $response['sMainPhoneNumber'] = $user['sMainPhoneNumber'];
    $response['sMainPhoneNumberLabel'] = $user['sMainPhoneNumberLabel'];
    $response['bIsActive'] = $user['bIsActive'];
    $response['bIsLDAP'] = $user['bIsLDAP'];
    $response['bIsAdmin'] = $user['bIsAdmin'];
    $response['bHideBirthday'] = $user['bHideBirthday'];
} else {
    $response['error'] = 'User not found';
}

echo json_encode($response);

// Close the database connection
$conn = null;
