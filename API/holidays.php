<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/03 09:59:05
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
];

$result = getNextHoliday($holidays);

echo json_encode($result);

// if (isset($result['error'])) {
//     echo "Error: " . $result['error'];
// } else {
//     echo "The next holiday is " . $result['name'] . " on " . $result['date'] . "  in " . $result['daysUntil'] . " days.";
// }
