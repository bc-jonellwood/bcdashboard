<?php
// Created: 2024/10/25 14:04:32
// Last modified: 2024/10/25 14:52:37

include_once '../data/appConfig.php';
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

include 'createGUID.php';
$data = json_decode(file_get_contents('php://input'), true);
echo $data;

// $requestId = generateGUID();
// $newUserId = $data[0]['newUserId']; //E4BCDD46-0DDA-459D-A835-2C8B88B3421E
// $newUserTimeApprover = $data[1]['newUserTimeApprover']; //77F56E03-C0B9-484E-9872-55D203C11F54
// $newUserLeaveApprover = $data[2]['newUserLeaveApprover']; //FD301AD2-94BB-42C7-A73B-FC5CB99A289F
// $newUserRequestSetupEquivalent = $data[3]['newUserRequestSetupEquivalent']; //DA176330-D2BF-4F95-A22C-44EFB616C47C
// $newUserRequestDeskPhone = $data[4]['newUserRequestDeskPhone'];
// $newUserRequestEmailType = $data[5]['newUserRequestEmailType']; //et1
// $newUserRequestOfficeApplicationType = $data[6]['newUserRequestOfficeApplicationType']; //oa1
// $newUserRequestComments = $data[7]['newUserRequestComments']; //asdf asdf
// $newUserRequestPermissions = implode(',', $newUserRequestPermissions);

// echo $requestId;
// echo $newUserId;
// echo $newUserTimeApprover;
// echo $newUserLeaveApprover;
// echo $newUserRequestSetupEquivalent;
// echo $newUserRequestDeskPhone;
// echo $newUserRequestEmailType;
// echo $newUserRequestOfficeApplicationType;
// echo $newUserRequestComments;
// echo $newUserRequestPermissions;
