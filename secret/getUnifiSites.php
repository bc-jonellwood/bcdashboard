<?php
// Created: 2024/12/10 13:23:01
// Last modified: 2024/12/10 13:37:41
include_once '../data/unify-api-config.php';
// Initialize a cURL session
$ch = curl_init();

// Set the URL for the cURL request
curl_setopt($ch, CURLOPT_URL, 'https://api.ui.com/ea/sites');

// Set the HTTP headers for the request
$headers = [
    'Accept: application/json',
    // 'Authorization: Bearer FceQRdzLWzNEnp5-iX3K9IjfptlJXofw' 
    'X-API-KEY: ' . $apikey,
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Return the response instead of outputting it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode the JSON response
    $data = json_decode($response, true);
    // Print the response data
    // print_r($data);
    echo json_encode($data, JSON_PRETTY_PRINT);
}

// Close the cURL session
curl_close($ch);
