<?php
// Created: 2024/11/04 15:59:29
// Last Modified: 2025/01/02 11:32:00

class newUser
{
    public $sPreferredName;
    public $sFirstName;
    public $sMiddleName;
    public $sLastName;
    public $sEmail;
    public $sEmployeeNumber;
    public $dtStartDate;
    public $dtDateOfBirth;
    public $iDepartmentNumber;
    public $dtSeparationDate;
    public $birthdayExempt;
    public $sMainPhoneNumber;
    public $sSecondaryPhoneNumber;
    public $bIsActive;
    public $bIsLDAP;
    public $bHideBirthday;
    public $bIsAdmin;

    public function __construct(
        $sEmployeeNumber,
        $sMainPhoneNumber,
        $sEmail,
        $sSecondaryPhoneNumber,
    ) {
        $this->sEmail = !is_null($sEmail) ? $sEmail : NULL;
        $this->sEmployeeNumber = $sEmployeeNumber;
        $this->sMainPhoneNumber = !is_null($sMainPhoneNumber) ? trim($sMainPhoneNumber) : NULL;
        $this->sSecondaryPhoneNumber = !is_null($sSecondaryPhoneNumber) ? trim($sSecondaryPhoneNumber) : NULL;
    }
}

$start_time = microtime(true);
$a = 1;
$output = shell_exec('C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -File C:\xampp\htdocs\bcdashboard\data\ad_sync_scripts\echo.ps1');
if ($output) {
    $users = json_decode($output, true);
    // print_r($users);
} else {
    echo "No output from the PoweShell Script";
}
// assign the contents of file emps.txt to $output
// $output = file_get_contents('http://myberkeley.berkeleycountysc.gov/data/ad_sync_scripts/emps.txt');
// var_dump($output);
// echo "<pre>";
// print_r($users);
// echo "</pre>";

function processActiveDirectoryData($users)
{
    $employeeArray = [];

    if (is_array($users)) {
        foreach ($users as $user) {
            // validate each entry
            $employeeID = isset($user['EmployeeID']) && is_numeric($user['EmployeeID']) ? $user['EmployeeID'] : null;
            $emailAddress = isset($user['EmailAddress']) && filter_var($user['EmailAddress'], FILTER_VALIDATE_EMAIL) ? $user['EmailAddress'] : null;
            $officePhone = isset($user['OfficePhone']) && preg_match('/^\d{3}-\d{3}-\d{4}$/', $user['OfficePhone']) ? $user['OfficePhone'] : null;
            $mobile = isset($user['mobile']) && preg_match('/^\d{3}-\d{3}-\d{4}$/', $user['mobile']) ? $user['mobile'] : null;
            $accountStatus = isset($user['AccountStatus']) ? $user['AccountStatus'] : null;

            if ($employeeID !== null) {
                $employeeArray[$employeeID] = [
                    'EmailAddress' => $emailAddress,
                    'OfficePhone' => $officePhone,
                    'mobile' => $mobile,
                    'AccountStatus' => $accountStatus
                ];
            }
        }
    } else {
        echo 'Error decoding JSON data';
    }
    return $employeeArray;
}

// foreach (preg_split("/((\r?\n)|(\r\n?))/", $output, -1) as $line) {
//     $line = trim($line, '"');
//     $oparray = explode('","', $line);
//     // print_r($line);
//     // print_r($oparray);
//     if (is_numeric($oparray[0]) && count($oparray) == 5) {
//         // echo "<pre>";
//         // echo "<p>oparray yes</p>";
//         // var_dump($oparray);
//         // echo "</pre>";
//         $employeeArray[$oparray[0]][0] = isset($oparray[1]) ? $oparray[1] : NULL;
//         $employeeArray[$oparray[0]][1] = isset($oparray[0]) ? $oparray[0] : NULL;
//         $phoneNumber = $oparray[2];
//         $employeeArray[$oparray[0]][2] = preg_match('/^\d{3}-\d{3}-\d{4}$/', $phoneNumber) ? $phoneNumber : NULL;
//         $accStatus = $oparray[4];
//         $employeeArray[$oparray[0]][3] = $accStatus ? $accStatus : NULL;
//         $mobileNumber = $oparray[3];
//         $employeeArray[$oparray[0]][4] = preg_match('/^\d{3}-\d{3}-\d{4}$/', $mobileNumber) ? $mobileNumber : NULL;
//     }
// }
// echo 'AD Fetch Complete';
$employeeArray = processActiveDirectoryData($users);
// print_r($employeeArray);

// echo "<pre>";
// echo "<p>There should be data in here!</p>";
// print_r($employeeArray);
// echo "</pre>";
var_dump(count($employeeArray));
if (count($employeeArray) == 0) {
    echo 'AD Count ' . count($employeeArray) . '
    <hr />';
    die;
}
// die;
include_once "../../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
try {
    $checkEmployeeStmt = $conn->prepare("SELECT sEmployeeNumber FROM app_users WHERE sEmployeeNumber = ?");
    $updateByEmployeeStmt = $conn->prepare("UPDATE app_users SET sEmail = ?, sMainPhoneNumber = ?, bIsActive = ?, sADStatus = ?, sSecondaryPhoneNumber = ? WHERE sEmployeeNumber = ?");
    $insertStmt = $conn->prepare("INSERT INTO app_users (sEmployeeNumber, sEmail, sMainPhoneNumber, sSecondaryPhoneNumber, sADStatus) VALUES (?, ?, ?, ?, ?)");

    $conn->beginTransaction();

    foreach ($employeeArray as $sEmployeeNumber => $data) {
        // Extract data from the employee array
        $email = $data['EmailAddress'];
        $mainPhoneNumber = $data['OfficePhone'];
        $sSecondaryPhoneNumber = $data['mobile'];
        $accStatus = $data['AccountStatus'];

        // Check if the employee already exists in the database
        $checkEmployeeStmt->execute([$sEmployeeNumber]);
        $employeeExists = $checkEmployeeStmt->fetch(PDO::FETCH_ASSOC);

        if ($employeeExists) {
            // Update existing record
            $updateByEmployeeStmt->execute([$email, $mainPhoneNumber, $accStatus, $accStatus, $sSecondaryPhoneNumber, $sEmployeeNumber]);
        } else {
            // Insert new record
            // $insertStmt->execute([$sEmployeeNumber, $email, $mainPhoneNumber, $sSecondaryPhoneNumber, $accStatus]);
            echo "<pre>User Not Found in Database: $sEmployeeNumber</pre>";
        }
    }
    $conn->commit();
    echo "All good";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
