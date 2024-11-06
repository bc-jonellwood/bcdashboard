<?php
// Created: 2024/11/06 15:18:51
// Last modified: 2024/11/06 15:44:41

// function startSession()
// {
//     try {
//         // Check if the session is already started
//         if (session_status() === PHP_SESSION_NONE) {
//             // Start the session
//             session_start();
//             // echo "Session started successfully.";
//         } else {
//             return;
//             // echo "Session is already active.";
//         }
//     } catch (Exception $e) {
//         // Handle any exceptions that occur during session start
//         error_log("Session start failed: " . $e->getMessage());
//         echo "An error occurred while starting the session.";
//     }
// }

// Call the function to manage session
// startSession();
echo "<div id='35068ab0-b00b-4484-b42c-320670ec6d76' class='dash-card'>";
echo "  <div class='card-content'>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "</div>";
echo "</div>";
