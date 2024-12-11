<?php
include_once '../data/unify-api-config.php';
$id = $_GET['id'];
echo $id;
// Initialize a cURL session
$ch = curl_init();

// Set the URL for the cURL request
curl_setopt($ch, CURLOPT_URL, 'https://api.ui.com/ea/hosts/' . $id);

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
    <title>Unify Hosts</title>
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
            <h2>This will be a detailed page for each host</h2>
            <div class="unify" id="unify">
                <!-- </?php echo json_encode($data, JSON_PRETTY_PRINT); ?> -->
            </div>
        </div>
    </div>

</body>
<script>
    async function getSingleHost(data) {
        var html = '';
        await fetch('getUnifiHostsById.php?id=')
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                // console.log(data.data.length)
                for (let i = 0; i < data.data.length; i++) {
                    // console.log(data[i]);
                    const host = data.data[i];
                    // console.log('host');
                    console.log(host);
                    html += `<div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${host.reportedState.name}</h5>
                                <p class="card-text">Last Connection State Change:<br> ${formatDateTime(host.lastConnectionStateChange)}</p>
                                <p class="card-text">Type: ${host.type} | IP Addresss:${host.ipAddress}</p>
                                <p class="card-text">Last Connection State Change: ${calcTimeBetween(host.lastConnectionStateChange)} ago </p>
                                <span class="card-text card-span">Last Reported State: <p class="${host.reportedState.apps[0].controllerStatus}"> ${host.reportedState.apps[0].controllerStatus}</p> </span>
                                <a href="https://${host.ipAddress}" class="btn btn-primary" target="_blank">Go to ${host.reportedState.hostname}</a>
                            </div>
                        </div>`;

                }
                document.getElementById('unify').innerHTML = html;
            })
            .catch((error) => {
                console.error('Error:', error);
            });

    }
    getSingleHost(<?php echo json_encode($data); ?>);
    // <p class="card-text">Last Connection State Change:  ${host.lastConnectionStateChange ? formatDateTime(host.lastConnectionStateChange) : 'UNK'} | ${calcTimeBetween(host.lastConnectionStateChange)} ago </p>
</script>

</html>

<style>
    .unify {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    }

    .card {
        margin: 10px;
        /* width: 18rem; */
        min-height: 25rem;
        /* Ensure all cards have the same height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Ensure the button is at the bottom */
    }

    .card-title {
        font-size: 1.5rem;
        padding-left: 5px;
        padding-right: 5px;
        /* color: dodgerblue; */
        color: black;
        font-weight: bold;
        /* background: linear-gradient(180deg, #006, #009, #09909950, #eee); */
        background: linear-gradient(180deg, #0d6efd, #eee);
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .card-text {
        font-size: 1rem;

    }

    .card-span {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .card-text-larger {
        font-size: 1.5rem;
    }

    .card-body {
        background-color: #f8f9fa;
        color: black;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Ensure the button is at the bottom */
    }

    .READY {
        color: green;
        background-color: lightgreen;
        width: min-content;

    }

    .UNK {
        color: red;
        background-color: pink;
        width: min-content;

    }
</style>