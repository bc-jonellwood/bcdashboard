<?php
include_once "dbheader.php";

// Read JSON file
$json_data = file_get_contents('../data/bcgi_data_exports/mp_vehicle_drivers.json');
$drivers = json_decode($json_data, true);

foreach ($drivers as $driver) {
    $sBcgiId = $driver['users_id'];
    $sEmployeeNumber = $driver['ifas'];
    $dtDlExpires = $driver['dl_expiry'];
    $dtFleetTestPassed = $driver['fleettest_passdt'];
    $dtFuelCardTestPassed = $driver['fuelcard_passdt'];
    $dtAcknowledge = $driver['acknowledge'];
    $sNotes = $driver['notes'];

    // Insert data into data_mp_vehicle_drivers table
    $sql = "INSERT INTO data_mp_vehicle_drivers (sBcgiId, sEmployeeNumber, dtDlExpires, dtFleetTestPassed, dtFuelCardTestPassed, dtAcknowledge, sNotes)
            VALUES ('$sBcgiId', '$sEmployeeNumber', '$dtDlExpires', '$dtFleetTestPassed', '$dtFuelCardTestPassed', '$dtAcknowledge', '$sNotes')";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt) {
            $last_id = $conn->insert_id;
            $sql_check = "SELECT sUserId FROM app_users WHERE sEmployeeNumber = '$sEmployeeNumber'";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute();
            $result = $stmt_check->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $sUserId = $row['sUserId'];
                $sql_update = "UPDATE data_mp_vehicle_drivers SET sUserId = '$sUserId' WHERE id = '$last_id'";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->execute();
            }
        } else {
            echo json_encode(['success' => false]);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
};
$conn->close();

//////////////////////////////////
$updateSql = "UPDATE data_mp_vehicle_drivers
SET sUserId = (
    SELECT au.id
    FROM app_users au
    WHERE au.sEmployeeNumber = data_mp_vehicle_drivers.sEmployeeNumber
)
WHERE EXISTS (
    SELECT 1
    FROM app_users au
    WHERE au.sEmployeeNumber = data_mp_vehicle_drivers.sEmployeeNumber
);"


// if ($conn->query($sql) === TRUE) {
    //     $last_id = $conn->insert_id;

    //     // Check for matching sEmployeeNumber in app_users table
    //     $sql_check = "SELECT sUserId FROM app_users WHERE sEmployeeNumber = '$sEmployeeNumber'";
    //     $result = $conn->query($sql_check);

    //     if ($result->num_rows > 0) {
    //         $row = $result->fetch_assoc();
    //         $sUserId = $row['sUserId'];

    //         // Update sUserId in data_mp_vehicle_drivers table
    //         $sql_update = "UPDATE data_mp_vehicle_drivers SET sUserId = '$sUserId' WHERE id = '$last_id'";
    //         $conn->query($sql_update);
    //     }
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }