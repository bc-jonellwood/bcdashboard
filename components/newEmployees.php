<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/21 15:34:08
require_once './data/appConfig.php';
$dbconf = new appConfig;
$serverName = $dbconf->serverName;
$database = $dbconf->database;
$uid = $dbconf->uid;
$pwd = $dbconf->pwd;

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database;ConnectionPooling=0", $uid, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// $sql = "SELECT *
// FROM `emp_ref`
// WHERE seperation_date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
//                           AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
// ORDER BY seperation_date DESC";
$data = [];
$sql = "SELECT e.sFirstName, e.sLastName, e.sMainPhoneNumber, d.sDepartmentName, e.dtStartDate FROM data_employees e
JOIN data_departments d ON e.iDepartmentNumber = d.iDepartmentNumber
WHERE dtStartDate BETWEEN DATEADD(DAY, -7, CAST(GETDATE() AS DATE))
                           AND DATEADD(DAY, 7, CAST(GETDATE() AS DATE))
ORDER BY dtStartDate DESC";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<div id="recentSeparations" class="dash-card">';
    echo '<div class="card-content">
            <div class="component-header">Recent Separations</div>
            <div id="recentHiredContent" class="card-content">
            ';
    echo '<table class="table"><tbody><tr><th>Name</th><th>Department</th><th>Start Date</th></tr>';
    foreach ($data as $row) {
        echo '<tr class="emp-card">';
        echo '<td class="name">' . strtolower($row['sFirstName'] . ' ' . $row['sLastName']) . '</td>';
        echo '<td class="name">' . strtolower($row['sDepartmentName']) . '</td>';
        echo '<td>' . date('m/d/Y', strtotime($row['dtStartDate'])) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>
            </div>
            </div>
            </div>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// header('Content-Type: application/json');
// echo json_encode($data);
