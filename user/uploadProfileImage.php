<?php
// Created: 2025/01/09 13:44:13
// Last modified: 2025/01/09 15:03:20
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
include(dirname(__FILE__) . '/../classes/User.php');

// $user = new User();
// // get user Id and image from POST method

// $uploadDir = '/uploads/photos/profile/';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $userID = $_POST['userID'];

//     if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] ===  UPLOAD_ERR_OK) {
//         $fileTmpPath = $_FILES['profileImage']['tmp_name'];
//         $fileName = $_FILES['profileImage']['name'];
//         $fileType = $_FILES['profileImage']['type'];

//         $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

//         $allowedExtensions = ['jpg', 'jpeg', 'png'];
//         if (!in_array($fileExtension, $allowedExtensions)) {
//             die("Error: Unsupported file type. Allowed types: " . implode(", ", $allowedExtensions));
//         }

//         $newFileName = $userID . '.' . $fileExtension;

//         $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $newFileName;

//         if (move_uploaded_file($fileTmpPath, $destinationPath)) {
//             $profileImagePath = $uploadDir . $newFileName;
//             if ($user->updateUser($userID, 'sProfileImage', $profileImagePath)) {
//                 logError('File uploaded and user profile updated successfully');
//             } else {
//                 logError('Error: Failed to update user profile in the database');
//             }
//         } else {
//             logError('Error: Failed to move the uploaded file.');
//         }
//     } else {
//         logError('Error: No file uploaded or an error occurred');
//     }
// }
// <?php
// Include your User class
// require_once 'User.php';

// Initialize User object
$user = new User();

// Define upload directory
$uploadDir = '/uploads/photos/profile/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the form
    $userID = $_POST['userID'];

    // Check if the file input exists and no upload errors occurred
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];

        // Extract file extension
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validate file extension (e.g., allow only images)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Error: Unsupported file type. Allowed types: " . implode(", ", $allowedExtensions));
        }

        // Create a new filename based on the user ID and file extension
        $newFileName = $userID . '.' . $fileExtension;

        // Define the full path to save the file
        $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $newFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $destinationPath)) {
            // Update the user record in the database
            $field = 'sProfileImgPath';
            $profileImagePath = $uploadDir . $newFileName; // Relative path
            if ($user->updateUser($userID, $field, $profileImagePath)) {
                logError("File uploaded and user profile updated successfully.");
                header("Location: ../index.php");
            } else {
                logError("Error: Failed to update user profile in the database.");
            }
        } else {
            logError("Error: Failed to move the uploaded file.");
        }
    } else {
        // Handle file upload errors
        switch ($_FILES['profileImage']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                logError("Error: File size exceeds the allowed limit.");
                break;
            case UPLOAD_ERR_PARTIAL:
                logError("Error: File was only partially uploaded.");
                break;
            case UPLOAD_ERR_NO_FILE:
                logError("Error: No file was uploaded.");
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                logError("Error: Missing a temporary folder.");
                break;
            case UPLOAD_ERR_CANT_WRITE:
                logError("Error: Failed to write file to disk.");
                break;
            case UPLOAD_ERR_EXTENSION:
                logError("Error: A PHP extension stopped the file upload.");
                break;
            default:
                logError("Error: An unknown error occurred.");
        }
    }
}
