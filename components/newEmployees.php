<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 11:05:05
require_once './data/appConfig.php';
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

// $sql = "SELECT *
// FROM `emp_ref`
// WHERE seperation_date BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
//                           AND DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
// ORDER BY seperation_date DESC";
$data = [];
$sql = "SELECT au.sFirstName, au.sLastName, au.sMainPhoneNumber, dd.sDepartmentName, au.dtStartDate FROM app_users au
JOIN data_departments dd ON au.iDepartmentNumber = dd.iDepartmentNumber
WHERE dtStartDate BETWEEN DATEADD(DAY, -21, CAST(GETDATE() AS DATE))
                           AND DATEADD(DAY, 21, CAST(GETDATE() AS DATE))
ORDER BY dtStartDate DESC";


try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($data) > 0) {
        echo '<div id="a05ca0c4-c518-4692-a363-093a7a5f5af6" class="dash-card medWide short">';
        echo '<div class="card-content">
            <div class="component-header">Recent Hires <button class="not-btn" onclick="minimizeCard(\'a05ca0c4-c518-4692-a363-093a7a5f5af6\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>
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
    } else {
        echo '<div id="a05ca0c4-c518-4692-a363-093a7a5f5af6" class="dash-card narrow square">';
        echo '<div class="card-content">';
        echo '<div class="component-header">Recent Hires <button class="not-btn" onclick="minimizeCard(\'a05ca0c4-c518-4692-a363-093a7a5f5af6\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>';
        echo '<p>No hires within the 14 day window.</p>';
        echo '</div>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// header('Content-Type: application/json');
// echo json_encode($data);
