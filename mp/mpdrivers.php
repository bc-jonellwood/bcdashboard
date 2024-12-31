<?php
// Created: 2024/12/31 08:41:39
// Last modified: 2024/12/31 13:33:56
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/Driver.php');
include(dirname(__FILE__) . '/../mp/mpnav.php');

$driver = new Driver();
$drivers = $driver->getDrivers();
?>
<link rel="stylesheet" type="text/css" href="mp.css">
<div class="main">
    <div class="content">
        <div class="driver-content" id="driver-content"></div>
    </div>
</div>
<div class="updateDLpopover" id="updateDLpopover" name="updateDLpopover" popover=manual>
    <button class="btn-close" popovertarget="updateDLpopover" popovertargetaction="hide">
        <span aria-hidden=”true”>❌</span>
        <span class="sr-only">Close</span>
    </button>
    <div id="updateDLpopover-content"></div>
</div>
<?php include(dirname(__FILE__) . '/../components/footer.php')  ?>
<script src="/classes/Driver.js"></script>
<script>
    let drivers = <?php echo json_encode($drivers); ?>;
    console.log(drivers);

    function renderDrivers(drivers) {
        let content = `<h1>Motor Pool Drivers</h1>
                <table class="table table-sm table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Employee Number</th>
                            <th>DL Expiration</th>
                            <th>Fleet Test Passed</th>
                            <th>Fuel Card Test Passed</th>
                            <th>Acknowledge Received</th>
                            <th>Latest Fleet Test Attempt</th>
                            <th>Total Fleet Test Attempts</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>`;
        drivers.forEach(driver => {
            content += `<tr>
                            <td>${driver.sFirstName} ${driver.sLastName}</td>
                            <td>${driver.sEmployeeNumber}</td>
                            <td class="dtDlExpiration ${driver.dtDlExpires && new Date(driver.dtDlExpires) < new Date() ? 'expired' : ''}">${driver.dtDlExpires ? formatDate(driver.dtDlExpires) : '-'}
                                <button class="btn btn-sm btn-info" 
                                value="${driver.id}" 
                                popovertarget="updateDLpopover" 
                                popovertargetaction="show" 
                                onclick="createUpdateForm('date', 'dtDlExpires', '${driver.id}', 'updateDLpopover-content')"
                                id="dlExpiration"
                                >Update</button> </td>
                            <td>${driver.dtFleetTestPassed ? formatDate(driver.dtFleetTestPassed) : 'No'}</td>
                            <td>${driver.dtFuelCardTestPassed ? formatDate(driver.dtFuelCardTestPassed) : 'No'}</td>
                            <td class="dtAcknowledge">${driver.dtAcknowledge ? formatDate(driver.dtAcknowledge) : 'No'}
                            <button class="btn btn-sm btn-info" 
                                value="${driver.id}" 
                                popovertarget="updateDLpopover" 
                                popovertargetaction="show" 
                                onclick="createUpdateForm('date', 'dtAcknowledge', '${driver.id}', 'updateDLpopover-content')"
                                id="dtAcknowledge"
                                >Update</button>
                            </td>
                            <td>${driver.dtLatestFleetTestAttempt ? formatDate(driver.dtLatestFleetTestAttempt) : '-'}</td>
                            <td>${driver.iTotalFleetTestAttempts ? driver.iTotalFleetTestAttempts : '-'}</td>
                            <td>${driver.sNotes ? driver.sNotes : 'None'}</td>
                        </tr>`;
        });
        content += `</tbody>
                </table>`;
        document.getElementById('driver-content').innerHTML = content;
    }
    renderDrivers(drivers);

    function localeDate(str) {
        const date = new Date(str + 'T00:00:00');
        const localeDate = date.toLocaleDateString('en-US');
        return localeDate;
    }

    function formatDate(str) {
        const date = new Date(str);
        const day = date.getDate();
        const month = date.getMonth() + 1;
        const year = date.getFullYear();
        // const formattedDate = `${month}/${day}/${year}`;
        // const localeDate = formattedDate.toLocaleDateString('en-US');
        return `${month}/${day}/${year}`;
        // return localeDate;
    }

    function createUpdateForm(type, field, uid, target) {
        let form = `<form id="update-${field}-${uid}" class="update-form">
            <input type=${type} name="value" id="value-${field}-${uid}" placeholder="Enter new value">
            <button type="button" onclick="updateDriver('${uid}', '${field}', document.getElementById('value-${field}-${uid}').value)" class="btn btn-primary">Update</button>
        </form>`;
        document.getElementById(target).innerHTML = form;
    }

    async function updateDriver(id, field, val) {
        console.log(id, field, val)
        await fetch("/API/updateDriver.php", {
                method: "POST",
                body: JSON.stringify({
                    id: id,
                    field: field,
                    val: val,
                }),
                headers: {
                    "Content-Type": "application/json",
                },
            })
            .then(console.log('sending to API'))
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error("Error updating driver:", data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }
</script>

<style>
    .dtAcknowledge,
    .dtDlExpiration {
        display: flex;
        justify-content: space-between;
        gap: 5px;
    }

    ::backdrop {
        filter: blur(5px) !important;
    }

    table tr th {
        max-width: 15% !important;
    }
</style>