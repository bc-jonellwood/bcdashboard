<?php
function getCurrentDateTime()
{
    try {
        date_default_timezone_set('America/New_York');
        // $currentDateTime = date('Y-m-d H:i:s');
        $currentDateTime = date('m-d-Y');

        return $currentDateTime;
    } catch (Exception $e) {

        error_log("Error occurred while fetching date and time: " . $e->getMessage());
        return "Error retrieving date and time.";
    }
}
$currentDateTime = getCurrentDateTime();
echo $currentDateTime;
