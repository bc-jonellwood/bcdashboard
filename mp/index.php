<?php
// Created: 2024/12/16 08:01:24
// Last modified: 2024/12/18 15:45:38
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../mp/mpnav.php');

?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<div class="main">
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
                                <input type="datetime-local" id="mp-pickup-date" name="mp-pickup-date" min="<?php echo date("Y-m-d") ?>" onchange="setReturnDateValue(this.value)" required>
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
            const pickupDate = new Date(val);
            checkStartDateIsFuture(pickupDate);
            pickupDate.setHours(pickupDate.getHours() + -4);
            const formattedDate = pickupDate.toISOString().substring(0, 16);
            document.getElementById('mp-return-date').value = formattedDate;
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

        function checkStartDateIsFuture(str) {
            // console.log('checking if start date is in the future', str);
            const errorTextHolder = document.getElementById('mp-error-text');
            if (str.toISOString().substring(0, 16) < new Date().toISOString().substring(0, 16)) {
                errorTextHolder.innerText = 'Pickup date must be in the future';
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
                    const response = await fetch('/API/mpGetAvailable.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });
                    const vehicles = await response.json();
                    // console.log(vehicles);
                    if (vehicles.length === 0) {
                        showFailToast("No vehicles found matching your criteria");
                        // alert('No vehicles found');
                        return;
                    }
                    const vehUid = vehicles[0].sVehUid;
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
                            <img class="mp-vehicle-image" src="/images/fleet_images/${vehicle.iLegacyId}.jpg" alt="${vehicle.sVehName}">
                            <div class="mp-vehicle-buttons">
                                <button class="btn btn-primary" onclick='reserveVehicle("${vehicle.sVehUid}")'>Reserve</button>
                                <button class="btn btn-secondary" onclick='startOver("${vehicle.sVehUid}")'>Reset</button>
                                <p id="countdown"></p>
                            </div>

                        </div>
                        `;
                    });
                    document.getElementById('motorpool-results').innerHTML = html;
                    countDown(vehUid);

                    // console.log('vehUid', vehUid);
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
            const pickupDate = document.getElementById('mp-pickup-date').value;
            const sqlPickupDate = formatDateTime(pickupDate);
            const returnDate = document.getElementById('mp-return-date').value;
            const sqlReturnDate = formatDateTime(returnDate);
            const vehUid = uid;
            const data = {
                sVehUid: vehUid,
                dtStart: sqlPickupDate,
                dtEnd: sqlReturnDate
            };
            fetch('/API/mpCreateReservation.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status === 'success') {
                        showSuccessToast(data.message);
                        makeVehAvailable(vehUid);
                        setTimeout(() => location.reload(), 3000);
                    } else {
                        showFailToast(data.message);
                        makeVehAvailable(vehUid);
                        setTimeout(() => location.reload(), 3000);
                    }
                });

        }

        function showSuccessToast(msg) {
            Toastify({
                text: msg,
                duration: 3000,
                close: true,
                gravity: 'bottom',
                position: 'right',
                className: 'info-toast',
                // backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                // style: {
                //     backgroundColor: 'linear-gradient(25 deg, #006,# 009, teal, #0f0)',
                // },
                onClick: function() {
                    setTimeout(() => location.reload(), 3000);
                }
            }).showToast();
        }

        function showFailToast(msg) {
            Toastify({
                text: msg,
                duration: 30000,
                close: true,
                gravity: 'bottom',
                position: 'right',
                className: 'fail-toast',
                // backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                // style: {
                //     backgroundColor: 'linear-gradient(25 deg, #a00,#a09, #ffa500)',
                // },
                onClick: function() {
                    setTimeout(() => location.reload(), 3000);
                }
            }).showToast();
        }


        function countDown(id) {
            console.log('Starting countdown:', id);
            var seconds = 60;

            function tick() {
                var counter = document.getElementById("countdown");
                seconds--;
                counter.innerHTML = "Vehicle will be held for " + String(seconds) + " seconds.";
                if (seconds > 0) {
                    timerId = setTimeout(tick, 1000);
                } else {
                    //alert("Time's up!");
                    showFailToast("Time's up!");
                    makeVehAvailable(id);
                    setTimeout(() => location.reload(), 3000);
                }
            }
            tick();
        }

        function stopCountDown() {
            console.log('Clearing Timer:', timerId);
            clearTimeout(timerId);
            document.getElementById("countdown").innerHTML = "";
        }

        async function makeVehAvailable(id) {
            console.log('Making vehicle available:', id);
            await fetch('/API/mpMakeVehAvailable.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    sVehUid: id
                })
            })
        }

        function startOver(id) {
            console.log('Starting over:', id);
            makeVehAvailable(id);
            setTimeout(() => location.reload(), 1000);
        }
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <?php include(dirname(__FILE__) . '/../components/footer.php'); ?>
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
            background: linear-gradient(25deg, #006, #009, teal, #0f0) !important;
        }

        .fail-toast {
            background: linear-gradient(25deg, #a00, #a09, #ffa500) !important;

        }

        .mp-vehicle-buttons {
            margin-top: 10px;
        }
    </style>