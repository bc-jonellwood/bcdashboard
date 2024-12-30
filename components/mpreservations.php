<?php
// Created: 2024/12/30 11:33:13
// Last modified: 2024/12/30 15:29:20
// session_start();
// require_once './data/appConfig.php';
require_once './data/appConfig.php';

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$userId = $_SESSION['userID'];
// $userId = 'e4bcdd46-0dda-459d-a835-2c8b88b3421e';

$sql = "SELECT svb.id, svb.sBookUid, svb.sUserId, svb.dtStart, svb.dtEnd, dmv.sVehName, dmv.sVehUnitNum, svb.sNotes 
FROM data_mp_vehicle_bookings svb 
JOIN data_mp_vehicles dmv on dmv.sVehUid = svb.sVehUid WHERE sUserId = :id and dtStart >= GETDATE() and bIsCancelled = 0 ORDER BY dtStart ASC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($reservations) > 0) {
        echo "<div id='69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF' class='dash-card medWide'>";
        echo "<div class='card-content'>";
        echo "<div class='component-header'>Fleet Reservations<button class='not-btn' onclick='minimizeCard(\"69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF\")'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
        echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
        echo "</button></div>";
        echo "<table class='table'>";
        echo "<tbody><tr><th>Pickup</th><th>Vehicle</th><th>Dropoff</th><th></th></tr>";
        foreach ($reservations as $reservation) {
            echo "<tr class='reservation' id='" . $reservation['id'] . "'>";
            echo "<td class='small'>" . date('Y-m-d h:i A', strtotime($reservation['dtStart']))  . "</td>";
            echo "<td class='small'>" . $reservation['sVehName'] . '-' . $reservation['sVehUnitNum'] . "</td>";
            echo "<td class='small'>" . date('Y-m-d h:i A', strtotime($reservation['dtEnd']))  . "</td>";
            echo "<td class='small'><button class='btn btn-sm btn-danger' onclick='deleteMPReservation(" . json_encode($reservation['id']) . ")'>Delete</button></td><td class='small'></td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div id='69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF' class='dash-card narrow square'>";
        echo "<div class='card-content'>";
        echo "<div class='component-header'>Fleet Reservations<button class='not-btn' onclick='minimizeCard(\"69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF\")'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
        echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
        echo "</button></div>";
        echo "<div class='no-reservations'>No reservations found</div>";
        echo "</div>";
        echo "</div>";
        // return;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}





// $reservations = [];
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $reservations[] = $row;
//     if (count($reservations) > 0) {
//         echo "<div id='69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF' class='dash-card narrow square'>";
//         echo "<div class='component-header'>Fleet Reservations<button class='not-btn' onclick='minimizeCard(\"69D7DF6D-8DF5-7F80-A1E9-50E2AB848EEF\")'>";
//         echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
//         echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
//         echo "</button></div>";
//         echo "<div class='reservations'>";
//         foreach ($reservations as $reservation) {
//             $id = $reservation['id'];
//             $sBookUid = $reservation['sBookUid'];
//             $sUserId = $reservation['sUserId'];
//             $dtStart = $reservation['dtStart'];
//             $dtEnd = $reservation['dtEnd'];
//             $sVehUid = $reservation['sVehUid'];
//             $sNotes = $reservation['sNotes'];
//             echo "<div class='reservation'>";
//             echo "<p>Reservation ID: " . $id . "</p>";
//             echo "<p>Vehicle ID: " . $sVehUid . "</p>";
//             echo "<p>Start Date: " . $dtStart . "</p>";
//             echo "<p>End Date: " . $dtEnd . "</p>";
//             echo "<p>Notes: " . $sNotes . "</p>";
//             echo "</div>";
//         }
//         echo "</div>";
//         echo "</div>";
//     }
// }
