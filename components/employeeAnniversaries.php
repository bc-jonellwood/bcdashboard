<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 11:27:05

include_once "../data/appConfig.php";

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
    // echo "Connection failed: " . $e->getMessage();
}

$sql = "BEGIN TRY
    SELECT au.id
           ,au.sFirstName
           ,au.sLastName
           ,au.dtStartDate
           ,au.bIsActive
           ,dd.sDepartmentName
    FROM app_users au
    JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
    WHERE MONTH(dtStartDate) = MONTH(GETDATE())
      AND YEAR(dtStartDate) != YEAR(GETDATE())
      AND dtSeparationDate IS NULL
      AND bIsActive = 1
    ORDER BY dtStartDate ASC;
END TRY
BEGIN CATCH
    -- Handle the error that you know I made
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT @ErrorMessage = ERROR_MESSAGE(),
           @ErrorSeverity = ERROR_SEVERITY()

    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;";
function parseDateForMonthAndDayOnly($date)
{
    list($year, $month, $day) = explode("-", $date);
    return "{$month}/{$day}";
}

function calculateYears($date)
{
    try {
        // Chwec for valid date
        $anniversaryDate = DateTime::createFromFormat('Y-m-d', $date);
        if (!$anniversaryDate) {
            throw new Exception("Invalid date format. Please use 'Y-m-d'.");
        }

        // Get today's date
        $today = new DateTime();

        // Calculate the difference in years
        $years = $today->format('Y') - $anniversaryDate->format('Y');
        $m = $today->format('m') - $anniversaryDate->format('m');

        // Adjust the year count if the anniversary hasn't occurred yet this year
        if ($m < 0 || ($m === 0 && $today->format('d') < $anniversaryDate->format('d'))) {
            $years--;
        }

        return $years;
    } catch (Exception $e) {
        // Handle exceptions and return something...
        echo 'Error: ' . $e->getMessage();
        return -1; // Indicate an error occurred
    }
}
function processEmployees($data)
{
    try {
        $currentYear = date("Y");
        $groupedEmployees = [];

        foreach ($data as $employee) {
            // Validate employee data
            if (empty($employee['dtStartDate'])) {
                throw new Exception("Missing start date for employee ID: " . $employee['id']);
            }

            $startYear = date("Y", strtotime($employee['dtStartDate']));
            $yearsInService = $currentYear - $startYear;

            // Add years in service to employee object
            $employee['yearsInService'] = $yearsInService;

            // Group employees by years in service
            if (!isset($groupedEmployees[$yearsInService])) {
                $groupedEmployees[$yearsInService] = [];
            }
            $groupedEmployees[$yearsInService][] = $employee;
        }

        // Sort each group by start date
        foreach ($groupedEmployees as $years => &$employees) {
            usort($employees, function ($a, $b) {
                return strtotime($a['dtStartDate']) - strtotime($b['dtStartDate']);
            });
        }

        return $groupedEmployees;
    } catch (Exception $error) {
        error_log("Error processing employees: " . $error->getMessage());
        return null;
    }
}


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // header('Content-Type: application/json');
    // echo json_encode($data);

    $groupedEmployees = processEmployees($data);
    $html = '<div id="7e705475-5743-4477-a1c7-9165ecf62ddb" class="dash-card wide">
                        <div class="card-content">
                            <div class="component-header">' . date("F") . ' Anniversaries <button class="not-btn" onclick="minimizeCard(\'7e705475-5743-4477-a1c7-9165ecf62ddb\')"> 
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg>
                            </button></div>
                            <div id="anniversariesContent" class="card-content">';
    $html .= '<table class="table">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Years</th>
                </tr>';
    foreach ($groupedEmployees as $years => $employees) {
        $html .= '<tr class="yr' . $years . '"><td colspan="4" class="table-headline">Employees with ' . $years . ' ' . ($years === "1" ? "year" : "years") . ' of service:</td></tr>';

        foreach ($employees as $employee) {
            $html .= '<tr class="emp-card">
                        <td class="name">' .
                (isset($employee['sFirstName']) ? strtolower($employee['sFirstName']) : "Redacted") . ' ' .
                (isset($employee['sLastName']) ? strtolower($employee['sLastName']) : "Classified") . '</td>
                        <td class="name">' .
                (isset($employee['sDepartmentName']) ? $employee['sDepartmentName'] : "Not Assigned") . '</td>
                        <td>' .
                (isset($employee['dtStartDate']) ? parseDateForMonthAndDayOnly($employee['dtStartDate']) : "Poop") . '</td>
                        <td>' .
                (isset($employee['yearsInService']) ? $employee['yearsInService'] : "Oops") . ' years</td>
                    </tr>';
        }
    }

    $html .= '</table>';
    $html .= '</div></div></div>';
    echo $html;
} catch (PDOException $e) {
    echo $e->getMessage();
}
