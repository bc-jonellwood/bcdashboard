<?php
// Created: 2024/10/18 14:23:21
// Last modified: 2025/01/17 12:27:51
// include_once(dirname(__FILE__) . './dbheader.php');
include_once "../data/appConfig.php";;


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


$data = json_decode(file_get_contents('php://input'), true);
$newRequestEmpNumber = $data[0]['newRequestEmpNumber'];
$timeApprover = $data[1]['timeApprover'];
$leaveApprover = $data[2]['leaveApprover'];
// $compAssetNumber = $data[3]['compAssetNumber'];
$deskPhone = $data[3]['deskPhone'];
$emailType = $data[4]['emailType'];
$officeApplicationType = $data[5]['officeApplicationType'];
$accessRights = $data[6]['accessRightsList'];
$requestComments = $data[7]['requestComments'];
$requestType = $data[8]['requestType'];
$userId = $data[9]['newRequestUserId'];


// we need to first remove the old access rights and then write the new ones
$sql = "DELETE FROM data_features_access_users WHERE sUserId = '$userId'";
$stmt = $conn->prepare($sql);
$stmt->execute();
// noew we can write the new ones to the database
foreach ($accessRights as $access) {
    foreach ($access as $key => $value) {
        $sql = "INSERT into data_features_access_users (sUserId, sFeatureAccessId) VALUES ('$userId', '$key')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // echo $sql;
    }
}




echo $newRequestEmpNumber;
echo $leaveApprover;
echo $timeApprover;
echo $deskPhone;
echo $requestComments;
echo $emailType;
echo $officeApplicationType;
echo $requestType;
// echo $accessRights;
