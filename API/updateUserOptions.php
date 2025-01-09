<?php
// Created: 2025/01/09 09:23:29
// Last modified: 2025/01/09 10:02:26

function logError($message)
{
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $logFile = $logDir . '/api_error_log.txt';
    $currentDate = date('Y-m-d H:i:s');
    $logMessage = "[$currentDate] $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    $message = "Error [$errno] on line $errline in file $errfile: $errstr";
    logError($message);
    return false; // Let the default error handler handle the error as well
});

set_exception_handler(function ($exception) {
    $message = "Uncaught exception: " . $exception->getMessage();
    logError($message);
    return false; // Let the default exception handler handle the exception as well
});

include "dbheader.php";
$id = $_GET['id'];
// logError($id);

$options = $_GET['options'] ?? '';
// $options = json_decode($options, true);
logError(gettype($options) . ' ' . $options);
// logError($options);
$startPos = strpos($options, '[');
if ($startPos === false) {
    logError("Invalid options format: $options");
    exit;
}

$jsonPart = substr($options, $startPos);

$optionsArray = json_decode($jsonPart, true);

if (!is_array($optionsArray)) {
    logError("Failed to decode JSON: $options");
    exit;
}

try {


    foreach ($optionsArray as $item) {
        foreach ($item as $key => $value) {
            // Sanitize key and value
            $key = preg_replace('/[^a-zA-Z0-9_]/', '', $key); // Only allow alphanumeric and underscores in keys
            // $value = $conn->real_escape_string($value); // Escape value for SQL

            $sql = "UPDATE app_users set $key = :value WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);

            $stmt->execute();
        }
    }
} catch (PDOException $e) {
    logError('Database Error: ' . $e->getMessage());
}
