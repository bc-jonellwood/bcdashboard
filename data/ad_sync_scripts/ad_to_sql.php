<?php
// Created: 2024/11/04 15:59:29
// Last Modified: 2024/12/20 16:02:14

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
// $output = shell_exec('C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -File C:\xampp\htdocs\bcdashboard\data\ad_sync_scripts\echo.ps1');
// assign the contents of file emps.txt to $output
$output = file_get_contents('http://myberkeley.berkeleycountysc.gov/data/ad_sync_scripts/emps.txt');
// var_dump($output);
$employeeArray = array();
foreach (preg_split("/((\r?\n)|(\r\n?))/", $output, -1) as $line) {
    $line = trim($line, '"');
    $oparray = explode('","', $line);
    // print_r($line);
    if (is_numeric($oparray[0]) && count($oparray) == 5) {
        // echo "<pre>";
        // echo "<p>oparray yes</p>";
        // var_dump($oparray);
        // echo "</pre>";
        $employeeArray[$oparray[0]][0] = isset($oparray[1]) ? $oparray[1] : NULL;
        $employeeArray[$oparray[0]][1] = isset($oparray[0]) ? $oparray[0] : NULL;
        $phoneNumber = $oparray[2];
        $employeeArray[$oparray[0]][2] = preg_match('/^\d{3}-\d{3}-\d{4}$/', $phoneNumber) ? $phoneNumber : NULL;
        $accStatus = $oparray[4];
        $employeeArray[$oparray[0]][3] = $accStatus ? $accStatus : NULL;
        $mobileNumber = $oparray[3];
        $employeeArray[$oparray[0]][4] = preg_match('/^\d{3}-\d{3}-\d{4}$/', $mobileNumber) ? $mobileNumber : NULL;
    }
}
echo 'AD Complete

<hr />';
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
//die;
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
    $checkEmployeeStmt = $conn->prepare("SELECT sEmployeeNumber FROM app_users  WHERE sEmployeeNumber = ?");

    $updateByEmployeeStmt = $conn->prepare("UPDATE app_users SET sEmail = ?, sMainPhoneNumber = ?, sADStatus = ?, sSecondaryPhoneNumber = ? WHERE sEmployeeNumber = ?");

    $insertStmt = $conn->prepare("INSERT INTO data_ad_scripted_data (sEmployeeNumber, sEmail, sMainPhoneNumber, sAccStatus) VALUES (?, ?, ?, ?)");
    $conn->beginTransaction();

    foreach ($employeeArray as $sEmployeeNumber => $data) {
        echo "<pre>";
        print_r($data);
        $email = $data[0];
        // echo "Email : $email\n";
        $sEmployeeNumber = $data[1];
        // echo "Employee Number : $sEmployeeNumber\n";
        $mainPhoneNumber = $data[2];
        // echo "Phone : $mainPhoneNumber\n";
        $accStatus = $data[3];
        // echo "Status : $accStatus\n";
        $sSecondaryPhoneNumber = $data[4];
        // echo "Secondary Phone : $sSecondaryPhoneNumber\n";
        $checkEmployeeStmt->execute([$sEmployeeNumber]);
        $employeeExists = $checkEmployeeStmt->fetch(PDO::FETCH_ASSOC);

        if ($employeeExists) {
            // echo "Email : $email\n";
            // echo "Phone : $mainPhoneNumber\n";
            // echo "Status : $accStatus\n";
            // echo "Secondary Phone : $sSecondaryPhoneNumber\n";
            $updateByEmployeeStmt->execute([$email, $mainPhoneNumber, $accStatus, $sSecondaryPhoneNumber, $sEmployeeNumber]);
        } else {
            echo "Ding Dong Ding Dong";
            // $insertStmt->execute([$sEmployeeNumber, $email, $mainPhoneNumber, $accStatus]);
            // echo "<pre>";
            // echo "Added : $sEmployeeNumber\n";
            // echo "</pre>";
        }
    }
    $conn->commit();
    echo "All good";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
