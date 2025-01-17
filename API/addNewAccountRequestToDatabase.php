<?php
// Created: 2024/10/25 14:04:32
// Last modified: 2025/01/17 12:21:27
// include_once(dirname(__FILE__) . './dbheader.php');
include_once '../data/appConfig.php';
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
// this is hard coded for dev. We need to change this later to a session variable that we get at log in.
$sSubmmitterUserId = 'e4bcdd46-0dda-459d-a835-2c8b88b3421e';
include 'createGUID.php';
$data = json_decode(file_get_contents('php://input'), true);
// echo $data;
$jsonData = json_encode($data);
// echo $jsonData;
$thisId = generateGUID();

$newUserEmployeeNumber = $data[0]['newUserEmployeeNumber'];
$newRequestUserId = $data[1]['newRequestUserId']; //E4BCDD46-0DDA-459D-A835-2C8B88B3421E
$newUserTimeApprover = $data[2]['newUserTimeApprover']; //77F56E03-C0B9-484E-9872-55D203C11F54
$newUserLeaveApprover = $data[3]['newUserLeaveApprover']; //FD301AD2-94BB-42C7-A73B-FC5CB99A289F
$newUserRequestSetupEquivalent = $data[4]['newUserRequestSetupEquivalent']; //DA176330-D2BF-4F95-A22C-44EFB616C47C
$newUserRequestDeskPhone = $data[5]['newUserRequestDeskPhone'];
$newUserRequestEmailType = $data[6]['newUserRequestEmailType']; //et1
$newUserRequestOfficeApplicationType = $data[7]['newUserRequestOfficeApplicationType']; //oa1
$newUserRequestComments = $data[9]['newUserRequestComments']; //asdf asdf
$requestType = $data[10]['requestType'];
$newUserRequestPermissions = $data[8]['newUserRequestPermissions'];

$sql = "INSERT into app_account_requests(id, sReqRefEmployeeId ,sReqRefEmployeeNumber, sSubmitterUserId, sRequestType, sRequestDataObject) VALUES (:thisId, :newRequestUserId, :newUserEmployeeNumber, :sSubmmitterUserId, :requestType, :jsonData)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':thisId', $thisId);
$stmt->bindParam(':newRequestUserId', $newRequestUserId);
$stmt->bindParam(':newUserEmployeeNumber', $newUserEmployeeNumber);
$stmt->bindParam(':sSubmmitterUserId', $sSubmmitterUserId);
$stmt->bindParam(':requestType', $requestType);
$stmt->bindParam(':jsonData', $jsonData);
// $stmt->execute();
if ($stmt->execute() && $stmt->rowCount() > 0) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to save data"]);
}
// !!NOW TRY TO USE THE ACTUAL MAILER PROGRAM WE USE...
// **AFTER WE HAVE A WORKING SERVER SINCE THE MAIL SERVER WILL BLOCK REQUESTS FROM LOCALHOST
// ** CONTINUE TO BUILD OUT THE LOGIC FOR EACH AND REFINE THE SENDMAIL FUNCTION
try {
    foreach ($newUserRequestPermissions as $key => $value) {
        if (in_array('1026', $newUserRequestPermissions)) {
            sendmail('jon.ellwood@berkeleycountysc.gov', 'Account Request for Network Access', $newUserRequestPermissions);
        }
    }
} catch (Exception $e) {
    echo "An error occured: " . $e->getMessage() . "\n";
} finally {
    echo "We all done here.";
}

// echo "<pre>";
// echo '* requestId;' . $requestId;
// echo "</br>";
// echo '* newUserEmployeeNunber;' . $newUserEmployeeNunber;
// echo "</br>";
// echo '* newRequestUserId;' . $newRequestUserId;
// echo "</br>";
// echo '* newUserTimeApprover;' . $newUserTimeApprover;
// echo "</br>";
// echo '* newUserLeaveApprover;' . $newUserLeaveApprover;
// echo "</br>";
// echo '* newUserRequestSetupEquivalent;' . $newUserRequestSetupEquivalent;
// echo "</br>";
// echo '* newUserRequestDeskPhone;' . $newUserRequestDeskPhone;
// echo "</br>";
// echo '* newUserRequestEmailType;' . $newUserRequestEmailType;
// echo "</br>";
// echo '* newUserRequestOfficeApplicationType;' . $newUserRequestOfficeApplicationType;
// echo "</br>";
// echo '* newUserRequestComments;' . $newUserRequestComments;
// echo "</br>";
// echo '* newUserRequestPermissions;' . json_encode($newUserRequestPermissions);
// echo "</br>";
// echo '* requestType;' . $requestType;
// echo "</br>";
// echo '* jsonData;' . $jsonData;
// echo "</br>";
// echo "</pre>";
