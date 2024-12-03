<?php
// Created: 2024/10/25 14:04:32
// Last modified: 2024/12/02 13:55:11

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
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    return;
}
try {
    if (isset($_POST['issueTitle'])) {
        $issueTitle = strip_tags($_POST['issueTitle']);
    } else {
        throw new Exception("Issue title is required");
    }

    if (isset($_POST['issueDescription'])) {
        $issueDescription = strip_tags($_POST['issueDescription']);
    } else {
        $issueDescription = "Not Provided";
    }

    if (isset($_POST['issueType'])) {
        $issueType = strip_tags(intval($_POST['issueType']));
    } else {
        throw new Exception("Issue type is required");
    }

    if (isset($_POST['issueLocation'])) {
        $issueLocation = strip_tags($_POST['issueLocation']);
    } else {
        throw new Exception("Issue location is required");
    }

    if (isset($_POST['issueSubLocation'])) {
        $issueSubLocation = strip_tags($_POST['issueSubLocation']);
    } else {
        $issueSubLocation = "Not Provided";
    }

    // if (isset($_POST['issuePriority'])) {
    //     $issuePriority = htmlspecialchars($_POST['issuePriority'], ENT_QUOTES);
    // } else {
    //     throw new Exception("Issue priority is required");
    // }
    if (isset($_POST['requestorName'])) {
        $requestorName = strip_tags($_POST['requestorName']);
    } else {
        $requestorName = "Not Provided";
    }
    if (isset($_POST['requestorUserID'])) {
        $requestorUserID = strip_tags($_POST['requestorUserID']);
    } else {
        throw new Exception("Requestor user ID is required");
    }
    if (isset($_POST['primaryContact'])) {
        $primaryContact = strip_tags($_POST['primaryContact']);
    } else {
        throw new Exception("Primary contact is required");
    }
    if (isset($_POST['phoneNumber'])) {
        $phoneNumber = strip_tags($_POST['phoneNumber']);
    } else {
        throw new Exception("Phone number is required");
    }
    if (isset($_POST['desiredResponse'])) {
        $desiredResponse = strip_tags(intval($_POST['desiredResponse']));
    } else {
        throw new Exception("Desired response is required");
    }

    if (isset($_POST['additionalContacts']) && is_array($_POST['additionalContacts'])) {
        $additionalContacts = implode(',', array_map('strip_tags', $_POST['additionalContacts']));
    } else {
        $additionalContacts = "";
    }
    // echo $additionalContacts;

    $sql = "INSERT INTO app_facilities_requests (sIssueTitle, sIssueDescription, iIssueType, sIssueLocation, sIssueSubLocation, sRequestorName, sRequestorUserID, sPrimaryContact, sPhoneNumber, iDesiredResponse, sAdditionalContacts) VALUES (:issueTitle, :issueDescription, :issueType, :issueLocation, :issueSubLocation, :requestorName, :requestorUserID, :primaryContact, :phoneNumber, :desiredResponse, :additionalContacts)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':issueTitle', $issueTitle);
    $stmt->bindParam(':issueDescription', $issueDescription);
    $stmt->bindParam(':issueType', $issueType);
    $stmt->bindParam(':issueLocation', $issueLocation);
    $stmt->bindParam(':issueSubLocation', $issueSubLocation);
    // $stmt->bindParam(':issuePriority', $issuePriority);
    $stmt->bindParam(':requestorName', $requestorName);
    $stmt->bindParam(':requestorUserID', $requestorUserID);
    $stmt->bindParam(':primaryContact', $primaryContact);
    $stmt->bindParam(':phoneNumber', $phoneNumber);
    $stmt->bindParam(':desiredResponse', $desiredResponse);
    $stmt->bindParam(':additionalContacts', $additionalContacts);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(['message' => 'Facilities request added successfully']);
        header("Location: ../facilitiesrequestview.php");
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to add facilities request']);
        return;
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    return;
}
