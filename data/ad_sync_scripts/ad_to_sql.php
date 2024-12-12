<?php
// Created: 2024/11/04 15:59:29
// Last Modified: 2024/12/12 13:58:45

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
    public $bIsActive;
    public $bIsLDAP;
    public $bHideBirthday;
    public $bIsAdmin;

    public function __construct(
        $sEmployeeNumber,
        $sMainPhoneNumber,
        $sEmail,
    ) {
        $this->sEmail = !is_null($sEmail) ? $sEmail : NULL;
        $this->sEmployeeNumber = $sEmployeeNumber;
        $this->sMainPhoneNumber = !is_null($sMainPhoneNumber) ? trim($sMainPhoneNumber) : NULL;
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
    if (is_numeric($oparray[0]) && count($oparray) == 4) {
        // echo "<pre>";
        // echo "<p>oparray yes</p>";
        // var_dump($oparray);
        // echo "</pre>";
        $employeeArray[$oparray[0]][0] = isset($oparray[1]) ? $oparray[1] : NULL;
        $employeeArray[$oparray[0]][1] = isset($oparray[0]) ? $oparray[0] : NULL;
        $phoneNumber = $oparray[2];
        $employeeArray[$oparray[0]][2] = preg_match('/^\d{3}-\d{3}-\d{4}$/', $phoneNumber) ? $phoneNumber : NULL;
        $accStatus = $oparray[3];
        $employeeArray[$oparray[0]][3] = $accStatus ? $accStatus : NULL;
    }
}
echo 'AD Complete

<hr />';
echo "<pre>";
// echo "<p>There should be data in here!</p>";
print_r($employeeArray);
echo "</pre>";
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
    $checkEmployeeStmt = $conn->prepare("SELECT sEmployeeNumber, sEmail, sMainPhoneNumber FROM data_ad_scripted_data  WHERE sEmployeeNumber = ?");

    $updateByEmployeeStmt = $conn->prepare("
            UPDATE data_ad_scripted_data 
            SET sEmail = ?, sMainPhoneNumber = ?, sAccStatus = ? 
            WHERE sEmployeeNumber = ?
        ");

    $insertStmt = $conn->prepare("
            INSERT INTO data_ad_scripted_data 
            (sEmployeeNumber, sEmail, sMainPhoneNumber, sAccStatus) 
            VALUES (?, ?, ?, ?)
        ");
    $conn->beginTransaction();

    foreach ($employeeArray as $sEmployeeNumber => $data) {
        $email = $data[0];
        // echo "Email : $email\n";
        $mainPhoneNumber = $data[2];
        $sEmployeeNumber = $data[1];
        $accStatus = $data[3];
        $checkEmployeeStmt->execute([$sEmployeeNumber]);
        $employeeExists = $checkEmployeeStmt->fetch(PDO::FETCH_ASSOC);

        if ($employeeExists) {
            $updateByEmployeeStmt->execute([$email, $mainPhoneNumber, $accStatus, $sEmployeeNumber]);
            // echo "<pre>";
            // echo "Updated : $sEmployeeNumber\n";
            // echo "Email : $email\n";
            // echo "Phone : $mainPhoneNumber\n";
            // echo "Status : $accStatus\n";
            // echo "<br>";
            // echo "</pre>";
        } else {
            $insertStmt->execute([$sEmployeeNumber, $email, $mainPhoneNumber, $accStatus]);
            echo "<pre>";
            echo "Added : $sEmployeeNumber\n";
            echo "</pre>";
        }
    }
    $conn->commit();
    echo "All good";
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}
