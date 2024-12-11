<?php
include_once '../data/unify-api-config.php';
// $id = $_GET['id'];
// echo $id;
// Initialize a cURL session
$ch = curl_init();

// Set the URL for the cURL request
curl_setopt($ch, CURLOPT_URL, 'https://api.ui.com/ea/devices');

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
    // echo json_encode($data, JSON_PRETTY_PRINT);
}

// Close the cURL session
curl_close($ch);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="unify.css">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <script src="utils.js"></script>
    <title>Unify Devices</title>
    <script>
        function formatDateTime(dateTimeString) {
            var date = new Date(dateTimeString);
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes.toString().padStart(2, '0');
            // var formattedDateTime = date.getFullYear() + '/' + date.getMonth() + '/' + date.getDate() + ' ' + hours + ':' + minutes + ' ' + ampm;
            var formattedDateTime = date.getMonth() + '/' + date.getDate() + '/' + date.getFullYear() + ' ' + hours + ':' + minutes + ' ' + ampm;
            return formattedDateTime;
        }
        // function to make minutes human readable
        function calculateMinToHumanReadable(min) {
            var hours = Math.floor(min / 60);
            var minutes = min % 60;
            var days = Math.floor(hours / 24);
            var years = Math.floor(days / 365);

            if (years > 0) {
                days = days % 365; // Only modify days after extracting years
                return years.toLocaleString() + ' years ' + days.toLocaleString() + ' days ' + hours % 24 + ' hours ' + minutes + ' minutes';
            } else if (days > 0) {
                return days.toLocaleString() + ' days ' + hours % 24 + ' hours ' + minutes + ' minutes';
            } else {
                return hours.toLocaleString() + ' hours ' + minutes + ' minutes';
            }
        }
        // function to calclate the time difference between a date string and now
        function calcTimeBetween(str) {
            var dateA = new Date(str);
            var dateB = new Date();
            var diff = dateB - dateA;
            var diffInMinutes = Math.floor(diff / 60000);
            return calculateMinToHumanReadable(diffInMinutes);
        }
    </script>
</head>

<body>
    <div class="main">
        <div class="content">
            <nav class="navbar">
                <ul class="nav-list">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="sites.php">Sites</a></li>
                    <li class="nav-item"><a class="nav-link" href="devices.php">Devices</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
                </ul>
            </nav>

            <div class="unify" id="unify">
                <!-- </?php echo json_encode($data, JSON_PRETTY_PRINT); ?> -->
            </div>
        </div>
    </div>
</body>
<script>
    // var data = </?php echo json_decode($data); ?>
    // console.log(data);

    function getSingleHost(data) {
        console.log(data);
        var html = '';

        for (let i = 0; i < data.data.length; i++) {
            var host = data.data[i];
            html += `<details class="card-full-width">
                        <summary class="card-title">${host.hostName} - Updated: ${calcTimeBetween(host.updatedAt)}</summary>
                        <div class="card-body">
                            
                            <table>
                            <tr>
                                <th>Status</th>
                                <th>Startup Time</th>
                                <th>Model</th>
                                <th>Name</th>
                                <th>IP</th>
                                <th>Firmware Status</th>
                                <th>Firmware Version</th>
                                <th>Update Available</th>
                            </tr>
                            `;
            for (let j = 0; j < host.devices.length; j++) {
                var device = host.devices[j];
                html += `<tr>
                            <td class='${device.status}'>${device.status}</td>
                            <td>${formatDateTime(device.startupTime)}</td>
                            <td>${device.model}</td>
                            <td>${device.name}</td>
                            <td>${device.ip}</td>
                            <td>${device.firmwareStatus}</td>
                            <td>${device.version}</td>
                            <td>${device.updateAvailable}</td>
                            `;
            }
            html += `    </table>
                        </div>
                    </details>`;
        }
        document.getElementById('unify').innerHTML = html;
    }
    getSingleHost(<?php echo json_encode($data); ?>);
</script>

</html>
<style>
    .unify {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .card-full-width {
        width: 90%;
        margin: auto;
    }
</style>