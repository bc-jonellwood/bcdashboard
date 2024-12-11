<?php
include_once '../data/unify-api-config.php';
$id = $_GET['id'];
echo $id;
// Initialize a cURL session
$ch = curl_init();

// Set the URL for the cURL request
curl_setopt($ch, CURLOPT_URL, 'https://api.ui.com/ea/isp-metrics/1h?beginTimestamp=2024-12-11T10:35:00Z&endTimestamp=2024-12-11T15:35:00Z');

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
    echo '<script>var chartData = ' . json_encode($data) . ';</script>';
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
    <title>ISP Metics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var data = <?php echo json_encode($data); ?> // Use the data from the PHP script
            // console.log(data.data[0].periods);
            let labels = [];
            for (let i = 0; i < data.data[0].periods.length; i++) {
                labels.push(data.data[0].periods[i].metricTime);
            }
            console.log(labels);
            // Process the data to fit the Chart.js format
            console.log(data.data[0].periods);
            let values = [];
            for (let j = 0; j < data.data.length; j++) {
                values.push(data.data[j].periods[j].data.wan.avgLatency);
            }
            console.log(values);
            // var labels = data.data[0].periods.map(item => item.metricTime)
            // var values = data.data.map(function(item) {
            // return item.value;
            // });

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'ISP Metrics',
                        data: values,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'hour'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>