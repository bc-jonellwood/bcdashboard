<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 11:18:49

include_once "../data/appConfig.php";

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
    // echo "Connection failed: " . $e->getMessage();
}

$sql = "BEGIN TRY
    SELECT au.id
           ,au.sFirstName
           ,au.sLastName
           ,au.dtDateOfBirth
           ,au.bIsActive
           ,dd.sDepartmentName
    FROM app_users au
    JOIN data_departments dd on dd.iDepartmentNumber = au.iDepartmentNumber
    WHERE MONTH(dtDateOFBirth) = MONTH(GETDATE())
      AND dtSeparationDate IS NULL
      AND bIsActive = 1
      AND bHideBirthday = 0
    ORDER BY DAY(dtDateOfBirth) ASC;
END TRY
BEGIN CATCH
    -- Handle the error that you know I made
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT @ErrorMessage = ERROR_MESSAGE(),
           @ErrorSeverity = ERROR_SEVERITY()

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
