<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/02 10:23:35

include_once "../data/appConfig.php";

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

// $sEventID = $_GET['eventID'];
$sEventID = isset($_GET['eventID']) ? $_GET['eventID'] : null;

if ($sEventID === null) {
    echo json_encode(['error' => 'Event ID is required']);
    exit;
}

// SQL query to fetch event and associated time slots
$sql = "SELECT e.event_id, e.sTitle, e.sDescription, e.dtStartDate, e.dtEndDate, e.sStatus, e.iCreatedBy, e.dtCreatedOn,
s.slot_id, s.dtStartTime as slotStartTime, s.dtEndTime as slotEndTime, s.iMaxAttendees as slotMaxAttendees, s.sDurationMinutes as slotDurationMinutes, s.sLocationId as slotLocationId, l.sLocationName as slotLocationName
FROM app_events e
LEFT JOIN app_events_timeSlots s ON s.fkEventId = e.event_id
LEFT JOIN data_event_locations l ON l.iLocationId = s.sLocationId
WHERE e.event_id = :event_id";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':event_id', $sEventID, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Structuring the response
    $response = [
        'event' => null,
        'slots' => []
    ];

    if (!empty($data)) {
        $response['event'] = $data[0]; // First row is the event
        foreach ($data as $row) {
            if (!empty($row['slot_id'])) {
                $response['slots'][] = [
                    'slot_id' => $row['slot_id'],
                    'slotStartTime' => $row['slotStartTime'],
                    'slotEndTime' => $row['slotEndTime'],
                    'slotMaxAttendees' => $row['slotMaxAttendees'],
                    'slotDurationMinutes' => $row['slotDurationMinutes'],
                    'slotLocationId' => $row['slotLocationId'],
                    'slotLocationName' => $row['slotLocationName']
                ];
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Query failed: ' . $e->getMessage()]);
}
