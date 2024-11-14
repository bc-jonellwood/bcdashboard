<?php
// Created: 2024/10/21 15:14:49
// Last modified: 2024/11/06 13:50:59
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

$data = [];
$sql = "SELECT e.sFirstName, e.sLastName, e.sMainPhoneNumber, d.sDepartmentName, e.dtSeparationDate FROM data_employees e
JOIN data_departments d ON e.iDepartmentNumber = d.iDepartmentNumber
WHERE dtSeparationDate BETWEEN DATEADD(DAY, -7, CAST(GETDATE() AS DATE))
                           AND DATEADD(DAY, 7, CAST(GETDATE() AS DATE))
ORDER BY dtSeparationDate DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<div id="350e8ab0-a00c-4484-b42c-320670ec6d76" class="dash-card">';
    echo '<div class="card-content">
            <div class="component-header">Recent Separations <button class="not-btn" onclick="minimizeCard(\'350e8ab0-a00c-4484-b42c-320670ec6d76\')"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="recolor" width="24" height="24"><path d="M10.59,12L14.59,8H11V6H18V13H16V9.41L12,13.41V16H20V4H8V12H10.59M22,2V18H12V22H2V12H6V2H22M10,14H4V20H10V14Z" /></svg></button></div>
            <div id="recentSeparationsContent" class="card-content">
            ';
    echo '<table class="table"><tbody><tr><th>Name</th><th>Department</th><th>Separated Date</th></tr>';
    foreach ($data as $row) {
        echo '<tr class="emp-card">';
        echo '<td class="name">' . strtolower($row['sFirstName'] . ' ' . $row['sLastName']) . '</td>';
        echo '<td class="name">' . strtolower($row['sDepartmentName']) . '</td>';
        echo '<td>' . date('m/d/Y', strtotime($row['dtSeparationDate'])) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table>
            </div>
            </div>
            </div>';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}