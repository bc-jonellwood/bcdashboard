<?php
// Created: 2024/09/26 14:26:01
// Last modified: 2024/09/26 14:27:45
// session_start();
// include "./components/header.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
</head>

<body>
    <h1>Success! Your submission was received.</h1>
    <p>You can close this tab now.</p>
    <a href="./myNotifications.php">Go back</a>
</body>
<script>
    // function that will redirect the user back to myNotifications.php after 3 seconds after page load.
    setTimeout(function() {
        window.location.href = "./myNotifications.php";
    }, 3000);
</script>

</html>