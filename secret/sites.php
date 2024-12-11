<?php
include_once '../data/unify-api-config.php';
// $id = $_GET['id'];
// echo $id;
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
    <title>Unify Sites</title>
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
            <div class="unify" id="unify"></div>
        </div>
    </div>

</body>
<script>
    async function getSites(data) {
        var html = '';
        // console.log(data);
        for (let i = 0; i < data.data.length; i++) {
            // console.log(data[i]);
            const site = data.data[i];
            // console.log('host');
            console.log('site');
            console.log(site);
            html += `<div class="card">
            <div class='card-body'>
                <h5 class="card-title">${site.siteId}</h5>
                <table>
                    <tr>
                        <th>critical Notification</th>
                        <td>${site.statistics.counts.criticalNotification}</td>
                    </tr>
                    <tr>
                        <th>Gateway Device:</th>
                        <td>${site.statistics.counts.gatewayDevice}</td>
                    </tr>
                    <tr>
                        <th>Guest Client</th>
                        <td>${site.statistics.counts.guestClient}</td>
                    </tr>
                    <tr>
                        <th>LAN Configuration</th>
                        <td>${site.statistics.counts.lanConfiguration}</td>
                    </tr>
                    <tr>
                        <th>Offline Device</th>
                        <td>${site.statistics.counts.offlineDevice}</td>
                    </tr>
                    <tr>
                        <th>Offline Gateway Device</th>
                        <td>${site.statistics.counts.offlineGatewayDevice}</td>
                    </tr>
                    <tr>
                        <th>Offline Wifi Device</th>
                        <td>${site.statistics.counts.offlineWifiDevice}</td>
                    </tr>
                    <tr>
                        <th>Offline Wired Device</th>
                        <td>${site.statistics.counts.offlineWiredDevice}</td>
                    </tr>
                    <tr>
                        <th>Pending Update Device</th>
                        <td>${site.statistics.counts.pendingUpdateDevice}</td>
                    </tr>
                    <tr>
                        <th>Total Device</th>
                        <td>${site.statistics.counts.totalDevice}</td>
                    </tr>
                    <tr>
                        <th>WAN Configuration</th>
                        <td>${site.statistics.counts.wanConfiguration}</td>
                    </tr>
                    <tr>
                        <th>Wifi Client</th>
                        <td>${site.statistics.counts.wifiClient}</td>
                    </tr>
                    <tr>
                        <th>Wifi Configuration</th>
                        <td>${site.statistics.counts.wifiConfiguration}</td>
                    </tr>
                    <tr>
                        <th>Wifi Device</th>
                        <td>${site.statistics.counts.wifiDevice}</td>
                    </tr>
                    <tr>
                        <th>Wired Client</th>
                        <td>${site.statistics.counts.wiredClient}</td>
                    </tr>
                    <tr>
                        <th>Wired Device</th>
                        <td>${site.statistics.counts.wiredDevice}</td>
                    </tr>
                    <tr>
                        <th>Internet Issues</th>
                        <td>${site.statistics.internetIssues}</td>
                    </tr>
                    
                    <tr>
                        <th>WAN Uptime %</th>
                        <td>${site.statistics.percentages.wanUptime}</td>
                    </tr>

                </table>
                </div>
                </div>`;

        }
        document.getElementById('unify').innerHTML = html;
    }
    getSites(<?php echo json_encode($data); ?>);
    // <p class="card-text">Last Connection State Change:  ${host.lastConnectionStateChange ? formatDateTime(host.lastConnectionStateChange) : 'UNK'} | ${calcTimeBetween(host.lastConnectionStateChange)} ago </p>
    // <tr>
    //     <th>ISP Info</th>
    //     <td>${site.statistics.ispInfo.name ? site.statistics.ispInfo.name : "unk" } - ${site.statistics.ispInfo.organization ? site.statistics.ispInfo.organization : 'unk'}</td>

    // </tr>
</script>

</html>
<style>
    .unify {
        grid-template-columns: 1fr 1fr;
    }
</style>