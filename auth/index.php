<?php
// Created: 2024/12/13 08:09:15
// Last modified: 2025/01/08 11:00:50
session_start();
require_once 'UserAuth.php';
// require_once(dirname(__FILE__) . '../classes/Session.php');
// init the UserAuth class  
$auth = new UserAuth();
// $session = new CustomSessionHandler();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // $CustomSessionHandler->writeData($session_id, $_SESSION['userID']);
    header("Location: ../index.php");
    exit;
} elseif (isset($_COOKIE['rememberme'])) {
    $cookie_data = json_decode($_COOKIE['rememberme'], true);
    logError("Cookie data: " . print_r($cookie_data, true));
    logError("Cookie username: " . $cookie_data['username']);
    $userData = $auth->checkUser($cookie_data['username']);
    if ($userData) {
        // $CustomSessionHandler->writeData($session_id, $_SESSION['userID']);
        // $_SESSION['loggedin'] = true;
        // $_SESSION['loggedinuser'] = $cookie_data['username'];
        logError("User logged in from cookie: " . $cookie_data['username']);
        header("Location: ../index.php");
        exit;
    }
}

$loginfailure = false;

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

function handleLogin()
{
    global $loginfailure, $loginfailuremessage, $auth;
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Debugging statement
        logError("Login attempt for user: $username");
        if ($auth->validateCredentials($username, $password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['loggedinuser'] = $_POST['username'];
            logError("User ldap logged in: $username");
            $userData = $auth->checkUser($_SESSION['loggedinuser']);
            if ($userData) {
                logError("User db is valid: $username");
                if ($auth->logLogin()) {
                    if ($auth->checkEntryCount() && $auth->checkCardAccessCount() && $auth->checkSidenavItemCount()) {
                        header("Location: ../index.php");
                        exit;
                    } else {
                        $loginfailuremessage = "Failed to check entry count or check Card Accss Count or check Sidenav Item Count.";
                        logError("Failed to check entry count for user: $username");
                    }
                } else {
                    $loginfailuremessage = "Failed to log login time.";
                    logError("Failed to log login time for user: $username");
                }
            } else {
                $loginfailure = true;
                $loginfailuremessage = "Invalid username or password.";
                logError("Invalid username or password for user: $username");
            }
        } else {
            $loginfailure = true;
            $_SESSION['loggedin'] = false;
            unset($_SESSION['loggedinuser']);
            $loginfailuremessage = "Invalid credentials.";
            logError("Invalid credentials for user: $username");
        }
    } else {
        $loginfailure = true;
        $loginfailuremessage = "Please enter username and password.";
        logError("Username or password not provided.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging statement
    logError("POST request received");
    handleLogin();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myBerkeley Signin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../styles/reset.css">
    <link rel="stylesheet" href="../styles/custom.css">
    <link rel="stylesheet" href="../styles/theme.css">
    <link rel="stylesheet" href="auth.css">
    <link rel="icon" href="../favicons/favicon-32x32.png">
</head>

<body>
    <div class="login-container">
        <div class="login-main">
            <div class="login-header">
                <img src="../images/myBerkeley1-white.png" alt="my berkeley logo" class="login-logo">
            </div>
            <form method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="current-password" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="rememberme" name="rememberme" class="form-check-input" checked>
                    <label for="rememberme" class="form-check-label">Remember Me</label>
                </div>
                <input type="submit" value="Sign In" class="btn btn-primary">
            </form>
            <?php
            if ($loginfailure) {
                echo "<p style='color:red;'>Login failed: $loginfailuremessage</p>";
            }
            // print_r($_SESSION);
            ?>
            <p class="login-form-footer">Don't have an account? <a href="mailto:dashboard@berkeleycountysc.gov">Request One</a></p>
        </div>
    </div>
    <footer class="login-footer">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
            <path fill="#E3E3E3" d="M10 .4A9.6 9.6 0 0 0 .4 10a9.6 9.6 0 1 0 19.2-.001C19.6 4.698 15.301.4 10 .4m-.151 15.199h-.051c-.782-.023-1.334-.6-1.311-1.371c.022-.758.587-1.309 1.343-1.309l.046.002c.804.023 1.35.594 1.327 1.387c-.023.76-.578 1.291-1.354 1.291m3.291-6.531c-.184.26-.588.586-1.098.983l-.562.387q-.46.358-.563.688c-.056.174-.082.221-.087.576v.09H8.685l.006-.182c.027-.744.045-1.184.354-1.547c.485-.568 1.555-1.258 1.6-1.287a1.7 1.7 0 0 0 .379-.387c.225-.311.324-.555.324-.793c0-.334-.098-.643-.293-.916c-.188-.266-.545-.398-1.061-.398c-.512 0-.863.162-1.072.496c-.216.341-.325.7-.325 1.067v.092H6.386l.004-.096c.057-1.353.541-2.328 1.435-2.897c.563-.361 1.264-.544 2.081-.544c1.068 0 1.972.26 2.682.772c.721.519 1.086 1.297 1.086 2.311c-.001.567-.18 1.1-.534 1.585" class="contrast" />
        </svg>
        <div id='add-year'> &copy; Berkeley County Government </div>
        <div>App Version: 0.0.0</div>
        <a href='../changelog/index.html' target='_blank'>App Version: 0.0.0</a>
        <!-- </?php echo $_SESSION['appVersion'] ?></a> -->
    </footer>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

</html>