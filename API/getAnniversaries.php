<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/16 11:43:16

include_once "../data/appConfig.php";

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
           ,de.dtStartDate
           ,de.bActive
           ,dd.sDepartmentName
    FROM data_employees de
    JOIN data_departments dd on dd.iDepartmentNumber = de.iDepartmentNumber
    WHERE MONTH(dtStartDate) = MONTH(GETDATE())
      AND YEAR(dtStartDate) != YEAR(GETDATE())
      AND dtSeparationDate IS NULL
      AND bActive = 1
    ORDER BY dtStartDate ASC;
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
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo $e->getMessage();
}
