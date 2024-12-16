<?php
// Created: 2024/12/16 08:01:24
// Last modified: 2024/12/16 15:22:35

include "./components/header.php";

?>




<div class="main">
    <?php include "./components/sidenav.php" ?>
    <h1>Motorpool</h1>
    <div class="content">
        <div id="motorpool-content" class="motorpool-content">
            <form id="mp-form">
                <div class="mp-select-form">
                    <div class="mb-3 form-group w-50">
                        <label for="mp-pickup-date">Pickup Date:</label>
                        <input type="datetime-local" id="mp-pickup-date" name="mp-pickup-date" onchange="setReturnDateValue(this.value)" required>
                        <label for="mp-return-date">Return Date:</label>
                        <input type="datetime-local" id="mp-return-date" name="mp-return-date" required>
                    </div>
                    <div class="mb-3 form-group w-50">
                        <p>Destination:</p>
                        <div class="btn-group" rold="group">
                            <label for="mp-destination">Local (within 80 miles of Monkcs Corner)
                                <input type="radio" id="mp-destination" name="mp-destination" value="1" checked>
                            </label>
                            <label for="mp-destination">Out of Town (over 80 miles from Moncks Corner)
                                <input type="radio" id="mp-destination" name="mp-destination" value="2">
                            </label>
                        </div>
                    </div>
                    <div class="form-group w-50">
                        <label for="mp-occupancy">Number of Occupants:</label>
                        <input type="number" id="mp-occupancy" name="mp-occupancy" aria-describedby="occupantsHelpBlock" value="1" required>
                        <p class="text-muted form-text" id="occupantsHelpBlock">Note: Total occupants including yourself as driver.</p>
                        <label for="mp-cargo">Cargo Space Needed:
                            <input type="checkbox" id="mp-cargo" name="mp-cargo" required>
                        </label>
                    </div>
                </div>
                <div class="error-text">
                    <p id="mp-error-text"></p>
                </div>
                <input class="btn btn-primary" type="button" id="mp-submit" value="Find Available Code" onclick="getAvailableVehicles()">
            </form>
        </div>
        <div id="motorpool-results" class="motorpool-results">
        </div>
    </div>

    <script>
        function formatDateTime(dateTime) {
            let isoDate = dateTime;
            let sqlDate = isoDate.replace("T", " ");
            return sqlDate;
        }

        function setReturnDateValue(val) {
            const pickupDate = document.getElementById('mp-pickup-date').value;
            document.getElementById('mp-return-date').value = pickupDate;
        }

        function checkReturnIsAfterStart() {
            const pickupDate = document.getElementById('mp-pickup-date').value;
            const returnDate = document.getElementById('mp-return-date').value;
            const errorTextHolder = document.getElementById('mp-error-text');
            if (returnDate < pickupDate) {
                // alert('Return date must be after pickup date');
                errorTextHolder.innerText = 'Return date must be after pickup date';
                document.getElementById('mp-return-date').value = pickupDate;
                return false;
            } else {
                errorTextHolder.innerText = '';
                return true;
            }
        }

        function checkForEmpty() {
            const pickupDate = document.getElementById('mp-pickup-date').value;
            const returnDate = document.getElementById('mp-return-date').value;
            const occupancy = document.getElementById('mp-occupancy').value;
            const errorTextHolder = document.getElementById('mp-error-text');
            if (pickupDate === '' || returnDate === '' || occupancy === '') {
                errorTextHolder.innerText = 'All fields must be filled out';
                return false;
            } else {
                errorTextHolder.innerText = '';
                return true;
            }
        }

        async function getAvailableVehicles() {
            const pickupDate = document.getElementById('mp-pickup-date').value;
            const sqlPickupDate = formatDateTime(pickupDate);
            // console.log(sqlPickupDate);
            const returnDate = document.getElementById('mp-return-date').value;
            const sqlReturnDate = formatDateTime(returnDate);
            // console.log(sqlReturnDate);
            const destination = document.querySelector('input[name="mp-destination"]:checked').value;
            // console.log(destination);
            const occupancy = document.getElementById('mp-occupancy').value;
            // console.log(occupancy);
            const cargo = document.getElementById('mp-cargo').checked;
            // console.log(cargo);
            if (checkForEmpty()) {
                if (checkReturnIsAfterStart()) {
                    const data = {
                        'mp-occupancy': occupancy,
                        'mp-cargo': cargo,
                        'sqlPickupDate': sqlPickupDate,
                        'sqlReturnDate': sqlReturnDate
                    };
                    const response = await fetch('./API/mpGetAvailable.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    const vehicles = await response.json();
                    console.log(vehicles);
                    let html = '';
                    vehicles.map(vehicle => {
                        html += `
                        <div class="mp-vehicle">
                            <table class="table table-sm">
                                <tr><th>Vehicle Name</th><th>Max Occupancy</th><th>Odometer</th></tr>
                                <tr>
                                    <td>${vehicle.sVehName}</td>
                                    <td>${vehicle.iVehMaxOccupancy}</td>
                                    <td>${vehicle.iVehOdometer}</td>
                                </tr>
                                <tr><th>Unit Number</th><th>Location ID</th><th>Cargo Space</th></tr>
                                    <tr>
                                    <td>${vehicle.sVehUnitNum}</td>
                                    <td>${vehicle.sLocName}</td>
                                    <td>${vehicle.bVehCargoSpace ? 'True' : 'False'}</td>
                                </tr>
                            </table>
                        </div>
                        `;
                    });
                    document.getElementById('motorpool-results').innerHTML = html;
                    console.log(html);
                }
                return;
            }
        }

        window.addEventListener("load", function() {
            var now = new Date();
            var offset = now.getTimezoneOffset() * 60000;
            var adjustedDate = new Date(now.getTime() - offset);
            var formattedDate = adjustedDate.toISOString().substring(0, 16); // For minute precision
            var pDatetimeField = document.getElementById("mp-pickup-date");
            var rDatetimeField = document.getElementById("mp-return-date");
            pDatetimeField.value = formattedDate;
            rDatetimeField.value = formattedDate;

        });
    </script>

    <?php include './components/footer.php'; ?>

    <style>
        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            padding: 20px;
        }

        .motorpool-content {
            margin-left: 20px;
            /* margin-right: auto; */
            padding: 20px;
        }

        .motorpool-results {
            /* margin-left: auto; */
            margin-right: 20px;
            padding: 20px;
        }

        .error-text p {
            color: red;
        }

        .table {
            border: none !important;
            color: var(--fg) !important;
            background-color: var(--bg) !important;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border: none !important;
        }

        th {
            border-top: 1px solid var(--accent) !important;
        }
    </style>