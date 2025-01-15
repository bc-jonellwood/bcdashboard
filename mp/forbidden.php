<?php
// Created: 2024/12/19 13:12:55
// Last modified: 2025/01/15 12:09:11

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../mp/mpnav.php');
AccessControl::enforce(104);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<div class="main">
    <div class="content">
        <p>If you are seeing this our records indicate there are some requirements to book a vehicle that we have in recorded.</p>
        <div id="userData"></div>
    </div>
</div>

<script>
    let fleetTestPassed;
    let acknowledgeReceived;
    let driverLicenseExpired;
    let driverLicenseExDateReceived;

    function renderUserData() {
        var userData = JSON.parse(localStorage.getItem('bcdash-userData'));

        fleetTestPassed = userData.dtFleetTestPassed !== null;
        // fuelCardTestPassed = userData.dtFuelCardTestPassed !== null;
        acknowledgeReceived = userData.dtAcknowledge !== null;
        driverLicenseExDateReceived = userData.dtDlExpires !== null;
        driverLicenseExpired = userData.dtDlExpires !== null && new Date(userData.dtDlExpires) < new Date();

        let html = `
            <div>
                <h2>Our records show</h2>
            <div>
            <div class='motorPoolTest section' id='motorPoolTest'>
                <p class='bool ${fleetTestPassed}'>Motor Pool Test Passed </p>`
        if (!fleetTestPassed) {
            html += `
                    <p>Use the follwing link to take the Motor Pool Test. Once succesfully completed return to the vehicle booking page.</p>
                    <a href="/mptest/index.html" target="_blank">Motor Pool Test</a>
                    `
        }
        // html += `</div>
        //     <div class='fuelCardTest section' id='fuelCardTest'>
        //         <p class='bool ${fuelCardTestPassed}'>Fuel Card Test Passed </p>`
        // if (!fuelCardTestPassed) {
        //     html += `
        //             <p>Use the follwing link to take the Fuel Card Test. Once succesfully completed return to the vehicle booking page.</p>
        //             <a href="/fctest/index.html" target="_blank">Fuel Card Test</a>
        //             `
        // }
        html += `</div>
            <div class='acknowledgement section' id='acknowledgement'>
                <p class='bool ${acknowledgeReceived}'>Acknowledgement Received </p>`
        if (!acknowledgeReceived) {
            html += `
                    <p>Use the follwing link to Download the Acknowledgement Form. Once received by Fleet they will update your records</p>
                    <p>If you have your form ready to submit use this link 👉 <a href='mailto:daniel.corbin@berkeleycountysc.gov'>Email Form</a></p>
                    `
        }
        html += `</div>
            <div class='driversLicense section' id='driversLicense'>
                <p class='bool ${driverLicenseExDateReceived}'>Driver License Expiration Date on File </p>
                `
        if (!driverLicenseExDateReceived) {
            html += `
                    <p>Use the follwing link to email a copy of your Driver License(front and back). Once received by Fleet they will update your records</p>
                    <p>If you have your form ready to submit use this link 👉 <a href='mailto:daniel.corbin@berkeleycountysc.gov'>Email DL</a></p>
                    `
        }
        if (driverLicenseExDateReceived) {
            html += `
            <p class='bool ${driverLicenseExpired}'>Driver License Expired: ${userData.dtDlExpires}</p>
            `
        }
        html += `
                
            </div>
            </div>
        `;
        document.getElementById('userData').innerHTML = html;
    }
    renderUserData();
</script>

<style>
    .bool {
        text-transform: capitalize;
        font-size: larger;
        padding: 10px;
    }

    .true::after {
        content: '🗸';
        color: green;
    }

    .false::after {
        content: '🗴';
        color: red;
    }

    .section {
        margin: 20px;
        border: 1px solid var(--accent);
        padding: 10px;
    }
</style>


<!-- // var dlTarget = document.getElementById('driversLicense');
// var dlHtml = `
// <p>Use the follwing link to take the Motor Pool Test. Once succesfully completed return to the vehicle booking page.</p>
// <a href="/mptest/index.html" target_>Motor Pool Test</a>
// `;
// dlTarget.innerHTML = dlHtml; -->
<!-- // var fcTarget = document.getElementById('fuelCardTest');
// var fcHtml = `
// <p>Use the follwing link to take the Fuel Card Test. Once succesfully completed return to the vehicle booking page.</p>
// <a href="/fctest/index.html" target_>Fuel Card Test</a>
// `;
// fcTarget.innerHTML = fcHtml; -->