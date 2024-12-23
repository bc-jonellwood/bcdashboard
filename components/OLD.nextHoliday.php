<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/11/12 15:10:24
/**
 * Function to find the next upcoming holiday from a list of holidays.
 *
 * @param array $holidays An associative array of holidays with date strings as values.
 * @return string The next upcoming holiday or an error message.
 */
function getNextHoliday(array $holidays): array
{

    try {
        $today = new DateTime();
        echo $today->format('m-d-Y');

        $nextHoliday = null;
        $daysUntilHoliday = null;

        foreach ($holidays as $holiday => $date) {
            $holidayDate = new DateTime($date);
            // Check if the holiday is in the future
            if ($holidayDate > $today) {
                // If it's the first upcoming holiday or closer than the previous one
                if ($nextHoliday === null || $holidayDate < new DateTime($nextHoliday['date'])) {
                    $nextHoliday = [
                        'name' => $holiday,
                        'date' => $holidayDate->format('m-d-Y')
                    ];
                }
            }
        }

        // If no upcoming holiday is found, throw an exception
        if ($nextHoliday === null) {
            throw new Exception("No upcoming holidays found.");
        }

        // Calculate the number of days until the next holiday
        $daysUntilHoliday = $today->diff(new DateTime($nextHoliday['date']))->days;

        return [
            'name' => $nextHoliday['name'],
            'date' => $nextHoliday['date'],
            'daysUntil' => $daysUntilHoliday
        ];
    } catch (Exception $e) {
        // Handle exceptions and return a user-friendly message
        return [
            'error' => $e->getMessage()
        ];
    }
}


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
    "New Year's Day" => "2025-01-01",
];

$result = getNextHoliday($holidays);
echo "result";
echo json_encode($result);
echo "<div id='988846bf-c1bf-4867-8399-e0dd5000458d' class='dash-card narrow short'>
                        <div class='card-content'>
                            <div class='component-header'>Next Holiday <button class='not-btn' onclick='minimizeCard(\"988846bf-c1bf-4867-8399-e0dd5000458d\")'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' class='recolor' width='24' height='24'><path d='M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z' /></svg></button></div>
                            <div class='holiday' id='holiday'>";
echo "<p class='days-unitl-holiday'>" . $result['daysUntil'] ? $result['daysUntil'] : "0" . " days until </p>";
echo "<p class='holiday-name'>" . $result['name'] ? $result['name'] : "Holdiay Name" . "</p>";
echo "<p> on " . $result['date'] ? $result['date'] : "Holdiay Date" . "</p>";
echo "</div></div></div>";


echo json_encode($result);

// if (isset($result['error'])) {
//     echo "Error: " . $result['error'];
// } else {
//     echo "The next holiday is " . $result['name'] . " on " . $result['date'] . "  in " . $result['daysUntil'] . " days.";
// }
