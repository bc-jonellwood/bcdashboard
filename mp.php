<?php
// Created: 2024/12/16 08:01:24
// Last modified: 2024/12/17 11:38:02

include "./components/header.php";

?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <!-- <h1>Motorpool</h1> -->
    <div class="content">
        <div id="motorpool-content" class="motorpool-content container">
            <div class="row">
                <!-- <div class="col-md-6"> -->
                <form id="mp-form">
                    <div class="mp-select-form">
                        <div class="form-group row">
                            <label for="mp-pickup-date" class="col-sm-4 col-form-label">Pickup Date:</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" id="mp-pickup-date" name="mp-pickup-date" onchange="setReturnDateValue(this.value)" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mp-return-date" class="col-sm-4 col-form-label">Return Date:</label>
                            <div class="col-sm-8">
                                <input type="datetime-local" id="mp-return-date" name="mp-return-date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mp-occupancy" class="col-sm-4 col-form-label">Number of Occupants:</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" id="mp-occupancy" name="mp-occupancy" aria-describedby="occupantsHelpBlock" value="1" required min="1" max="5">
                                <p class="text-muted form-text" id="occupantsHelpBlock">Note: Total occupants including yourself as driver.</p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mp-destination" class="col-sm-4 col-form-label">80+ miles from Moncks Corner:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="mp-destination" name="mp-destination">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mp-cargo" class="col-sm-4 col-form-label">Extra Cargo Space Needed:</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="mp-cargo" name="mp-cargo">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="error-text">
                        <p id="mp-error-text"></p>
                    </div>
                    <input class="btn btn-primary" type="button" id="mp-submit" value="Find Available Vehicle" onclick="getAvailableVehicles()">
                </form>
                <!-- </div> -->
            </div>
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
            const destination = document.getElementById("mp-destination").value;
            // console.log(destination);
            const occupancy = document.getElementById('mp-occupancy').value;
            // console.log(occupancy);
            const cargo = document.getElementById('mp-cargo').value;
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
                                    <td>${vehicle.bVehCargoSpace === "1" ? 'Yes' : 'No'}</td>
                                </tr>
                            </table>
                            <img class="mp-vehicle-image" src="./images/fleet_images/${vehicle.iLegacyId}.jpg" alt="${vehicle.sVehName}">
                            <div>
                                <button class="btn btn-primary" onclick='reserveVehicle("${vehicle.sVehUid}")'>Reserve</button>
                                <p id="countdown"></p>
                            </div>

                        </div>
                        `;
                    });
                    document.getElementById('motorpool-results').innerHTML = html;
                    countDown();
                    // console.log(html);
                }
                return;
            }
        }

        window.addEventListener("load", function() {
            var now = new Date();
            var offset = now.getTimezoneOffset() * 60000;
            var adjustedDate = new Date(now.getTime() - offset);
            var formattedDate = adjustedDate.toISOString().substring(0, 16);
            var pDatetimeField = document.getElementById("mp-pickup-date");
            var rDatetimeField = document.getElementById("mp-return-date");
            pDatetimeField.value = formattedDate;
            rDatetimeField.value = formattedDate;

        });

        var timeId;

        function reserveVehicle(uid) {
            stopCountDown();
            // alert('Vehicle ' + uid + ' reserved');
            Toastify({
                text: 'Vehicle reserved',
                duration: 3000,
                close: true,
                gravity: 'bottom',
                position: 'right',
                className: 'info-toast',
                // backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                style: {
                    backgroundColor: 'linear-gradient(25 deg, #006,# 009, teal, #0f0)',
                },
                onClick: function() {
                    location.reload();
                }
            }).showToast();
        }

        function countDown() {
            var seconds = 10;

            function tick() {
                var counter = document.getElementById("countdown");
                seconds--;
                counter.innerHTML = "You have " + String(seconds) + " seconds to decide.";
                if (seconds > 0) {
                    timerId = setTimeout(tick, 1000);
                } else {
                    alert("Time's up!");
                    location.reload();
                }
            }
            tick();
        }

        function stopCountDown() {
            console.log('Clearing Timer:', timerId);
            clearTimeout(timerId);
            document.getElementById("countdown").innerHTML = "";
        }
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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

        input[type="checkbox"] {
            margin-left: 10px;
            height: 20px;
            width: 20px;
        }

        input[type="checkbox"]:checked {
            accent-color: var(--accent);
        }

        .info-toast {
            background: linear-gradient(25 deg, #006, #009, teal, #0f0) !important;
            /* background-color: linear-gradient(25 deg, #006, #009, teal, #0f0) !important; */
        }
    </style>