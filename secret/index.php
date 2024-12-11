<?php
// Created: 2024/12/10 13:33:32
// Last modified: 2024/12/11 09:25:58

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="../styles/reset.css"> -->
    <!-- <link rel="stylesheet" href="../styles/custom.css"> -->
    <!-- <link rel="stylesheet" href="../styles/theme.css"> -->
    <link rel="stylesheet" href="unify.css">
    <!-- favicon -->
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
            <div class="unify" id="unify">
            </div>
        </div>
    </div>
    <script>
        async function getHosts() {
            var html = '';
            await fetch('getUnifiHosts.php')
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data.data)
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
                                <a href="hostDetails.php?id=${host.id}" class="btn btn-primary" target="_blank">Go to ${host.reportedState.hostname}</a>
                            </div>
                        </div>`;

                    }
                    document.getElementById('unify').innerHTML = html;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

        }
        getHosts();
        // <p class="card-text">Last Connection State Change:  ${host.lastConnectionStateChange ? formatDateTime(host.lastConnectionStateChange) : 'UNK'} | ${calcTimeBetween(host.lastConnectionStateChange)} ago </p>
    </script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script> -->
</body>

</html>