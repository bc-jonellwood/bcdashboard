<?php

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
        $this->sEmail                   = !is_null($sEmail) ? $sEmail : NULL;
        $this->sEmployeeNumber          = $sEmployeeNumber;
        $this->sMainPhoneNumber         = !is_null($sMainPhoneNumber) ? trim($sMainPhoneNumber) : NULL;
    }
}

$start_time = microtime(true);
$a = 1;
$output = shell_exec('C:\Windows\System32\WindowsPowerShell\v1.0\powershell.exe -File C:\xampp\htdocs\bcdashboard\data\ad_sync_scripts\echo.ps1');
// var_dump($output);
$array = array();
foreach (preg_split("/((\r?\n)|(\r\n?))/", $output, -1) as $line) {
    $oparray = explode("       ", trim($line));
    if (is_numeric($oparray[0]) && count($oparray) > 2) {
        //var_dump($oparray);
        $array[$oparray[0]][0] = isset($oparray[1]) ? $oparray[1] : NULL;
        $array[$oparray[0]][1] = isset($oparray[2]) ? $oparray[2] : NULL;
        $array[$oparray[0]][2] = isset($oparray[0]) ? $oparray[0] : NULL;
    }
}
echo 'AD Complete<hr/>';
echo "<pre>";
print_r($array);
echo "</pre>";
var_dump(count($array));
if (count($array) >= 0) {
    echo 'AD Count ' . count($array) . '<hr/>';
    die;
}
//die;
include_once "../../data/appConfig.php";

$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

$newUsers = array();
$hittingCount = 0;
$missingCount = 0;
$problemChild = null;
try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($conn === false) {
        echo "To die without love is the true death";
    }
    // update this statement to match the data_employees table and fields.
    $sql = "SELECT [id]
                ,[sEmployeeNumber] 
                ,[sEmail]
                ,[sMainPhoneNumber]
            FROM [dbo].[app_users]
            WHERE iDepartmentNumber != '41403'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $totalRows = $stmt->rowCount();
    while ($singleUser = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $newUser = new newUser(
            $singleUser['sEmployeeNumber'],
            $singleUser['sMainPhoneNumber'],
            $singleUser['sEmail'],
        );
        $newUsers[] = $newUser;
    }
    $conn = null;
} catch (Exception $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    var_dump($e->getTrace());
    die();
}

echo 'Count <br>';
echo nl2br(count($array));
echo "<hr>";
echo 'Hitting Count <br>';
echo nl2br($hittingCount);
echo "<hr>";
echo 'Missing Count <br>';
echo nl2br($missingCount);
echo "<hr>";
$newCount = 0;
$updateCount = 0;
$servername = "192.168.182.210\\INTWWW";
$dbuser = "bcg_intranet";
$dbpass = '*0*JsK&Ax7kdAYciyf7JbYP7ZF';
$dbname = "bcg_intranet";
$conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0;TrustServerCertificate=true", $uid, $pwd);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// $check = "SELECT sEmployeeNumber FROM app_users";
$stmt = $conn->prepare("SELECT sEmployeeNumber FROM app_users");
$stmt->execute();
$existingUsers = $stmt->fetchAll(PDO::FETCH_COLUMN);
// $result = $conn->query($check);
// $foundUsers = $result->fetchAll();
echo "<hr>";
echo 'foundUsers';
echo "<hr>";
// var_dump($foundUsers);
// $existingUsers = array();
// $existingUsers = array_map(function ($userid) {
//     return $userid['sEmployeeNumber'];
// }, $foundUsers);
// unset($foundUsers);
$updateStmt = $conn->prepare("
        UPDATE app_users SET
            sEmail = :email,
            sMainPhoneNumber = NULLIF(:phoneNumber, '')
        WHERE sEmployeeNumber = :employeeNumber
    ");

$insertStmt = $conn->prepare("
        INSERT INTO app_users (
            sEmployeeNumber, sEmail,
            dtLastSystemUpdate, sMainPhoneNumber
        ) VALUES (
            :employeeNumber, :email, :updateDate, :phoneNumber
        )
    ");
$now = date("Y-m-d");
$updateCount = 0;
$newCount = 0;

function nullIfEmpty($value)
{
    return !empty($value) ? $value : null;
}

foreach ($newUsers as $user) {
    $params = [
        ':employeeNumber' => nullIfEmpty($user->sEmployeeNumber),
        ':email' => nullIfEmpty($user->sEmail),
        ':updateDate' => $now,
        ':phoneNumber' => nullIfEmpty($user->sMainPhoneNumber),
    ];
    if (isset($existingUsersBuffered[$user->sEmployeeNumber])) {
        $params[':email'] = nullIfEmpty($user->sEmail);
        $params[':phoneNumber'] = nullIfEmpty($user->sMainPhoneNumber);
        var_dump($params);
        $updateStmt->execute($params);
        $updateCount++;
    } else {
        echo 'Else params';
        echo '<pre>';
        var_dump($params);
        echo '</pre>';

        $insertStmt->execute($params);
        $newCount++;
    }
}

echo "Update: $updateCount, Inserted: $newCount";
