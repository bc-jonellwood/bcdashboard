<?php
// Created: 2024/12/17 09:22:51
// Last modified: 2024/12/17 13:28:23

include "./components/header.php";
include "./classes/Vehicle.php";
$vehicle = new Vehicle();
$vehicles = $vehicle->getVehicles();


?>
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="vehicle-content" id="vehicle-content"></div>
    </div>
</div>
<div class="updatemileagepopover" id="updatemileagepopover" name="updatemileagepopover" popover=manual>
    <button class="close-btn" popovertarget="updatemileagepopover" popovertargetaction="hide">
        <span aria-hidden=”true”>❌</span>
        <span class="sr-only">Close</span>
    </button>
    <div id="updatemileagepopover-content"></div>
</div>
<?php include "./components/footer.php" ?>
<script src="./classes/Vehicle.js"></script>
<script>
    let vehicles = <?php echo json_encode($vehicles); ?>;

    function getVehicles(vehicles) {
        // await fetch('./API/mpGetVehicles.php')
        // .then(response => response.json())
        // .then(data => {
        // console.log(data);
        // console.log('vehicles');
        // console.log(JSON.stringify(vehicles));
        let content = `<h1>Motor Pool Vehicles</h1>
                <table class="table table-sm table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>Vehicle Name</th>
                            <th>Unit Number</th>
                            <th>Max Occupancy</th>
                            <th>Odometer</th>
                            <th>VIN</th>
                            <th>Next Service Odometer</th>
                            <th>Location</th>
                            <th>Retired</th>
                            <th>Out for Service</th>
                        </tr>
                    </thead>
                    <tbody>`;
        vehicles.forEach(vehicle => {
            // console.log(typeof(vehicle.bIsRetired));
            content += `<tr class="${vehicle.bIsRetired === "1" ? 'retired' : ''} ${vehicle.bOutForService === "1" ? 'out-for-service' : ''}">
                        <td class='align-left'>${vehicle.sVehName}</td>
                        <td>${vehicle.sVehUnitNum}</td>
                        <td>${vehicle.iVehMaxOccupancy}</td>
                        <td>${vehicle.iVehOdometer}</td>
                        <td>${vehicle.sVehVin}</td>
                        <td>${vehicle.iVehNextServiceOdometer}</td>
                        <td class='align-left'>${vehicle.sLocName.toLowerCase()}</td>
                        <td>
                            ${vehicle.bIsRetired === "1" ? 'Yes' : 'No'} <br>
                            ${vehicle.bIsRetired === "0" ? '<button class="btn btn-sm btn-danger" onclick="updateVehicleStatus(\'' + vehicle.sVehUid + '\', \'bIsRetired\', \'1\')">Retire</button>' : ''}
                            ${vehicle.bIsRetired === "1" ? '<button class="btn btn-sm btn-primary" onclick="updateVehicleStatus(\'' + vehicle.sVehUid + '\', \'bIsRetired\', \'0\')">Unretire</button>' : ''}
                        </td>
                        <td>
                            ${vehicle.bOutForService === "1" ? 'Yes' : 'No'} <br>
                            ${vehicle.bOutForService === "1" ? '<button class="btn btn-sm btn-primary" onclick="updateVehicleStatus(\'' + vehicle.sVehUid + '\', \'bOutForService\', \'0\')">Return</button>' : ''}
                            ${vehicle.bOutForService === "0" ? '<button class="btn btn-sm btn-danger" onclick="updateVehicleStatus(\'' + vehicle.sVehUid + '\', \'bOutForService\', \'1\')">Take Out</button>' : ''}
                        </td>
                    </tr>`;
        });
        content += `</tbody>
                </table>`;
        document.getElementById('vehicle-content').innerHTML = content;
        // });
    }

    function updateVehicleStatus(id, field, value) {
        fetch('./API/updateVehicle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id,
                    field,
                    value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error('Error updating vehicle:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    getVehicles(vehicles);

    function formatDateAndTime(str) {
        const date = new Date(str);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes.toString().padStart(2, '0');
        return `${month}/${day}/${year} @ ${hours}:${minutes} ${ampm}`;
    }

    function createUpdateForm(field, uid, target) {
        let form = `<form id="update-${field}-${uid}" class="update-form">
            <input type="text" name="value" id="value-${field}-${uid}" placeholder="Enter new value">
            <button type="submit" onclick="updateVehicle('${uid}', '${field}', document.getElementById('value-${field}-${uid}').value)">Update</button>
        </form>`;
        document.getElementById(target).innerHTML = form;
        // return form;
    }
</script>

<style>
    .main {
        margin: 20px;
    }

    .reservations-content {
        margin: 20px;
    }

    .table {
        border: none !important;
        color: var(--fg) !important;
        background-color: var(--bg) !important;
        font-size: large !important;
        text-transform: capitalize;
    }

    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
        /* border: none !important; */
        text-align: center;
    }

    th {
        border-bottom: 1px solid var(--accent) !important;
        text-align: center;
    }

    td {
        padding: 0.5rem !important;
    }

    .align-left {
        text-align: left !important;
    }

    .retired {
        color: gray;
    }

    .out-for-service {
        color: aliceblue;
    }

    .close-btn {
        border: none;
        background: none;
        position: absolute;
        right: 0.25rem;
        top: 0.5rem;
        filter: grayscale() brightness(10);
    }

    .updatemileagepopover {
        background: var(--fg);
        color: var(--bg);
        font-weight: 400;
        padding: 1rem;
        /* max-width: 200px; */
        line-height: 1.4;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        margin: 0 auto;
        padding-top: 2rem;
        /* backdrop-filter: blur(10px);
        backdrop-filter: opacity(0.5); */
    }

    :popover-open {
        backdrop-filter: blur(10px);
    }
</style>