<?php
// Created: 2024/10/21 15:29:43
// Last modified: 2024/12/12 10:57:40

require_once 'data/appConfig.php';
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
    echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT id, sName, dtDate, iGroupId FROM data_holidays order by dtDate asc";
$result = $conn->query($sql);
$holidays = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    array_push($holidays, $row);
}

function findNextHoliday($holidays)
{
    // Get current date
    $today = new DateTime('now');
    $today->setTime(0, 0, 0); // Reset time to midnight for accurate comparison

    $nextHoliday = null;
    $daysUntil = null;
    $holidayName = null;
    $holidayDates = [];

    // Initialize minimum difference to a large number
    $minDifference = PHP_INT_MAX;

    foreach ($holidays as $holiday) {
        $holidayDate = new DateTime($holiday['dtDate']);
        $holidayDate->setTime(0, 0, 0);

        // Calculate difference in days
        $difference = $today->diff($holidayDate);
        $daysDifference = (int)$difference->format('%R%a');

        // Only consider future holidays
        if ($daysDifference >= 0 && $daysDifference < $minDifference) {
            $minDifference = $daysDifference;
            $nextHoliday = $holiday;
            $daysUntil = $daysDifference;
            $holidayName = $holiday['sName'];
            $holidayDates = [$holiday['dtDate']];
        } elseif ($daysDifference == $minDifference && $holiday['iGroupId'] == $nextHoliday['iGroupId']) {
            $holidayDates[] = $holiday['dtDate'];
        }
    }

    // If no future holiday is found
    if ($nextHoliday === null) {
        return [
            'error' => 'No future holidays found'
        ];
    }

    return [
        'name' => $holidayName,
        'dates' => $holidayDates,
        'days_until' => $daysUntil
    ];
}

$result = findNextHoliday($holidays);
// print_r($result);
echo "<div id='988846bf-c1bf-4867-8399-e0dd5000458d' class='dash-card narrow square'>";
echo "<div class='card-content'>";
echo "<div class='component-header'>Next Holiday <button class='not-btn' onclick='minimizeCard(\"988846bf-c1bf-4867-8399-e0dd5000458d\")'>";
echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
echo "</button></div>";
echo "<div class='holiday' id='holiday'>";
echo "<p class='days-unitl-holiday'>" . $result['days_until'] . " days until </p>";
echo "<p class='holiday-name'>" . $result['name']  . "</p>";
echo "<p> on " . implode(', ', $result['dates']) . "</p>";
echo "</div></div></div>";
