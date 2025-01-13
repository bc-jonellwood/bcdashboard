<?php
// Created: 2025/01/13 12:13:27
// Last modified: 2025/01/13 14:25:49

// session_start();
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
require_once '../auth/UserAuth.php';
require_once '../classes/User.php';
$auth = new UserAuth();
$user = new User();

function logError($message)
{
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $logFile = $logDir . '/error_log.txt';
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




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $newPassword = $_POST['newPassword'] ?? null;

    // Validate required fields
    if (!$username || !$password || !$newPassword) {
        echo "All fields are required.";
        exit;
    }

    // Check if the username exists
    // might not need this as it is already checked in the auth class
    // if (!$user->checkUserNameExists($username)) {
    //     echo "User does not exist.";
    //     exit;
    // }

    // Check LDAP or password
    $isUserLDAP = $auth->checkIsUserLDAP($username, $password);

    switch ($isUserLDAP['status']) {
        case 'USER_NOT_FOUND':
            $errMsg = "User " . $username . " was not found.";
            // echo "User does not exist.";
            break;
        case 'IS_LDAP':
            $errMsg = "User " . $username . " should validate via LDAP.";
            // echo "User should authenticate via LDAP.";
            break;
        case 'PASSWORD_CORRECT':
            $auth->updatePassword($username, $newPassword);
            $errMsg = "Password updated successfully. </br> <a href='/ua/index.php' class='btn btn-primary'>Back to User Mgmt</a>";
            //echo "Password updated successfully.";
            break;
        case 'PASSWORD_INCORRECT':
            $errMsg = "The current password you entered is incorrect.";
            // echo "The current password you entered is incorrect.";
            break;
    }

    // if ($isUserLDAP === true) {
    //     // Update password for non-LDAP users
    //     $auth->updatePassword($username, $newPassword);
    //     echo "Password updated successfully.";
    // } elseif ($isUserLDAP === false) {
    //     echo "Use LDAP credentials to update the password or the current password you entered in incorrect.";
    // } else {
    //     echo "An error occurred during authentication.";
    //     logError("Unexpected return value from checkIsUserLDAP for user '$username'.");
    // }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/styles/reset.css">
    <link rel="stylesheet" href="/styles/custom.css">
    <link rel="stylesheet" href="/styles/theme.css"> -->
    <link rel="stylesheet" type="text/css" href="users.css">
    <link rel="icon" href="/favicons/favicon-16x16.png">
</head>

<body>
    <div class="main">
        <div class="content">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Username" class="form-control" required onchange="checkIfUserNameExists(this.value)">
                </div>
                <div class="form-group">

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" placeholder="New Password" class="form-control" required>
                </div>
                <input type="submit" id="submit" value="Update Password" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-success" onclick="clearErrors()">
            </form>
            <a href="/ua/index.php" class="btn btn-warning">Cancel</a>
            <!-- <a href="/auth/index.php" class="btn btn-primary"> To Log In</a> -->
            <div class="error" id="error">
                <?php if (isset($errMsg)) echo $errMsg; ?>
            </div>
        </div>
    </div>
</body>
<script>
    function checkIfUserNameExists($username) {
        var errorMessageHolder = document.getElementById("error");
        var submitBtn = document.getElementById("submit");
        fetch("/API/checkUserNameExists.php?username=" + $username)
            .then(response => response.text())
            .then(data => {
                if (data == 1) {
                    errorMessageHolder.innerHTML = "";
                    submitBtn.disabled = false;
                } else {
                    errorMessageHolder.innerHTML = "Username does not exist";
                    submitBtn.disabled = true;
                }
            })
    }

    function clearErrors() {
        var errorMessageHolder = document.getElementById("error");
        var submitBtn = document.getElementById("submit");
        errorMessageHolder.innerHTML = "";
        submitBtn.disabled = false;
    }
</script>

</html>
<style>
    form {
        background-color: var(--bg);
    }

    .form-group {
        margin-top: 20px;
    }

    .form-group:last-of-type {
        margin-bottom: 20px;
    }

    .error {
        width: 100%;
        text-align: center;
        color: red;
        font-weight: bold;
        font-size: xx-large;
        margin-top: 80px;

    }
</style>