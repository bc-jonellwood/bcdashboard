<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/23 14:10:57

include_once "./data/appConfig.php";

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
    // echo "Connection failed: " . $e->getMessage();
}

$sql = "BEGIN TRY
    SELECT de.id
           ,de.sFirstName
           ,de.sLastName
           ,de.dtDateOfBirth
           ,de.bActive
           ,dd.sDepartmentName
    FROM data_employees de
    JOIN data_departments dd on dd.iDepartmentNumber = de.iDepartmentNumber
    WHERE MONTH(dtDateOFBirth) = MONTH(GETDATE())
      AND dtSeparationDate IS NULL
      AND bActive = 1
    ORDER BY DAY(dtDateOfBirth) ASC;
END TRY
BEGIN CATCH
    -- Handle the error that you know I made
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT @ErrorMessage = ERROR_MESSAGE(),
           @ErrorSeverity = ERROR_SEVERITY(),
           @ErrorState = ERROR_STATE();

    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;";
$nextSql = "
BEGIN TRY
    SELECT de.id
           ,de.sFirstName
           ,de.sLastName
           ,de.dtDateOfBirth
           ,de.bActive
           ,dd.sDepartmentName
    FROM data_employees de
    JOIN data_departments dd on dd.iDepartmentNumber = de.iDepartmentNumber
    WHERE MONTH(dtDateOFBirth) = MONTH(DATEADD(MONTH, 1, GETDATE()))
      AND dtSeparationDate IS NULL
      AND bActive = 1
    ORDER BY DAY(dtDateOfBirth) ASC;
END TRY
BEGIN CATCH
    -- Handle the error that you know I made
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT @ErrorMessage = ERROR_MESSAGE(),
           @ErrorSeverity = ERROR_SEVERITY(),
           @ErrorState = ERROR_STATE();

    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
END CATCH;";
try {
    $nextStmt = $conn->prepare($nextSql);
    $nextStmt->execute();
    $nextData = $nextStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // header('Content-Type: application/json');
    // echo json_encode($data);
    $html = '<div id="a315fae2-3716-49f8-a076-95ddef2313b4" class="dash-card wide">
                <div class="card-content">
                    <div class="component-header">Employee Birthdays <button class="not-btn" onclick="minimizeCard(\'a315fae2-3716-49f8-a076-95ddef2313b4\')"><img src="./icons/resize.svg" alt="resize" width="24" height="24" /></button></div>
                    <div class="component-header-tabs" id="component-header-tabs">
                        <div class="component-header active" id="birthdayTabOne"><button class="not-btn" onclick="swapTabs(\'birthdayTab1\')">' . date("F") . ' birthdays </button></div>
                        <div class="component-header" id="birthdayTabTwo"><button class="not-btn" onclick="swapTabs(\'birthdayTab2\')">' . date("F", strtotime("+1 month")) . ' birthdays</button>
                        </div>
                    </div>';
    $html .= '<div id="birthdaysContent" class="card-content">
                <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Birthday</th>
                </tr>';

    foreach ($data as $row) {
        $html .= '<tr class="emp-card">
                    <td class="name">' . (isset($row['sFirstName']) ? strtolower($row['sFirstName']) : '')  . ' ' . (isset($row['sLastName']) ? strtolower($row['sLastName']) : '') . '</td> 
                    <td class="name">' . (isset($row['sDepartmentName']) ? $row['sDepartmentName'] : '') . '</td>
                    <td>' . (isset($row['dtDateOfBirth']) ? date('m/d/Y', strtotime($row['dtDateOfBirth'])) : '') . '</td>
                </tr>';
    }

    $html .= '</table>';
    $html .= '</div>
                <div id="nextBirthdaysContent" class="card-content hidden">
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Birthday</th>
                        </tr>';

    foreach ($nextData as $row) {
        $html .= '<tr class="emp-card">
                    <td class="name">' . (isset($row['sFirstName']) ? strtolower($row['sFirstName']) : '')  . ' ' . (isset($row['sLastName']) ? strtolower($row['sLastName']) : '') . '</td> 
                    <td class="name">' . (isset($row['sDepartmentName']) ? $row['sDepartmentName'] : '') . '</td>
                    <td>' . (isset($row['dtDateOfBirth']) ? date('m/d/Y', strtotime($row['dtDateOfBirth'])) : '') . '</td>
                </tr>';
    }

    $html .= '</table>';
    $html .= '</div>
                </div>
            </div>
        
    ';

    echo $html;
} catch (PDOException $e) {
    echo $e->getMessage();
}
