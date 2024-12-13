<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/12/13 11:04:56
// if (session_status() !== PHP_SESSION_ACTIVE) {
//   session_start();
// }
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
    SELECT
    d.iDepartmentNumber,
    d.sDepartmentName
    FROM
    data_departments d
    WHERE
    d.iDepartmentNumber IN (SELECT au.iDepartmentNumber FROM app_users au);
    END TRY
    BEGIN CATCH
    -- Error handling
    DECLARE @ErrorMessage NVARCHAR(4000);
    DECLARE @ErrorSeverity INT;
    DECLARE @ErrorState INT;

    SELECT
    @ErrorMessage = ERROR_MESSAGE(),
    @ErrorSeverity = ERROR_SEVERITY(),
    @ErrorState = ERROR_STATE();

    -- Log the error or take appropriate action
    RAISERROR(@ErrorMessage, @ErrorSeverity, @ErrorState);
    END CATCH;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($data);
