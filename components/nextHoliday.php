
<?php

function findNextHoliday($holidays)
{
    // Get current date
    $today = new DateTime('now');
    $today->setTime(0, 0, 0); // Reset time to midnight for accurate comparison

    $nextHoliday = null;
    $daysUntil = null;
    $holidayName = null;

    // Initialize minimum difference to a large number
    $minDifference = PHP_INT_MAX;

    foreach ($holidays as $name => $date) {
        $holidayDate = new DateTime($date);
        $holidayDate->setTime(0, 0, 0);

        // Calculate difference in days
        $difference = $today->diff($holidayDate);
        $daysDifference = (int)$difference->format('%R%a');

        // Only consider future holidays
        if ($daysDifference >= 0 && $daysDifference < $minDifference) {
            $minDifference = $daysDifference;
            $nextHoliday = $holidayDate;
            $daysUntil = $daysDifference;
            $holidayName = $name;
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
        'date' => $nextHoliday->format('Y-m-d'),
        'days_until' => $daysUntil
    ];
}

// Example usage:
$holidays = [
    "New Year's Day" => "2024-01-01",
    "Martin Luther King Jr. Day" => "2024-01-15",
    "Good Friday" => "2024-03-29",
    "Memorial Day" => "2024-05-27",
    "Independence Day" => "2024-07-04",
    "Labor Day" => "2024-09-02",
    "Veterans Day" => "2024-11-11",
    "Thanksgiving Day" => "2024-11-28",
    "Christmas" => "2024-12-25",
    "New Year's Day" => "2025-01-01"
];

$result = findNextHoliday($holidays);
// print_r($result);
echo "<div id='988846bf-c1bf-4867-8399-e0dd5000458d' class='dash-card narrow short'>";
echo "<div class='card-content'>";
echo "<div class='component-header'>Next Holiday <button class='not-btn' onclick='minimizeCard(\"988846bf-c1bf-4867-8399-e0dd5000458d\")'>";
echo "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'>";
echo "<path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg>";
echo "</button></div>";
echo "<div class='holiday' id='holiday'>";
echo "<p class='days-unitl-holiday'>" . $result['days_until'] . " days until </p>";
echo "<p class='holiday-name'>" . $result['name']  . "</p>";
echo "<p> on " . $result['date'] . "</p>";
echo "</div></div></div>";
