<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/06 11:24:31

// query the database for notifications where the current date and time is between the start and end dates of the notification. Return the results as an array.



include_once "../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    // Establishing the database connection
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query
    $sql = "SELECT * FROM app_notifications WHERE dtStartDate <= CURRENT_TIMESTAMP AND dtEndDate >= CURRENT_TIMESTAMP AND sStatus = 'active'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetching the results
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if data is found
    if (empty($data)) {
        $timezone = 'America/New_York';
        date_default_timezone_set($timezone);
        // No data found, return a specific message
        $response = [
            [
                'sNoticationText' => 'no data located',
                'dtStartDate' => date('Y-m-d H:i:s'),
                // 'dtEndDate' => date('Y-m-d H:i:s'),
                'dtEndDate' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
                'sNotificationType' => 'null',
                'sNotificationText' => ''
            ]
        ];
    } else {
        // Data found, return the data
        $response = $data;
    }

    // Set the content type to JSON and output the response
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Handle connection errors
    $errorResponse = [
        'error' => 'Connection failed',
        'message' => $e->getMessage(),
        'dtStartTime' => date('Y-m-d H:i:s'),
        'dtEndDate' => date('Y-m-d H:i:s')
    ];
    header('Content-Type: application/json');
    echo json_encode($errorResponse);
}
