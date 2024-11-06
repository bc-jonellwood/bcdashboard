<?php

// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/06 11:24:31

// $data = $_POST;
// $fkEventId = $data['eventID'];

// echo json_encode($data);


// Function to handle incoming POST request
function handleEventRequest()
{
    include_once "../data/appConfig.php";

    $dbconf = new appConfig;
    $serverName = $dbconf->serverName;
    $database = $dbconf->database;
    $uid = $dbconf->uid;
    $pwd = $dbconf->pwd;


    try {
        $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        return;
    }

    // Initialize variables
    $eventID = $maxSessionAttendeesInput = $eventDurationHours = $eventStartTime = $eventSessionLengthMinutes = null;
    $slots = [];

    try {
        // Validate and assign values from POST request
        if (isset($_POST['eventID'])) {
            $eventID = $_POST['eventID'];
        } else {
            throw new Exception('eventID is required.');
        }

        if (isset($_POST['maxSessionAttendeesInput'])) {
            $maxSessionAttendeesInput = (int)$_POST['maxSessionAttendeesInput'];
        } else {
            throw new Exception('maxSessionAttendeesInput is required.');
        }

        if (isset($_POST['eventDurationHours'])) {
            $eventDurationHours = (int)$_POST['eventDurationHours'];
        } else {
            throw new Exception('eventDurationHours is required.');
        }

        if (isset($_POST['eventStartTime'])) {
            $eventStartTime = $_POST['eventStartTime'];
        } else {
            throw new Exception('eventStartTime is required.');
        }

        if (isset($_POST['eventSessionLengthMinutes'])) {
            $eventSessionLengthMinutes = (int)$_POST['eventSessionLengthMinutes'];
        } else {
            throw new Exception('eventSessionLengthMinutes is required.');
        }
        $insertSlotQuery = "INSERT INTO app_events_timeSlots (slot_id, fkEventId, dtStartTime, iMaxAttendees, sDurationMinutes, sLocationId) VALUES (:slot_id, :event_id, :slot_start_time, :maxAttendees, :duration, :sLocationId)";
        $stmt = $conn->prepare($insertSlotQuery);
        // Loop through the POST data to collect slot information
        $index = 0;
        while (isset($_POST["slot_id-$index"])) {
            $slotID = $_POST["slot_id-$index"];
            echo $slotID;
            $slotStartTime = $_POST["slot_start_time-$index"];
            $sLocationId = $_POST["slotLocation-$index"] ?? null;

            $stmt->bindParam(':slot_id', $slotID);
            $stmt->bindParam(':event_id', $eventID);
            $stmt->bindParam(':duration', $eventSessionLengthMinutes);
            $stmt->bindParam(':maxAttendees', $maxSessionAttendeesInput);
            $stmt->bindParam(':slot_start_time', $slotStartTime);
            $stmt->bindParam(':sLocationId', $sLocationId);
            $stmt->execute();

            // if ($slotStartTime) {
            //     $slots[] = [
            //         'slot_id' => $slotID,
            //         'slot_start_time' => $slotStartTime,
            //         'maxAttendees' => $maxSessionAttendeesInput,
            //         'eventLocation' => $_POST["slotLocation-$index"] ?? null,
            //         'duration' => $eventSessionLengthMinutes,
            //         'event_id' => $eventID
            //     ];

            // } else {
            //     throw new Exception("slot_start_time-$index is required.");
            // }
            $index++;
        }

        // Here we will insert into the database but for now
        // lets just print the values until we know what we are working with
        // echo json_encode([
        //     'eventID' => $eventID,
        //     'maxSessionAttendeesInput' => $maxSessionAttendeesInput,
        //     'eventDurationHours' => $eventDurationHours,
        //     'eventStartTime' => $eventStartTime,
        //     'eventSessionLengthMinutes' => $eventSessionLengthMinutes,
        //     'slots' => $slots
        // ]);
        // Add event to the database
        // $sql = "INSERT INTO app_events_timeSlots (slot_id, fkEventId, dtStartTime, iMaxAttendees, sDurationMinutes, sLocationId) VALUES (?, ?, ?, ?, ?, ?)";
        // $stmt = $conn->prepare($sql);
        // $stmt->bindParam(1, $slotID);
        // $stmt->bindParam(2, $eventID);
        // $stmt->bindParam(3, $slotStartTime);
        // $stmt->bindParam(4, $maxSessionAttendeesInput);
        // $stmt->bindParam(5, $eventSessionLengthMinutes);
        // $stmt->bindParam(6, $slots[0]['eventLocation']);
        // $stmt->execute();

        // Return success response
        http_response_code(200);
        // echo json_encode(['success' => 'Event slots added successfully']);
        header("Location: ../success.php");
    } catch (Exception $e) {
        // Handle exceptions and return error response
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Call the function to handle the request
handleEventRequest();
