<?php
// Created: 2024/10/09 10:44:51
// Last modified: 2024/11/06 11:24:31

require_once '../data/appConfig.php';
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

function splitName($name)
{
    $fName = '';
    $lName = '';

    if (empty($name)) {
        throw new Exception('Name cannot be empty');
    }
    $nameParts = explode(' ', trim($name));

    $fName = $nameParts[0];
    if (count($nameParts) > 1) {
        $lName = $nameParts[1];
    }
    return ['fName' => $fName, 'lName' => $lName];
}


$inputName = $_GET['name'];
// print_r($inputName);
$result = splitName($inputName);
$fName = $result['fName'];
$lName = $result['lName'];
// print_r($fName);
// print_r($lName);


$data = array();

$sql = "SELECT e.sFirstName, e.sLastName, e.sMainPhoneNumber, d.sDepartmentName FROM data_employees e
JOIN data_departments d ON e.iDepartmentNumber = d.iDepartmentNumber
WHERE e.dtSeparationDate is NULL AND e.sFirstName LIKE '%$fName%' OR e.sLastName LIKE '%$fName%'";

try {
    $stmt = $conn->prepare($sql);
    // $stmt->bindValue(':fName', "%$fName%", PDO::PARAM_STR);

    if (!empty($lName)) {
        $sql .= " OR e.sFirstName LIKE '%lName%' OR e.sLastName LIKE '%lName%'";
        $stmt = $conn->prepare($sql);
        // $stmt->bindValue(':lName', "%$lName%", PDO::PARAM_STR);
    }
    // print_r($sql);

    $stmt->execute();
    // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach ($row as $key => $value) {
            $row[$key] = trim($value);
        }
        array_push($data, $row);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
