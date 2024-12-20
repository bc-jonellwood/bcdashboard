<?php
// Created: 2024/11/05 10:31:55
// Last modified: 2024/12/19 12:56:20

require_once '../data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
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
            au.bHideBirthday,
            dvd.id as sDriverId,
            dvd.sBcgiId,
            dvd.sEmployeeNumber,
            dvd.sUserId,
            dvd.dtDlExpires,
            dvd.dtFleetTestPassed,
            dvd.dtFuelCardTestPassed,
            dvd.dtAcknowledge,
            dvd.dlFront,
            dvd.dlBack,
            dvd.sNotes
            from app_users au
            join data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
            left join data_mp_vehicle_drivers dvd on dvd.sUserId = au.id
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
    $response['sDriverId'] = $user['sDriverId'];
    $response['sBcgiId'] = $user['sBcgiId'];
    $response['sEmployeeNumber'] = $user['sEmployeeNumber'];
    $response['sUserId'] = $user['sUserId'];
    $response['dtDlExpires'] = $user['dtDlExpires'];
    $response['dtFleetTestPassed'] = $user['dtFleetTestPassed'];
    $response['dtFuelCardTestPassed'] = $user['dtFuelCardTestPassed'];
    $response['dtAcknowledge'] = $user['dtAcknowledge'];
    $response['dlFront'] = $user['dlFront'];
    $response['dlBack'] = $user['dlBack'];
    $response['sNotes'] = $user['sNotes'];
} else {
    $response['error'] = 'User not found';
}

echo json_encode($response);

// Close the database connection
$conn = null;
